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

    // Nonce — odrzuca żądania spoza strony (CSRF / boty bez świeżego nonce).
    if (! verify_booking_nonce($request)) {
        return new \WP_REST_Response(['error' => 'Sesja wygasła. Odśwież stronę i spróbuj ponownie.'], 403);
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
    $phone = trim(sanitize_text_field($data['phone'] ?? ''));
    $message = sanitize_textarea_field($data['message'] ?? '');
    $gdpr = ! empty($data['gdpr']);

    if (! $name || ! $email || ! $message) {
        return new \WP_REST_Response(['error' => 'Wypełnij wszystkie pola.'], 400);
    }

    if (! is_email($email)) {
        return new \WP_REST_Response(['error' => 'Nieprawidłowy adres e-mail.'], 400);
    }

    // Telefon jest opcjonalny — walidujemy tylko gdy użytkownik coś wpisał.
    if ($phone !== '') {
        if (mb_strlen($phone) > 30
            || ! preg_match('/^[0-9+\-\s()]+$/', $phone)
            || strlen(preg_replace('/\D/', '', $phone)) < 9
        ) {
            return new \WP_REST_Response(['error' => 'Nieprawidłowy numer telefonu.'], 400);
        }
    }

    if (! $gdpr) {
        return new \WP_REST_Response(['error' => 'Musisz zaakceptować politykę prywatności.'], 400);
    }

    if (mb_strlen($message) > 5000) {
        return new \WP_REST_Response(['error' => 'Wiadomość jest zbyt długa.'], 400);
    }

    $adminEmail = get_option('admin_email');
    $siteName = get_bloginfo('name');

    $consentStamp = current_time('d.m.Y H:i');

    // Referer pochodzi od przeglądarki, więc traktujemy go jako deklarację,
    // nie dowód — w mailu jest odpowiednio opisany.
    $sourceUrl = esc_url_raw((string) $request->get_header('referer'));

    $body = '<h2>Nowa wiadomość z formularza kontaktowego</h2>';
    $body .= '<ul>';
    $body .= '<li><strong>Imię:</strong> ' . esc_html($name) . '</li>';
    $body .= '<li><strong>E-mail:</strong> ' . esc_html($email) . '</li>';

    if ($phone !== '') {
        $phoneLink = preg_replace('/[^0-9+]/', '', $phone);
        $body .= '<li><strong>Telefon:</strong> <a href="tel:' . esc_attr($phoneLink) . '">' . esc_html($phone) . '</a></li>';
    }

    $body .= '<li><strong>Zgoda RODO:</strong> TAK — udzielona ' . esc_html($consentStamp) . ' (treść niżej)</li>';
    $body .= '</ul>';
    $body .= '<h3>Wiadomość</h3>';
    $body .= '<p style="white-space:pre-wrap">' . esc_html($message) . '</p>';

    // Dowód zgody — RODO art. 7 ust. 1 wymaga wykazania, NA CO użytkownik się zgodził,
    // więc archiwizujemy dokładną treść checkboxa, a nie samo „tak".
    $body .= '<h3>Zgoda na przetwarzanie danych</h3>';
    $body .= '<div style="border-left:3px solid #282435;background:#f7f7f9;padding:12px 16px;">';
    $body .= '<p style="margin:0 0 8px;">Nadawca zaznaczył obowiązkowy checkbox o treści:</p>';
    $body .= '<p style="margin:0 0 12px;font-style:italic;">„' . esc_html(contact_consent_plain()) . '"</p>';
    $body .= '<p style="margin:0;font-size:12px;color:#555;line-height:1.6;">';
    $body .= 'Data i godzina: <strong>' . esc_html($consentStamp) . '</strong><br>';
    $body .= 'Adres IP: <strong>' . esc_html(get_client_ip()) . '</strong><br>';
    $body .= 'Formularz: <strong>kontaktowy</strong>';

    if ($sourceUrl) {
        $body .= '<br>Strona (wg przeglądarki): <strong>' . esc_html($sourceUrl) . '</strong>';
    }

    $body .= '</p></div>';

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
