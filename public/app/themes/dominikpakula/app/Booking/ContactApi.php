<?php

/**
 * Contact form REST API — sends messages to admin with rate limiting and honeypot.
 */

namespace App\Booking;

add_action('rest_api_init', function () {
    register_rest_route('booking/v1', '/contact', [
        'methods' => 'POST',
        'callback' => __NAMESPACE__ . '\\api_contact_submit',
        'permission_callback' => '__return_true',
    ]);
});

function api_contact_submit(\WP_REST_Request $request): \WP_REST_Response
{
    // Rate limit: max 3 submissions per 10 min per IP
    if ($limited = check_rate_limit('contact', 3, 10 * MINUTE_IN_SECONDS)) {
        return $limited;
    }

    $data = $request->get_json_params();

    // Honeypot — if filled, pretend success silently
    if (! empty($data['website'])) {
        return new \WP_REST_Response([
            'success' => true,
            'message' => 'Dziękujemy za wiadomość.',
        ], 200);
    }

    $name = sanitize_text_field($data['name'] ?? '');
    $email = sanitize_email($data['email'] ?? '');
    $message = sanitize_textarea_field($data['message'] ?? '');
    $gdpr = ! empty($data['gdpr']);

    if (! $name || ! $email || ! $message) {
        return new \WP_REST_Response(['error' => 'Wypełnij wszystkie pola.'], 400);
    }

    if (! is_email($email)) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail.'], 400);
    }

    if (! $gdpr) {
        return new \WP_REST_Response(['error' => 'Musisz zaakceptować politykę prywatności.'], 400);
    }

    if (mb_strlen($message) > 5000) {
        return new \WP_REST_Response(['error' => 'Wiadomość jest zbyt długa.'], 400);
    }

    $adminEmail = get_option('admin_email');
    $siteName = get_bloginfo('name');

    $body = '<h2>Nowa wiadomość z formularza kontaktowego</h2>';
    $body .= '<ul>';
    $body .= '<li><strong>Imię:</strong> ' . esc_html($name) . '</li>';
    $body .= '<li><strong>E-mail:</strong> ' . esc_html($email) . '</li>';
    $body .= '</ul>';
    $body .= '<h3>Wiadomość</h3>';
    $body .= '<p style="white-space:pre-wrap">' . esc_html($message) . '</p>';
    $body .= '<hr style="border:none;border-top:1px solid #eee;margin-top:20px">';
    $body .= '<p style="color:#888;font-size:12px;">GDPR zaakceptowane: ' . esc_html(current_time('mysql')) . ' (IP: ' . esc_html(get_client_ip()) . ')</p>';

    $subject = 'Wiadomość z formularza — ' . $name;

    // Set Reply-To so admin can reply directly to the sender
    $headers = booking_mail_headers();
    $headers[] = 'Reply-To: ' . $name . ' <' . $email . '>';

    $sent = wp_mail($adminEmail, $subject, booking_wrap_html($body, $subject), $headers);

    if (! $sent) {
        return new \WP_REST_Response(['error' => 'Nie udało się wysłać wiadomości. Spróbuj ponownie.'], 500);
    }

    return new \WP_REST_Response([
        'success' => true,
        'message' => 'Dziękujemy! Wiadomość została wysłana — odpowiem w ciągu 24 godzin.',
    ], 200);
}
