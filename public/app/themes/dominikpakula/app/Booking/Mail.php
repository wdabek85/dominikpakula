<?php

/**
 * Booking mail functions (temporary — will be replaced by webhooks).
 */

namespace App\Booking;

function booking_replace_placeholders(string $text, int $bookingId): string
{
    $replacements = [
        '{imie}' => get_post_meta($bookingId, '_booking_first_name', true),
        '{nazwisko}' => get_post_meta($bookingId, '_booking_last_name', true),
        '{email}' => get_post_meta($bookingId, '_booking_email', true),
        '{telefon}' => get_post_meta($bookingId, '_booking_phone', true),
        '{data}' => date_i18n('j F Y', strtotime(get_post_meta($bookingId, '_booking_date', true))),
        '{usluga}' => get_post_meta($bookingId, '_booking_service', true),
        '{nazwa_strony}' => get_bloginfo('name'),
    ];

    return str_replace(array_keys($replacements), array_values($replacements), $text);
}

function booking_wrap_html(string $body): string
{
    return '<!DOCTYPE html><html><body style="font-family:Arial,sans-serif;max-width:560px;margin:0 auto;padding:20px;color:#333">' . $body . '</body></html>';
}

function send_booking_confirmation(int $bookingId): void
{
    $settings = get_option('booking_email_settings', []);
    $defaults = get_default_email_settings();
    $settings = wp_parse_args($settings, $defaults);

    $email = get_post_meta($bookingId, '_booking_email', true);
    if (! $email) {
        return;
    }

    $subject = booking_replace_placeholders($settings['client_subject'], $bookingId);
    $body = booking_replace_placeholders($settings['client_body'], $bookingId);

    wp_mail($email, $subject, booking_wrap_html($body), ['Content-Type: text/html; charset=UTF-8']);
}

function send_booking_admin_notification(int $bookingId): void
{
    $settings = get_option('booking_email_settings', []);
    $defaults = get_default_email_settings();
    $settings = wp_parse_args($settings, $defaults);

    $adminEmail = get_option('admin_email');
    if (! $adminEmail) {
        return;
    }

    $subject = booking_replace_placeholders($settings['admin_subject'], $bookingId);
    $body = booking_replace_placeholders($settings['admin_body'], $bookingId);

    $editUrl = admin_url('post.php?post=' . $bookingId . '&action=edit');
    $body .= '<p style="margin-top:20px"><a href="' . esc_url($editUrl) . '" style="background:#282435;color:#fff;padding:10px 20px;text-decoration:none;border-radius:4px">Zobacz w panelu</a></p>';

    wp_mail($adminEmail, $subject, booking_wrap_html($body), ['Content-Type: text/html; charset=UTF-8']);
}
