<?php

namespace App\View\Composers;

use App\Services\ServiceCatalog;
use Roots\Acorn\View\Composer;

class OfferBlockComposer extends Composer
{
    protected static $views = [
        'blocks.offer.index',
    ];

    public function with(): array
    {
        $variant = \get_field('offer_card_variant') ?: 'compact';
        $cards = $this->cards($variant);

        return [
            'label' => \get_field('offer_label') ?: '',
            'title' => wp_kses_post(\get_field('offer_title') ?: ''),
            'cards' => $cards,
            'cardVariant' => $variant,
            // 4 karty w rzędzie tylko gdy równo wychodzi — 5 usług układa się 3 + 2 zamiast 4 + 1
            'gridColumns' => count($cards) % 4 === 0 ? 'lg:grid-cols-4' : 'lg:grid-cols-3',
            'buttonText' => \get_field('offer_button_text') ?: '',
            // Starsze bloki mają zapisane pole pod nazwą z literówką `offer_button_url_`
            'buttonUrl' => \get_field('offer_button_url') ?: (\get_field('offer_button_url_') ?: ''),
        ];
    }

    protected function cards(string $variant): array
    {
        $source = \get_field('offer_source') ?: 'manual';

        if ($source === 'manual') {
            return $this->manualCards();
        }

        $ids = $source === 'pick' ? (\get_field('offer_services') ?: []) : ServiceCatalog::topLevelIds();

        return array_map(fn (array $service) => [
            'title' => $service['title'],
            'icon' => $service['icon'],
            'description' => $variant === 'detailed' ? $service['description'] : $service['excerpt'],
            'price' => $service['price'],
            'linkText' => $variant === 'detailed' ? 'Dowiedz się więcej' : 'Sprawdź szczegóły',
            'linkUrl' => $service['url'],
        ], ServiceCatalog::cards($ids));
    }

    /**
     * Stary tryb: karty wpisane ręcznie w bloku.
     */
    protected function manualCards(): array
    {
        $cards = [];

        foreach (\get_field('offer_cards') ?: [] as $card) {
            $cards[] = [
                'title' => $card['offer_card_title'] ?? '',
                'icon' => $card['offer_card_icon'] ?? null,
                'description' => $card['offer_card_description'] ?? '',
                'price' => $card['offer_card_price'] ?? '',
                'linkText' => $card['offer_card_link_text'] ?? 'Sprawdź szczegóły',
                'linkUrl' => $card['offer_card_link_url'] ?? '',
            ];
        }

        return $cards;
    }
}
