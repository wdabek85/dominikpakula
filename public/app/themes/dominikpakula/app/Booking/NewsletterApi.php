<?php

/**
 * Newsletter REST API — captures email subscriptions and notifies admin.
 * Later: wire to Mailchimp/ActiveCampaign via Make.com webhook.
 */

namespace App\Booking;

add_action('rest_api_init', function () {
    register_rest_route('booking/v1', '/newsletter', [
        'methods' => 'POST',
        'callback' => __NAMESPACE__ . '\\api_newsletter_subscribe',
        'permission_callback' => '__return_true',
    ]);
});

function api_newsletter_subscribe(\WP_REST_Request $request): \WP_REST_Response
{
    if ($limited = check_rate_limit('newsletter', 5, 10 * MINUTE_IN_SECONDS)) {
        return $limited;
    }

    $data = $request->get_json_params();

    // Honeypot — pretend success silently
    if (! empty($data['website'])) {
        return new \WP_REST_Response([
            'success' => true,
            'message' => 'Dzięki!',
        ], 200);
    }

    $email = sanitize_email($data['email'] ?? '');

    if (! $email || ! is_email($email)) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail.'], 400);
    }

    $adminEmail = get_option('admin_email');

    $body = '<h2>Nowy zapis do newslettera</h2>';
    $body .= '<p><strong>E-mail:</strong> ' . esc_html($email) . '</p>';
    $body .= '<hr style="border:none;border-top:1px solid #eee;margin-top:20px">';
    $body .= '<p style="color:#888;font-size:12px;">Zapis: ' . esc_html(current_time('mysql')) . ' (IP: ' . esc_html(get_client_ip()) . ')</p>';

    $subject = 'Nowy zapis do newslettera — ' . $email;

    wp_mail($adminEmail, $subject, booking_wrap_html($body, $subject), booking_mail_headers());

    do_action('booking_newsletter_subscribed', $email);

    return new \WP_REST_Response([
        'success' => true,
        'message' => 'Dzięki! Sprawdź skrzynkę i potwierdź zapis.',
    ], 200);
}
