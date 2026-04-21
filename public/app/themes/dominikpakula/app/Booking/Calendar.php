<?php

/**
 * Booking Admin Calendar — blocked dates management.
 */

namespace App\Booking;

use Illuminate\Support\Facades\Vite;

// Add submenu page
add_action('admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=booking',
        'Zablokowane dni',
        'Zablokowane dni',
        'manage_options',
        'booking-calendar',
        __NAMESPACE__ . '\\render_calendar_page'
    );
});

// Enqueue calendar JS on its admin page
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'booking_page_booking-calendar') {
        return;
    }

    try {
        echo Vite::withEntryPoints(['resources/js/admin/booking-calendar.js'])->toHtml();
    } catch (\Throwable $e) {
        // Vite asset not built yet — silent fallback
    }
});

function render_calendar_page(): void
{
    $blocked = get_option('booking_blocked_dates', []);
    if (! is_array($blocked)) {
        $blocked = [];
    }

    // Get all active bookings
    $bookings = \get_posts([
        'post_type' => 'booking',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ]);

    $bookedDates = [];
    foreach ($bookings as $booking) {
        $status = get_post_meta($booking->ID, '_booking_status', true);
        if ($status === 'cancelled') {
            continue;
        }
        $date = get_post_meta($booking->ID, '_booking_date', true);
        $name = get_post_meta($booking->ID, '_booking_first_name', true) . ' ' . get_post_meta($booking->ID, '_booking_last_name', true);
        if ($date) {
            $bookedDates[date('Y-m-d', strtotime($date))] = trim($name);
        }
    }

    ?>
    <div class="wrap">
        <h1>Kalendarz — zablokowane dni</h1>
        <p>Kliknij na dzień aby go zablokować/odblokować. <span style="color:#d63638">■</span> Zablokowany <span style="color:#2271b1">■</span> Zarezerwowany <span style="color:#ccc">■</span> Przeszły</p>

        <div id="booking-admin-calendar" style="max-width:600px;margin-top:20px;"
             data-blocked='<?php echo esc_attr(wp_json_encode($blocked)); ?>'
             data-booked='<?php echo esc_attr(wp_json_encode($bookedDates)); ?>'
             data-nonce='<?php echo esc_attr(wp_create_nonce('booking_toggle_date')); ?>'
             data-ajaxurl='<?php echo esc_attr(admin_url('admin-ajax.php')); ?>'>
        </div>
    </div>
    <?php
}

// AJAX handler for toggling blocked dates
add_action('wp_ajax_toggle_blocked_date', function () {
    check_ajax_referer('booking_toggle_date');

    if (! current_user_can('manage_options')) {
        wp_send_json_error(['message' => 'Brak uprawnień'], 403);
    }

    $date = sanitize_text_field($_POST['date'] ?? '');
    if (! $date) {
        wp_send_json_error();
    }

    $dateFormatted = date('Y-m-d', strtotime($date));
    $blocked = get_option('booking_blocked_dates', []);
    if (! is_array($blocked)) {
        $blocked = [];
    }

    if (in_array($dateFormatted, $blocked, true)) {
        $blocked = array_values(array_diff($blocked, [$dateFormatted]));
    } else {
        $blocked[] = $dateFormatted;
    }

    update_option('booking_blocked_dates', $blocked);

    wp_send_json_success(['blocked' => $blocked]);
});
