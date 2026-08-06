<?php

/**
 * Przekierowania 301 ze starych adresów.
 *
 * WordPress zapisuje `_wp_old_slug` i przekierowuje sam TYLKO dla typów
 * niehierarchicznych. `service` jest hierarchiczny (usługi miejskie są dziećmi
 * usługi głównej), więc po zmianie sluga stary adres zwraca 404 — stąd ta mapa.
 *
 * Klucz i wartość to ścieżki względem katalogu głównego, ze slashami po obu stronach.
 */

namespace App;

/**
 * Mapa: stara ścieżka => nowa ścieżka.
 *
 * @return array<string, string>
 */
function redirect_map(): array
{
    return [
        // 2026-08-06: skrócony slug strony miejskiej (było `zakupy-ze-stylista-krakow-2`,
        // sufiks `-2` brał się z kolizji z załącznikiem o tym samym slugu).
        '/uslugi/zakupy-ze-stylista/zakupy-ze-stylista-krakow-2/' => '/uslugi/zakupy-ze-stylista/krakow/',
        // ten sam wpis na stagingu miał slug z literówką
        '/uslugi/zakupy-ze-stylista/zakupy-ze-stylista-karkow/' => '/uslugi/zakupy-ze-stylista/krakow/',
    ];
}

add_action('template_redirect', function () {
    if (! is_404()) {
        return;
    }

    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

    if (! is_string($path) || $path === '') {
        return;
    }

    $path = trailingslashit($path);
    $map = redirect_map();

    if (! isset($map[$path])) {
        return;
    }

    wp_safe_redirect(home_url($map[$path]), 301);
    exit;
}, 1);
