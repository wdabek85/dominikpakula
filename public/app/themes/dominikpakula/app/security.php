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

/*
|--------------------------------------------------------------------------
| Hardening po incydencie 2026-08-05 (obce konta administratora)
|--------------------------------------------------------------------------
| Kontekst: między 20.07 a 04.08 w bazach produkcji (20 kont) i stagingu (4 konta)
| pojawiły się obce konta administratora. Pliki, rdzeń WP i treści były nietknięte,
| a konta powstawały BEZ żadnego żądania HTTP w logach — czyli wpis szedł poza
| aplikacją (dostęp do bazy / konta hostingowego), nie przez formularz logowania.
|
| Stąd podział poniżej: blokady zamykają drogi wejścia przez aplikację, a audyt
| dobowy jest siatką bezpieczeństwa na wejście z pominięciem WordPressa —
| bo takiego wpisu ŻADEN hook PHP nie zobaczy w momencie jego powstania.
|
| Rotacja haseł (hosting, MySQL, salty) jest poza kodem — patrz PROJECT_STATUS.
*/

const LOGIN_MAX_ATTEMPTS = 5;
const LOGIN_LOCKOUT_WINDOW = 15 * MINUTE_IN_SECONDS;

/**
 * IP klienta. Deleguje do helpera bookingu (REMOTE_ADDR jako źródło prawdy,
 * nagłówki proxy tylko przy jawnym BOOKING_TRUST_PROXY), z lokalnym fallbackiem
 * na wypadek innej kolejności ładowania plików.
 */
function security_client_ip(): string
{
    if (function_exists('App\\Booking\\get_client_ip')) {
        return \App\Booking\get_client_ip();
    }

    $remote = $_SERVER['REMOTE_ADDR'] ?? '';

    return filter_var($remote, FILTER_VALIDATE_IP) ? $remote : '0.0.0.0';
}

function login_attempts_key(): string
{
    return 'dp_login_fail_' . md5(security_client_ip());
}

/*
| Limit prób logowania — brak takiej ochrony był otwartym punktem audytu z lipca.
| 5 nieudanych prób z jednego IP w 15 minut blokuje kolejne na czas okna.
*/
add_filter('authenticate', function ($user, $username) {
    if (empty($username)) {
        return $user;
    }

    if ((int) get_transient(login_attempts_key()) >= LOGIN_MAX_ATTEMPTS) {
        return new \WP_Error(
            'dp_too_many_attempts',
            __('Zbyt wiele nieudanych prób logowania. Spróbuj ponownie za kilkanaście minut.', 'sage')
        );
    }

    return $user;
}, 30, 2);

add_action('wp_login_failed', function () {
    $key = login_attempts_key();
    set_transient($key, (int) get_transient($key) + 1, LOGIN_LOCKOUT_WINDOW);
});

add_action('wp_login', function () {
    delete_transient(login_attempts_key());
});

/**
 * Jeden komunikat na wszystkie błędy logowania — bez rozróżniania „zły login"
 * od „złe hasło" (inaczej formularz potwierdza istnienie konta).
 */
add_filter('login_errors', function () {
    return __('Nieprawidłowe dane logowania.', 'sage');
});

/*
| XML-RPC — nieużywany (brak aplikacji mobilnej, brak pingbacków). Serwer zwraca
| na nim 403, ale zamykamy też po stronie aplikacji: to klasyczny kanał
| brute-force (system.multicall pozwala testować wiele haseł jednym żądaniem).
*/
add_filter('xmlrpc_enabled', '__return_false');
add_filter('xmlrpc_methods', '__return_empty_array');
add_filter('wp_headers', function (array $headers): array {
    unset($headers['X-Pingback']);

    return $headers;
});

/*
| Hasła aplikacji — nieużywane, a stanowią wygodną furtkę persystencji: raz
| utworzone działają nawet po zmianie hasła konta.
*/
add_filter('wp_is_application_passwords_available', '__return_false');

/**
 * Zakaz zakładania kont przez REST API. Panel (user-new.php) nie korzysta z REST,
 * więc normalna praca administratora nie jest ruszona. Blokujemy tylko tworzenie —
 * aktualizacje profilu przechodzą dalej.
 */
add_filter('rest_pre_insert_user', function ($prepared, $request) {
    if (empty($prepared->ID)) {
        return new \WP_Error(
            'dp_rest_user_create_disabled',
            __('Zakładanie kont przez REST API jest wyłączone.', 'sage'),
            ['status' => 403]
        );
    }

    return $prepared;
}, 10, 2);

/*
|--------------------------------------------------------------------------
| Wykrywanie: alarm o nowym administratorze
|--------------------------------------------------------------------------
*/

/**
 * Powiadomienie mailowe, gdy konto dostaje rolę administratora.
 * Łapie drogę „przez WordPressa" (panel, REST, kod wtyczki) — natychmiast.
 */
function notify_admin_role_granted(int $userId, string $context): void
{
    $user = get_userdata($userId);

    if (! $user) {
        return;
    }

    $actor = wp_get_current_user();

    wp_mail(
        get_option('admin_email'),
        sprintf('[%s] Nowy administrator: %s', wp_specialchars_decode(get_bloginfo('name')), $user->user_login),
        implode("\n", [
            'Konto otrzymało rolę administratora.',
            '',
            'Login:      ' . $user->user_login,
            'E-mail:     ' . $user->user_email,
            'Kontekst:   ' . $context,
            'Wykonał:    ' . ($actor->ID ? $actor->user_login . ' (ID ' . $actor->ID . ')' : 'brak zalogowanego użytkownika'),
            'IP:         ' . security_client_ip(),
            'Czas:       ' . current_time('mysql'),
            '',
            'Jeśli to nie Ty — natychmiast usuń konto i zmień hasła (hosting, baza, WordPress).',
        ])
    );
}

add_action('user_register', function ($userId) {
    $user = get_userdata($userId);

    if ($user && in_array('administrator', (array) $user->roles, true)) {
        notify_admin_role_granted((int) $userId, 'utworzenie konta');
    }
}, 10, 1);

add_action('set_user_role', function ($userId, $role, $oldRoles) {
    if ($role === 'administrator' && ! in_array('administrator', (array) $oldRoles, true)) {
        notify_admin_role_granted((int) $userId, 'zmiana roli na administratora');
    }
}, 10, 3);

add_action('add_user_role', function ($userId, $role) {
    if ($role === 'administrator') {
        notify_admin_role_granted((int) $userId, 'dodanie roli administratora');
    }
}, 10, 2);

/*
|--------------------------------------------------------------------------
| Wykrywanie: dobowy audyt listy administratorów
|--------------------------------------------------------------------------
| To jest kontrola, która złapałaby incydent z lipca. Konta wstawione prosto
| do bazy (z pominięciem WordPressa) nie odpalają żadnego hooka, więc jedyny
| sposób ich wykrycia to porównywanie stanu — raz na dobę.
|
| Pierwsze uruchomienie zapisuje obecny stan jako punkt odniesienia. Skasowanie
| opcji `dp_known_admins` resetuje bazę porównania.
*/
add_action('init', function () {
    if (! wp_next_scheduled('dp_admin_audit')) {
        wp_schedule_event(time() + HOUR_IN_SECONDS, 'daily', 'dp_admin_audit');
    }
}, 30);

add_action('dp_admin_audit', function () {
    $current = get_users([
        'role' => 'administrator',
        'fields' => ['ID', 'user_login'],
    ]);

    $currentIds = wp_list_pluck($current, 'ID');
    sort($currentIds);

    $known = get_option('dp_known_admins');

    if (! is_array($known)) {
        update_option('dp_known_admins', $currentIds, false);

        return;
    }

    $new = array_diff($currentIds, $known);

    if (! $new) {
        return;
    }

    $lines = [];

    foreach ($current as $user) {
        if (in_array($user->ID, $new, true)) {
            $lines[] = sprintf('  - %s (ID %d)', $user->user_login, $user->ID);
        }
    }

    wp_mail(
        get_option('admin_email'),
        sprintf('[%s] UWAGA: nowe konta administratora', wp_specialchars_decode(get_bloginfo('name'))),
        implode("\n", array_merge(
            ['Audyt dobowy wykrył konta administratora, których wcześniej nie było:', ''],
            $lines,
            [
                '',
                'Jeśli to nie Ty je zakładałeś — konta powstały z pominięciem WordPressa',
                '(dostęp do bazy lub konta hostingowego). Zmień hasła: hosting, MySQL,',
                'WordPress oraz salty w .env, i usuń obce konta.',
            ]
        ))
    );

    update_option('dp_known_admins', $currentIds, false);
});
