<?php

/**
 * Sekretny adres logowania.
 *
 * Ukrywa `wp-login.php` pod adresem ustawionym w `.env` (WP_LOGIN_SLUG), np.
 * https://meskistylista.pl/moje-wejscie. Wejście na prawdziwy `wp-login.php`
 * albo na `wp-admin` bez sesji odsyła na stronę główną — bot skanujący
 * standardowe ścieżki nie dostaje formularza logowania.
 *
 * WYŁĄCZNIK BEZPIECZEŃSTWA: gdy `WP_LOGIN_SLUG` jest puste lub niezdefiniowane,
 * cały mechanizm śpi i logowanie działa standardowo. Usunięcie zmiennej z `.env`
 * to awaryjne wyjście, gdyby coś poszło nie tak.
 *
 * To warstwa maskująca, nie zabezpieczenie samo w sobie — realną ochronę daje
 * limit prób logowania i mocne hasła (patrz security.php).
 */

namespace App;

/**
 * Slug z konfiguracji Bedrocka. Pusty = mechanizm wyłączony.
 */
function login_slug(): string
{
    if (! defined('WP_LOGIN_SLUG')) {
        return '';
    }

    return trim((string) WP_LOGIN_SLUG, '/');
}

/**
 * Ścieżka bieżącego żądania, bez wiodących/końcowych ukośników i bez query stringa.
 */
function login_request_path(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

    return trim((string) $path, '/');
}

/**
 * Czy żądanie trafiło bezpośrednio w plik wp-login.php.
 */
function is_login_file_request(): bool
{
    return str_contains($_SERVER['SCRIPT_NAME'] ?? '', 'wp-login.php');
}

/**
 * Podmienia adres logowania na sekretny. Zachowuje query string
 * (redirect_to, action=logout, klucz resetu hasła itd.).
 */
function swap_login_url(string $url): string
{
    $slug = login_slug();

    if (! $slug || ! str_contains($url, 'wp-login.php')) {
        return $url;
    }

    $query = parse_url($url, PHP_URL_QUERY);

    return home_url('/' . $slug . '/' . ($query ? '?' . $query : ''));
}

if (login_slug()) {
    /*
    | Wszystkie adresy, które WordPress generuje na bazie wp-login.php: formularz
    | logowania, wylogowanie, reset hasła, przekierowania po zalogowaniu, linki w mailach.
    */
    add_filter('site_url', function ($url, $path) {
        return str_contains((string) $path, 'wp-login.php') ? swap_login_url($url) : $url;
    }, 10, 2);

    add_filter('network_site_url', function ($url, $path) {
        return str_contains((string) $path, 'wp-login.php') ? swap_login_url($url) : $url;
    }, 10, 2);

    add_filter('wp_redirect', function ($location) {
        return swap_login_url((string) $location);
    }, 10, 1);

    add_filter('login_url', __NAMESPACE__ . '\\swap_login_url', 10, 1);
    add_filter('logout_url', __NAMESPACE__ . '\\swap_login_url', 10, 1);
    add_filter('lostpassword_url', __NAMESPACE__ . '\\swap_login_url', 10, 1);
    add_filter('register_url', __NAMESPACE__ . '\\swap_login_url', 10, 1);

    /*
    | Routing: sekretny adres serwuje wp-login.php, prawdziwy wp-login.php znika.
    | Priorytet 1 — zanim cokolwiek zdąży wypchnąć output.
    */
    add_action('init', function () {
        $slug = login_slug();

        // Wejście na sekretny adres → obsłuż logowanie.
        if (login_request_path() === $slug) {
            // wp-login.php operuje na zmiennych w zasięgu globalnym — mapujemy je,
            // zanim plik zostanie wciągnięty w zasięgu tej funkcji.
            global $error, $errors, $action, $user_login, $user_email,
                   $redirect_to, $interim_login, $rp_key, $rp_login, $wp_version;

            require_once ABSPATH . 'wp-login.php';
            exit;
        }

        // Bezpośrednie wejście na wp-login.php → strona główna.
        // Wyjątek: `action=postpass` (formularz wpisów chronionych hasłem) —
        // to nie jest logowanie do panelu i musi działać.
        if (is_login_file_request() && ($_REQUEST['action'] ?? '') !== 'postpass') {
            wp_safe_redirect(home_url('/'), 302);
            exit;
        }

        /*
        | wp-admin bez sesji odsyłałby na formularz logowania — a że ten jest już
        | przepisany na sekretny adres, samo wejście na /wp/wp-admin/ zdradzałoby
        | slug w nagłówku Location. Dlatego też odsyłamy na stronę główną.
        | admin-ajax.php i admin-post.php zostają dostępne (używa ich front-end).
        */
        if (is_admin() && ! is_user_logged_in() && ! wp_doing_ajax()
            && ! str_contains($_SERVER['SCRIPT_NAME'] ?? '', 'admin-post.php')) {
            wp_safe_redirect(home_url('/'), 302);
            exit;
        }
    }, 1);
}
