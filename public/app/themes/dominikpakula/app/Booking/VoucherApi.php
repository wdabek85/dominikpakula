<?php

/**
 * Voucher REST API — sends notification email to admin.
 */

namespace App\Booking;

add_action('rest_api_init', function () {
    register_rest_route('booking/v1', '/voucher', [
        'methods' => 'POST',
        'callback' => __NAMESPACE__ . '\\api_voucher_order',
        'permission_callback' => '__return_true',
    ]);
});

function api_voucher_order(\WP_REST_Request $request): \WP_REST_Response
{
    // Rate limit: max 5 attempts per 10 min per IP
    if ($limited = check_rate_limit('voucher', 5, 10 * MINUTE_IN_SECONDS)) {
        return $limited;
    }

    $data = $request->get_json_params();

    // Honeypot — jeśli wypełnione, udawaj sukces (bot), nie wysyłaj maili
    if (! empty($data['website'])) {
        return new \WP_REST_Response([
            'success' => true,
            'message' => 'Zamówienie przyjęte! Sprawdź swoją skrzynkę e-mail — wyślemy instrukcję zakupu.',
        ], 200);
    }

    $service = sanitize_text_field($data['service'] ?? '');
    $recipientFirst = sanitize_text_field($data['recipient_first_name'] ?? '');
    $recipientLast = sanitize_text_field($data['recipient_last_name'] ?? '');
    $recipientEmailRaw = trim((string) ($data['recipient_email'] ?? ''));
    $recipientEmail = $recipientEmailRaw !== '' ? sanitize_email($recipientEmailRaw) : '';
    $buyerFirst = sanitize_text_field($data['buyer_first_name'] ?? '');
    $buyerLast = sanitize_text_field($data['buyer_last_name'] ?? '');
    $buyerEmail = sanitize_email($data['buyer_email'] ?? '');
    $buyerPhone = sanitize_text_field($data['buyer_phone'] ?? '');
    $gdpr = ! empty($data['gdpr']);

    // Validation
    if (! $service || ! $recipientFirst || ! $buyerFirst || ! $buyerLast || ! $buyerEmail || ! $buyerPhone) {
        return new \WP_REST_Response(['error' => 'Wypełnij wszystkie wymagane pola.'], 400);
    }

    if (! $gdpr) {
        return new \WP_REST_Response(['error' => 'Musisz zaakceptować politykę prywatności.'], 400);
    }

    if (! is_email($buyerEmail)) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail zamawiającego.'], 400);
    }

    if ($recipientEmailRaw !== '' && ! is_email($recipientEmail)) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail obdarowanego.'], 400);
    }

    // Send admin notification
    $adminEmail = get_option('admin_email');

    $body = '<h2>Nowe zamówienie vouchera</h2>';
    $body .= '<h3>Usługa</h3><p>' . esc_html($service) . '</p>';
    $body .= '<h3>Obdarowany</h3><ul>';
    $body .= '<li><strong>Imię:</strong> ' . esc_html($recipientFirst) . '</li>';
    $body .= '<li><strong>Nazwisko:</strong> ' . esc_html($recipientLast) . '</li>';
    if ($recipientEmail) {
        $body .= '<li><strong>E-mail:</strong> ' . esc_html($recipientEmail) . '</li>';
    }
    $body .= '</ul>';
    $body .= '<h3>Zamawiający</h3><ul>';
    $body .= '<li><strong>Imię:</strong> ' . esc_html($buyerFirst) . '</li>';
    $body .= '<li><strong>Nazwisko:</strong> ' . esc_html($buyerLast) . '</li>';
    $body .= '<li><strong>E-mail:</strong> ' . esc_html($buyerEmail) . '</li>';
    $body .= '<li><strong>Telefon:</strong> ' . esc_html($buyerPhone) . '</li>';
    $body .= '</ul>';
    $body .= '<p style="color:#888;font-size:12px;">GDPR zaakceptowane: ' . esc_html(current_time('mysql')) . ' (IP: ' . esc_html(get_client_ip()) . ')</p>';

    $adminSubject = 'Nowe zamówienie vouchera — ' . $service;

    wp_mail(
        $adminEmail,
        $adminSubject,
        booking_wrap_html($body, $adminSubject),
        booking_mail_headers()
    );

    // Send buyer confirmation
    $buyerBody = '<p>Cześć ' . esc_html($buyerFirst) . '!</p>';
    $buyerBody .= '<p>Dziękujemy za zamówienie vouchera na usługę <strong>' . esc_html($service) . '</strong>.</p>';
    $buyerBody .= '<p>Skontaktujemy się z Tobą w ciągu 24h z instrukcją płatności i szczegółami vouchera.</p>';
    $buyerBody .= '<p>Pozdrawiamy,<br>' . esc_html(get_bloginfo('name')) . '</p>';

    $buyerSubject = 'Zamówienie vouchera — ' . get_bloginfo('name');

    wp_mail(
        $buyerEmail,
        $buyerSubject,
        booking_wrap_html($buyerBody, $buyerSubject),
        booking_mail_headers()
    );

    return new \WP_REST_Response([
        'success' => true,
        'message' => 'Zamówienie przyjęte! Sprawdź swoją skrzynkę e-mail — wyślemy instrukcję zakupu.',
    ], 200);
}
