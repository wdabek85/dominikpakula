<?php

/**
 * Strona ustawień "Sekcja: Poznaj mnie" — globalna treść modala otwieranego
 * przyciskiem w bloku "Opis Usługi / Video CTA" (service-video).
 * Ta sama treść na każdej stronie. Wzorowane na Booking/EmailTemplates.php.
 */

namespace App\AboutModal;

const OPTION = 'about_modal_settings';

function defaults(): array
{
    return [
        'heading' => 'Kilka słów o mnie',
        'body' => '<p>Nazywam się Dominik Pakuła. Pomagam mężczyznom wyglądać tak, jak chcieliby wyglądać — bez rewolucji, bez przebierania i bez gadania o trendach, które nikogo nie obchodzą.</p>',
        'link_label' => 'Poznaj całą moją historię',
        'link_url' => '/o-mnie/',
    ];
}

function settings(): array
{
    return \wp_parse_args(\get_option(OPTION, []), defaults());
}

add_action('admin_menu', function () {
    \add_options_page(
        'Sekcja: Poznaj mnie',
        'Sekcja: Poznaj mnie',
        'manage_options',
        'about-modal',
        __NAMESPACE__ . '\\render_page'
    );
});

function render_page(): void
{
    $defaults = defaults();
    $settings = settings();

    if (isset($_POST['_about_modal_nonce']) && \wp_verify_nonce($_POST['_about_modal_nonce'], 'about_modal_save')) {
        if (isset($_POST['reset_defaults'])) {
            $settings = $defaults;
        } else {
            $settings = [
                'heading' => \sanitize_text_field(\wp_unslash($_POST['heading'] ?? '')),
                'body' => \wp_kses_post(\wp_unslash($_POST['body'] ?? '')),
                'link_label' => \sanitize_text_field(\wp_unslash($_POST['link_label'] ?? '')),
                'link_url' => \esc_url_raw(\wp_unslash($_POST['link_url'] ?? '')),
            ];
        }
        \update_option(OPTION, $settings);
        echo '<div class="notice notice-success"><p>Zapisano!</p></div>';
    }

    ?>
    <div class="wrap">
        <h1>Sekcja: Poznaj mnie</h1>
        <p>Treść modala otwieranego przyciskiem w bloku „Opis Usługi / Video CTA”. Ta sama na każdej stronie, na której użyty jest blok.</p>

        <form method="post">
            <?php \wp_nonce_field('about_modal_save', '_about_modal_nonce'); ?>

            <table class="form-table">
                <tr><th scope="row">Nagłówek</th><td><input type="text" name="heading" class="large-text" value="<?php echo \esc_attr($settings['heading']); ?>"></td></tr>
                <tr><th scope="row">Treść</th><td><?php \wp_editor($settings['body'], 'body', ['textarea_rows' => 8]); ?></td></tr>
                <tr><th scope="row">Etykieta linku</th><td><input type="text" name="link_label" class="regular-text" value="<?php echo \esc_attr($settings['link_label']); ?>"></td></tr>
                <tr><th scope="row">URL linku</th><td><input type="text" name="link_url" class="regular-text" value="<?php echo \esc_attr($settings['link_url']); ?>"> <span class="description">np. /o-mnie/</span></td></tr>
            </table>

            <p class="submit">
                <?php \submit_button('Zapisz', 'primary', 'submit', false); ?>
                &nbsp;
                <button type="submit" name="reset_defaults" class="button">Przywróć domyślne</button>
            </p>
        </form>
    </div>
    <?php
}
