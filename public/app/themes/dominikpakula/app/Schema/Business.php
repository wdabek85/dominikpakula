<?php

namespace App\Schema;

use App\Services\ServiceCatalog;
use App\View\Composers\SiteSettings;

/**
 * Węzły firmy i osoby: ProfessionalService (#business) i Person (#person, ten sam @id co u Rank Math).
 *
 * Dane z CMS: telefon/Instagram/miasto bazowe („Ustawienia strony”), logo (Wygląd → Logo),
 * nazwa firmy (Rank Math → Knowledge Graph), ceny i miasta z CPT `service`.
 */
class Business
{
    public const PERSON_NAME = 'Dominik Pakuła';

    public const PERSON_JOB_TITLE = 'Stylista męski';

    public const FALLBACK_NAME = 'Dominik Pakuła – stylista męski';

    public static function id(): string
    {
        return \home_url('/#business');
    }

    public static function personId(): string
    {
        return \home_url('/#person');
    }

    public static function node(): array
    {
        $settings = SiteSettings::data();
        $logo = self::logoUrl();
        $offers = self::offers();
        $amounts = array_map(fn (array $offer) => (int) $offer['price'], $offers);

        $node = [
            '@type' => 'ProfessionalService',
            '@id' => self::id(),
            'name' => self::name(),
            'url' => \home_url('/'),
            'telephone' => $settings['contact']['phone_link'] ?? '',
            'logo' => $logo,
            'image' => $logo,
            'priceRange' => $amounts ? min($amounts) . '–' . max($amounts) . ' zł' : '',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $settings['contact']['address_line1'] ?? '',
                'addressCountry' => 'PL',
            ],
            'areaServed' => self::areaServed(),
            'founder' => ['@id' => self::personId()],
            'sameAs' => self::sameAs($settings),
        ];

        if ($offers) {
            $node['hasOfferCatalog'] = [
                '@type' => 'OfferCatalog',
                'name' => 'Usługi stylisty męskiego',
                'itemListElement' => $offers,
            ];
        }

        return self::clean($node);
    }

    public static function person(): array
    {
        $about = \get_page_by_path('o-mnie');

        return self::clean([
            '@type' => 'Person',
            '@id' => self::personId(),
            'name' => self::PERSON_NAME,
            'jobTitle' => self::PERSON_JOB_TITLE,
            'url' => $about ? \get_permalink($about) : '',
            'sameAs' => self::sameAs(SiteSettings::data()),
            'worksFor' => ['@id' => self::id()],
        ]);
    }

    /**
     * Pełny obszar działania: wszystkie miasta (podstrony usług) + cała Polska (online).
     */
    public static function areaServed(): array
    {
        $areas = array_map(
            fn (int $id) => ['@type' => 'City', 'name' => ServiceCatalog::cityName($id)],
            ServiceCatalog::cityIds()
        );
        $areas[] = ['@type' => 'Country', 'name' => 'Polska'];

        return $areas;
    }

    /**
     * Oferty usług głównych z ceną (pole service_price).
     */
    protected static function offers(): array
    {
        $offers = [];

        foreach (ServiceCatalog::topLevelIds() as $id) {
            $price = ServiceCatalog::priceAmount($id);

            if ($price === '') {
                continue;
            }

            $offers[] = [
                '@type' => 'Offer',
                'price' => $price,
                'priceCurrency' => 'PLN',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => ServiceNode::name($id),
                    'url' => \get_permalink($id),
                ],
            ];
        }

        return $offers;
    }

    protected static function name(): string
    {
        $name = class_exists('\RankMath\Helper') ? (string) \RankMath\Helper::get_settings('titles.knowledgegraph_name') : '';

        // „dominikpakula” = stara wartość z instalatora Rank Math, nie nazwa firmy.
        return ($name !== '' && $name !== 'dominikpakula') ? $name : self::FALLBACK_NAME;
    }

    protected static function logoUrl(): string
    {
        $logoId = (int) \get_theme_mod('custom_logo');

        return $logoId ? (string) \wp_get_attachment_image_url($logoId, 'full') : '';
    }

    protected static function sameAs(array $settings): array
    {
        return array_values(array_filter([
            $settings['social']['instagram'] ?? '',
            $settings['social']['facebook'] ?? '',
            $settings['social']['tiktok'] ?? '',
        ]));
    }

    /**
     * Usuwa puste pola (np. brak logo), żeby nie wysyłać "logo": "".
     */
    protected static function clean(array $node): array
    {
        return array_filter($node, fn ($value) => $value !== '' && $value !== [] && $value !== null);
    }
}
