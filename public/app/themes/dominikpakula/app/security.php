<?php

/**
 * Security hardening.
 *
 * Zbiera w jednym miejscu utwardzenie front-endu wynikające z audytu bezpieczeństwa:
 *  - M1: nagłówki bezpieczeństwa (HSTS, nosniff, X-Frame-Options, Referrer/Permissions-Policy)
 *  - M2: ukrycie wersji WordPressa (generator, ?ver=, RSD/WLW) i nagłówka X-Powered-By
 *  - H2: blokada enumeracji użytkowników (REST /users + ?author=N + archiwa autora)
 *  - M5: wyłączenie komentarzy w całym serwisie (nieużywane — powierzchnia spamu)
 *
 * Ustawienia w bazie (domyślny status komentarzy, „Hello world", domyślna kategoria)
 * robione są osobno przez WP-CLI — patrz PROJECT_STATUS / raport bezpieczeństwa.
 */

namespace App;

/*
|--------------------------------------------------------------------------
| M1 — Nagłówki bezpieczeństwa
|--------------------------------------------------------------------------
| Dokładane do istniejącego hooka send_headers (por. setup.php). HSTS tylko po HTTPS.
| Panel (is_admin) pomijamy — WordPress sam wysyła tam X-Frame-Options.
*/
add_action('send_headers', function () {
    if (is_admin()) {
        return;
    }

    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: geolocation=(), microphone=(), camera=(), interest-cohort=()');

    if (is_ssl()) {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
    }

    // M2 — usuń nagłówek zdradzający framework/wersję (Acorn/Laravel, PHP).
    header_remove('X-Powered-By');
}, 20);

/*
|--------------------------------------------------------------------------
| M2 — Ukrycie wersji WordPressa
|--------------------------------------------------------------------------
*/
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
add_filter('the_generator', '__return_empty_string');

add_filter('style_loader_src', __NAMESPACE__ . '\\strip_core_version', 15);
add_filter('script_loader_src', __NAMESPACE__ . '\\strip_core_version', 15);

/**
 * Usuwa ?ver=<wersja WP> z URL-i rdzenia. Cache-busting theme'a opiera się na hashach
 * Vite, więc nic nie tracimy, a przestajemy publikować wersję WordPressa.
 */
function strip_core_version(string $src): string
{
    global $wp_version;

    if ($src && $wp_version && strpos($src, 'ver=' . $wp_version) !== false) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}

/*
|--------------------------------------------------------------------------
| H2 — Blokada enumeracji użytkowników
|--------------------------------------------------------------------------
*/

/**
 * Wyłącz publiczny endpoint REST /wp/v2/users. Zalogowani (panel/Gutenberg) mają dostęp,
 * anonimowi dostają 404 zamiast listy loginów.
 */
add_filter('rest_endpoints', function (array $endpoints): array {
    if (is_user_logged_in()) {
        return $endpoints;
    }

    unset($endpoints['/wp/v2/users']);
    unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);

    return $endpoints;
});

/**
 * Zablokuj ?author=N oraz archiwa /author/… dla niezalogowanych. Serwis jest
 * jednoautorski — archiwa autora nie są używane, a ujawniają login przez slug.
 * Priorytet 1: uruchamiamy się przed redirect_canonical (który zamieniłby ?author=1
 * na /author/<login>/ i wysłał slug w nagłówku Location).
 */
add_action('template_redirect', function () {
    if (is_author() && ! is_user_logged_in()) {
        wp_safe_redirect(home_url('/'), 301);
        exit;
    }
}, 1);

/*
|--------------------------------------------------------------------------
| M5 — Wyłączenie komentarzy w całym serwisie
|--------------------------------------------------------------------------
*/
add_filter('comments_open', '__return_false', 20);
add_filter('pings_open', '__return_false', 20);
add_filter('comments_array', '__return_empty_array', 20);

/**
 * Zdejmij wsparcie komentarzy/trackbacków ze wszystkich typów treści.
 */
add_action('init', function () {
    foreach (get_post_types() as $type) {
        if (post_type_supports($type, 'comments')) {
            remove_post_type_support($type, 'comments');
            remove_post_type_support($type, 'trackbacks');
        }
    }
}, 20);

/**
 * Sprzątanie panelu: ukryj menu „Komentarze" i węzeł w pasku admina.
 */
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

add_action('wp_before_admin_bar_render', function () {
    if (isset($GLOBALS['wp_admin_bar'])) {
        $GLOBALS['wp_admin_bar']->remove_node('comments');
    }
});
