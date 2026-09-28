<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

/**
 * Dane kontaktowe i sociale z „Ustawienia strony” (acf-json/group_site_settings.json).
 *
 * Jedyne miejsce z wartościami domyślnymi — widoki dostają gotowe dane i nie trzymają
 * własnych fallbacków. Puste pole w panelu = wartość domyślna poniżej.
 */
class SiteSettings extends Composer
{
    protected const DEFAULTS = [
        'email' => 'kontakt@meskistylista.pl',
        'phone' => '+48 577 190 949',
        'phone_link' => '+48577190949',
        'address_line1' => 'Kraków',
        'instagram' => 'https://www.instagram.com/dpakula_stylist/',
        'instagram_handle' => 'dpakula_stylist',
    ];

    protected static $views = [
        '*',
    ];

    public function with(): array
    {
        return [
            'contact' => $this->contact(),
            'social' => $this->social(),
        ];
    }

    protected function contact(): array
    {
        $phone = $this->option('contact_phone') ?: self::DEFAULTS['phone'];
        $phoneLink = $this->option('contact_phone_link') ?: self::DEFAULTS['phone_link'];
        $sidebarPhone = $this->option('contact_sidebar_phone') ?: $phone;

        return [
            'email' => $this->option('contact_email') ?: self::DEFAULTS['email'],
            'phone' => $phone,
            'phone_link' => $phoneLink,
            'address_line1' => $this->option('contact_address_line1') ?: self::DEFAULTS['address_line1'],
            'address_line2' => $this->option('contact_address_line2'),
            'sidebar_phone' => $sidebarPhone,
            'sidebar_phone_link' => $this->option('contact_sidebar_phone_link')
                ?: ($this->option('contact_sidebar_phone') ? $sidebarPhone : $phoneLink),
        ];
    }

    protected function social(): array
    {
        $whatsapp = $this->option('social_whatsapp_url');

        if (! $whatsapp) {
            // Bez osobnego linku — wa.me z telefonu głównego
            $digits = preg_replace('/\D+/', '', $this->option('contact_phone_link') ?: self::DEFAULTS['phone_link']);
            $whatsapp = $digits ? 'https://wa.me/' . $digits : '';
        }

        return [
            'facebook' => $this->option('social_facebook_url'),
            'instagram' => $this->option('social_instagram_url') ?: self::DEFAULTS['instagram'],
            'instagram_handle' => ltrim($this->option('social_instagram_handle') ?: self::DEFAULTS['instagram_handle'], '@'),
            'tiktok' => $this->option('social_tiktok_url'),
            'twitter' => $this->option('social_twitter_url'),
            'whatsapp' => $whatsapp,
        ];
    }

    protected function option(string $name): string
    {
        return (string) (\get_field($name, 'option') ?: '');
    }
}
