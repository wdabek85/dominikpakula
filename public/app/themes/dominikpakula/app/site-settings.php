<?php

/**
 * Site-wide settings (ACF Options Page „Ustawienia strony”).
 *
 * Pola: acf-json/group_site_settings.json (kontakt + social media).
 * Odczyt i wartości domyślne: App\View\Composers\SiteSettings → $contact, $social w każdym widoku.
 */

namespace App;

add_action('acf/init', function () {
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Ustawienia strony',
        'menu_title' => 'Ustawienia strony',
        'menu_slug' => 'site-settings',
        'capability' => 'manage_options',
        'icon_url' => 'dashicons-admin-generic',
        'position' => 80,
        'redirect' => false,
    ]);
});
