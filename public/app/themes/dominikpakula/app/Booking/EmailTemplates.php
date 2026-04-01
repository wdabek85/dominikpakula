<?php

/**
 * Booking Email Templates admin page.
 */

namespace App\Booking;

add_action('admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=booking',
        'Szablony e-mail',
        'Szablony e-mail',
        'manage_options',
        'booking-emails',
        __NAMESPACE__ . '\\render_email_page'
    );
});

function get_default_email_settings(): array
{
    return [
        'client_subject' => 'Potwierdzenie rezerwacji — {usluga}',
        'client_body' => '<p>Cześć {imie}!</p><p>Twoja rezerwacja na <strong>{usluga}</strong> w dniu <strong>{data}</strong> została potwierdzona.</p><p>Jeśli masz pytania — napisz do nas.</p><p>Do zobaczenia!<br>{nazwa_strony}</p>',
        'admin_subject' => 'Nowa rezerwacja — {imie} {nazwisko}',
        'admin_body' => '<p>Nowa rezerwacja:</p><ul><li><strong>Usługa:</strong> {usluga}</li><li><strong>Data:</strong> {data}</li><li><strong>Klient:</strong> {imie} {nazwisko}</li><li><strong>E-mail:</strong> {email}</li><li><strong>Telefon:</strong> {telefon}</li></ul>',
    ];
}

function render_email_page(): void
{
    $defaults = get_default_email_settings();
    $settings = get_option('booking_email_settings', $defaults);
    $settings = wp_parse_args($settings, $defaults);

    if (isset($_POST['_booking_email_nonce']) && wp_verify_nonce($_POST['_booking_email_nonce'], 'booking_email_save')) {
        if (isset($_POST['reset_defaults'])) {
            $settings = $defaults;
        } else {
            $settings = [
                'client_subject' => sanitize_text_field($_POST['client_subject'] ?? ''),
                'client_body' => wp_kses_post($_POST['client_body'] ?? ''),
                'admin_subject' => sanitize_text_field($_POST['admin_subject'] ?? ''),
                'admin_body' => wp_kses_post($_POST['admin_body'] ?? ''),
            ];
        }
        update_option('booking_email_settings', $settings);
        echo '<div class="notice notice-success"><p>Zapisano!</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Szablony e-mail</h1>
        <p>Placeholdery: <code>{imie}</code> <code>{nazwisko}</code> <code>{email}</code> <code>{telefon}</code> <code>{data}</code> <code>{usluga}</code> <code>{nazwa_strony}</code></p>

        <form method="post">
            <?php wp_nonce_field('booking_email_save', '_booking_email_nonce'); ?>

            <h2>Mail do klienta</h2>
            <table class="form-table">
                <tr><th>Temat</th><td><input type="text" name="client_subject" class="large-text" value="<?php echo esc_attr($settings['client_subject']); ?>"></td></tr>
                <tr><th>Treść</th><td><?php wp_editor($settings['client_body'], 'client_body', ['textarea_rows' => 10]); ?></td></tr>
            </table>

            <h2>Mail do admina</h2>
            <table class="form-table">
                <tr><th>Temat</th><td><input type="text" name="admin_subject" class="large-text" value="<?php echo esc_attr($settings['admin_subject']); ?>"></td></tr>
                <tr><th>Treść</th><td><?php wp_editor($settings['admin_body'], 'admin_body', ['textarea_rows' => 10]); ?></td></tr>
            </table>

            <p class="submit">
                <?php submit_button('Zapisz szablony', 'primary', 'submit', false); ?>
                &nbsp;
                <button type="submit" name="reset_defaults" class="button">Przywróć domyślne</button>
            </p>
        </form>
    </div>
    <?php
}
