<?php

/**
 * Site-wide settings (ACF Options Page).
 *
 * Fields to create manually in WP admin (ACF field group bound to options page "site-settings"):
 *
 *   Contact:
 *     - contact_email           (Email)
 *     - contact_phone           (Text, display format, e.g. "+48 577 190 949")
 *     - contact_phone_link      (Text, tel: format, e.g. "+48577190949")
 *     - contact_address_line1   (Text)
 *     - contact_address_line2   (Text)
 *     - contact_sidebar_phone        (Text, display format)
 *     - contact_sidebar_phone_link   (Text, tel: format)
 *
 *   Social:
 *     - social_facebook_url     (URL)
 *     - social_instagram_url    (URL)
 *     - social_instagram_handle (Text, bez "@" — np. "dominikpakula")
 *     - social_tiktok_url       (URL)
 *     - social_twitter_url      (URL)
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
