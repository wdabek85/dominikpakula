<?php

/**
 * Newsletter → Brevo integration.
 *
 * Hooks into the `booking_newsletter_subscribed` action fired by NewsletterApi
 * and pushes the subscriber to a Brevo contact list. When a double opt-in
 * template is configured, Brevo sends its own confirmation email (double
 * opt-in); otherwise the contact is added straight to the list (single opt-in)
 * and you can trigger a welcome automation from the Brevo panel.
 *
 * Config — constants defined in config/application.php from .env:
 *   BREVO_API_KEY           — REST API v3 key                      (required)
 *   BREVO_LIST_ID           — target contact list ID               (required)
 *   BREVO_DOI_TEMPLATE_ID   — double opt-in email template ID      (optional)
 *   BREVO_DOI_REDIRECT_URL  — URL after confirmation click         (optional)
 *
 * Dormant until BREVO_API_KEY and BREVO_LIST_ID are set — safe to deploy early.
 */

namespace App\Booking;

add_action('booking_newsletter_subscribed', __NAMESPACE__ . '\\brevo_add_subscriber', 10, 2);

/**
 * Read a Brevo config constant, treating empty string as "not set".
 */
function brevo_config(string $key, $default = null)
{
    return (defined($key) && constant($key) !== '') ? constant($key) : $default;
}

/**
 * Push a newly-subscribed e-mail to Brevo.
 *
 * @param string               $email   Adres subskrybenta.
 * @param array<string,string> $consent Kontekst zgody RODO: ['at' => timestamp, 'ip' => ip].
 *                                       Trwały rejestr zgody prowadzi też mail do admina
 *                                       (NewsletterApi). Aby zapisać zgodę jako atrybuty
 *                                       kontaktu w Brevo (np. OPTIN_DATE/OPTIN_IP), najpierw
 *                                       utwórz te atrybuty w panelu Brevo, a potem dodaj je
 *                                       do $payload['attributes'] — inaczej API zwróci 400.
 */
function brevo_add_subscriber(string $email, array $consent = []): void
{
    $apiKey = brevo_config('BREVO_API_KEY');
    $listId = brevo_config('BREVO_LIST_ID');

    // Integration not configured yet — skip silently.
    if (! $apiKey || ! $listId) {
        return;
    }

    $email = sanitize_email($email);
    if (! $email || ! is_email($email)) {
        return;
    }

    $doiTemplateId = brevo_config('BREVO_DOI_TEMPLATE_ID');

    if ($doiTemplateId) {
        // Double opt-in — Brevo sends the confirmation e-mail itself.
        $endpoint = 'https://api.brevo.com/v3/contacts/doubleOptinConfirmation';
        $payload = [
            'email' => $email,
            'includeListIds' => [(int) $listId],
            'templateId' => (int) $doiTemplateId,
            'redirectionUrl' => brevo_config('BREVO_DOI_REDIRECT_URL', \home_url('/')),
        ];
    } else {
        // Single opt-in — add straight to the list.
        $endpoint = 'https://api.brevo.com/v3/contacts';
        $payload = [
            'email' => $email,
            'listIds' => [(int) $listId],
            'updateEnabled' => true,
        ];
    }

    $response = \wp_remote_post($endpoint, [
        'timeout' => 10,
        'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'api-key' => $apiKey,
        ],
        'body' => \wp_json_encode($payload),
    ]);

    if (\is_wp_error($response)) {
        \error_log('[Brevo newsletter] HTTP error: ' . $response->get_error_message());

        return;
    }

    $code = \wp_remote_retrieve_response_code($response);

    // 2xx = OK. Brevo answers 400 "duplicate_parameter" when the contact is
    // already on the list — not worth logging as an error.
    if ($code >= 300) {
        $body = \wp_remote_retrieve_body($response);

        if (strpos($body, 'duplicate_parameter') === false
            && stripos($body, 'already exist') === false) {
            \error_log('[Brevo newsletter] API ' . $code . ': ' . $body);
        }
    }
}
