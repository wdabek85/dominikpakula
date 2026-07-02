<?php

/**
 * Booking REST API endpoints.
 */

namespace App\Booking;

add_action('rest_api_init', function () {
    register_rest_route('booking/v1', '/services', [
        'methods' => 'GET',
        'callback' => __NAMESPACE__ . '\\api_get_services',
        'permission_callback' => '__return_true',
    ]);

    register_rest_route('booking/v1', '/available', [
        'methods' => 'GET',
        'callback' => __NAMESPACE__ . '\\api_get_available',
        'permission_callback' => '__return_true',
        'args' => [
            'month' => ['required' => true, 'type' => 'integer'],
            'year' => ['required' => true, 'type' => 'integer'],
        ],
    ]);

    register_rest_route('booking/v1', '/reserve', [
        'methods' => 'POST',
        'callback' => __NAMESPACE__ . '\\api_reserve',
        'permission_callback' => '__return_true',
    ]);
});

function api_get_services(): \WP_REST_Response
{
    return new \WP_REST_Response(get_booking_services(), 200);
}

function api_get_available(\WP_REST_Request $request): \WP_REST_Response
{
    $month = (int) $request->get_param('month');
    $year = (int) $request->get_param('year');

    // Blocked dates from options
    $blockedRaw = get_option('booking_blocked_dates', []);
    $blocked = array_map(function ($d) {
        return date('Y-m-d', strtotime(str_replace(['/', '.'], '-', $d)));
    }, is_array($blockedRaw) ? $blockedRaw : []);

    // Booked dates from CPT
    $bookings = \get_posts([
        'post_type' => 'booking',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ]);

    $booked = [];
    foreach ($bookings as $booking) {
        $status = get_post_meta($booking->ID, '_booking_status', true);
        if ($status === 'cancelled') {
            continue;
        }

        $date = get_post_meta($booking->ID, '_booking_date', true);
        if (! $date) {
            continue;
        }

        $d = date('Y-m-d', strtotime($date));
        if ((int) date('n', strtotime($d)) === $month && (int) date('Y', strtotime($d)) === $year) {
            $booked[] = $d;
        }
    }

    return new \WP_REST_Response([
        'blocked' => array_values(array_filter($blocked, function ($d) use ($month, $year) {
            return (int) date('n', strtotime($d)) === $month && (int) date('Y', strtotime($d)) === $year;
        })),
        'booked' => $booked,
        'month' => $month,
        'year' => $year,
    ], 200);
}

function get_client_ip(): string
{
    foreach (['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'] as $key) {
        if (! empty($_SERVER[$key])) {
            $ip = explode(',', $_SERVER[$key])[0];
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

function check_rate_limit(string $action, int $max, int $window): ?\WP_REST_Response
{
    $ip = get_client_ip();
    $key = 'booking_rl_' . $action . '_' . md5($ip);
    $count = (int) get_transient($key);

    if ($count >= $max) {
        return new \WP_REST_Response([
            'error' => 'Zbyt wiele prób. Spróbuj ponownie za kilka minut.',
        ], 429);
    }

    set_transient($key, $count + 1, $window);
    return null;
}

function api_reserve(\WP_REST_Request $request): \WP_REST_Response
{
    // Rate limit: max 5 attempts per 10 min per IP
    if ($limited = check_rate_limit('reserve', 5, 10 * MINUTE_IN_SECONDS)) {
        return $limited;
    }

    $data = $request->get_json_params();

    $date = sanitize_text_field($data['date'] ?? '');
    $service = sanitize_text_field($data['service'] ?? '');
    $firstName = sanitize_text_field($data['first_name'] ?? '');
    $lastName = sanitize_text_field($data['last_name'] ?? '');
    $email = sanitize_email($data['email'] ?? '');
    $phone = sanitize_text_field($data['phone'] ?? '');
    $gdpr = ! empty($data['gdpr']);

    // Validation
    if (! $date || ! $service || ! $firstName || ! $lastName || ! $email || ! $phone) {
        return new \WP_REST_Response(['error' => 'Wszystkie pola są wymagane.'], 400);
    }

    if (! $gdpr) {
        return new \WP_REST_Response(['error' => 'Musisz zaakceptować politykę prywatności.'], 400);
    }

    if (! is_email($email)) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail.'], 400);
    }

    $dateFormatted = date('Y-m-d', strtotime($date));
    if (! $dateFormatted || $dateFormatted === '1970-01-01') {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy format daty.'], 400);
    }

    if (strtotime($dateFormatted) < strtotime('today')) {
        return new \WP_REST_Response(['error' => 'Nie można rezerwować dat w przeszłości.'], 400);
    }

    // Check blocked
    $blocked = get_option('booking_blocked_dates', []);
    $blocked = array_map(function ($d) {
        return date('Y-m-d', strtotime(str_replace(['/', '.'], '-', $d)));
    }, is_array($blocked) ? $blocked : []);

    if (in_array($dateFormatted, $blocked, true)) {
        return new \WP_REST_Response(['error' => 'Ten dzień jest niedostępny.'], 400);
    }

    // Check already booked
    $existing = \get_posts([
        'post_type' => 'booking',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => '_booking_date',
                'value' => $dateFormatted,
                'compare' => '=',
            ],
            [
                'key' => '_booking_status',
                'value' => 'cancelled',
                'compare' => '!=',
            ],
        ],
    ]);

    if (! empty($existing)) {
        return new \WP_REST_Response(['error' => 'Ten dzień jest już zarezerwowany.'], 400);
    }

    // Create booking
    $bookingId = wp_insert_post([
        'post_type' => 'booking',
        'post_title' => $firstName . ' ' . $lastName . ' — ' . $dateFormatted,
        'post_status' => 'publish',
    ]);

    if (is_wp_error($bookingId)) {
        return new \WP_REST_Response(['error' => 'Nie udało się utworzyć rezerwacji.'], 500);
    }

    update_post_meta($bookingId, '_booking_date', $dateFormatted);
    update_post_meta($bookingId, '_booking_service', $service);
    update_post_meta($bookingId, '_booking_first_name', $firstName);
    update_post_meta($bookingId, '_booking_last_name', $lastName);
    update_post_meta($bookingId, '_booking_email', $email);
    update_post_meta($bookingId, '_booking_phone', $phone);
    update_post_meta($bookingId, '_booking_status', 'pending');
    update_post_meta($bookingId, '_booking_gdpr_accepted_at', current_time('mysql'));
    update_post_meta($bookingId, '_booking_gdpr_ip', get_client_ip());

    // Send emails
    send_booking_confirmation($bookingId);
    send_booking_admin_notification($bookingId);

    return new \WP_REST_Response([
        'success' => true,
        'message' => 'Rezerwacja została przyjęta! Sprawdź swoją skrzynkę e-mail — potwierdzimy ją wkrótce.',
    ], 200);
}
