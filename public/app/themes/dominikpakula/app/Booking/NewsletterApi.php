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

    // Nonce — odrzuca żądania spoza strony (CSRF / boty bez świeżego nonce).
    if (! verify_booking_nonce($request)) {
        return new \WP_REST_Response(['error' => 'Sesja wygasła. Odśwież stronę i spróbuj ponownie.'], 403);
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
    $gdpr = ! empty($data['gdpr']);

    if (! $email || ! is_email($email) || mb_strlen($email) > 200) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail.'], 400);
    }

    // Zgoda marketingowa RODO — wymagana i logowana (jak w formularzu kontaktu/vouchera).
    if (! $gdpr) {
        return new \WP_REST_Response(['error' => 'Zaznacz zgodę, aby zapisać się do newslettera.'], 400);
    }

    $consentAt = current_time('mysql');
    $consentIp = get_client_ip();

    $adminEmail = get_option('admin_email');

    $body = '<h2>Nowy zapis do newslettera</h2>';
    $body .= '<p><strong>E-mail:</strong> ' . esc_html($email) . '</p>';
    $body .= '<hr style="border:none;border-top:1px solid #eee;margin-top:20px">';
    $body .= '<p style="color:#888;font-size:12px;">Zgoda marketingowa: TAK — ' . esc_html($consentAt) . ' (IP: ' . esc_html($consentIp) . ')</p>';

    $subject = 'Nowy zapis do newslettera — ' . $email;

    wp_mail($adminEmail, $subject, booking_wrap_html($body, $subject), booking_mail_headers());

    do_action('booking_newsletter_subscribed', $email, [
        'at' => $consentAt,
        'ip' => $consentIp,
    ]);

    return new \WP_REST_Response([
        'success' => true,
        'message' => 'Dzięki! Jesteś zapisany na newsletter.',
    ], 200);
}
