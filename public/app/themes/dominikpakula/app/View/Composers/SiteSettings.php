<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SiteSettings extends Composer
{
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
        return [
            'email' => \get_field('contact_email', 'option') ?: '',
            'phone' => \get_field('contact_phone', 'option') ?: '',
            'phone_link' => \get_field('contact_phone_link', 'option') ?: '',
            'address_line1' => \get_field('contact_address_line1', 'option') ?: '',
            'address_line2' => \get_field('contact_address_line2', 'option') ?: '',
            'sidebar_phone' => \get_field('contact_sidebar_phone', 'option') ?: '',
            'sidebar_phone_link' => \get_field('contact_sidebar_phone_link', 'option') ?: '',
        ];
    }

    protected function social(): array
    {
        return [
            'facebook' => \get_field('social_facebook_url', 'option') ?: '',
            'instagram' => \get_field('social_instagram_url', 'option') ?: '',
            'instagram_handle' => \get_field('social_instagram_handle', 'option') ?: '',
            'tiktok' => \get_field('social_tiktok_url', 'option') ?: '',
            'twitter' => \get_field('social_twitter_url', 'option') ?: '',
        ];
    }
}
