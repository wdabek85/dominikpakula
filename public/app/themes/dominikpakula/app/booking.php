<?php

/**
 * Booking system bootstrap.
 */

namespace App\Booking;

// Load all booking modules
require_once __DIR__ . '/Booking/PostTypes.php';
require_once __DIR__ . '/Booking/Api.php';
require_once __DIR__ . '/Booking/Admin.php';
require_once __DIR__ . '/Booking/Calendar.php';
require_once __DIR__ . '/Booking/EmailTemplates.php';
require_once __DIR__ . '/Booking/Mail.php';
require_once __DIR__ . '/Booking/VoucherApi.php';
require_once __DIR__ . '/Booking/ContactApi.php';
require_once __DIR__ . '/Booking/NewsletterApi.php';

// Inject booking data into frontend
add_action('wp_head', function () {
    $services = get_booking_services();
    $data = [
        'restUrl' => esc_url_raw(rest_url('booking/v1/')),
        'nonce' => wp_create_nonce('wp_rest'),
        'services' => $services,
    ];
    echo '<script>window.bookingData = ' . wp_json_encode($data) . ';</script>' . "\n";
}, 5);
