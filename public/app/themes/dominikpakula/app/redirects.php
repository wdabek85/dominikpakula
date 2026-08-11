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

/**
 * Dopasowanie po slugu — ratuje adresy, które zmieniły ścieżkę, ale nie slug
 * (np. wpis przeniesiony między kategoriami albo usługa, która przestała być
 * dzieckiem innej usługi). Odpala się tylko gdy mapa wyżej nic nie znalazła.
 *
 * Świadomie NIE przekierowujemy 404 na stronę główną — to soft 404: Google
 * traci sygnał „tej strony nie ma", a user ląduje nie wiadomo gdzie. Kierujemy
 * tylko wtedy, gdy wiemy dokąd.
 */
add_action('template_redirect', function () {
    if (! is_404()) {
        return;
    }

    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);

    if (! is_string($path) || $path === '') {
        return;
    }

    $segments = array_values(array_filter(explode('/', $path), 'strlen'));
    $slug = end($segments);

    // Puste, stronicowanie, feed, plik z rozszerzeniem — nie ma czego szukać.
    if (! $slug || is_numeric($slug) || str_contains($slug, '.')) {
        return;
    }

    $matches = get_posts([
        'name' => sanitize_title($slug),
        'post_type' => ['post', 'page', 'service', 'guide', 'portfolio'],
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    ]);

    if (! $matches) {
        return;
    }

    $target = get_permalink($matches[0]->ID);

    if (! $target) {
        return;
    }

    // Zabezpieczenie przed pętlą: jeśli cel to ta sama ścieżka, odpuszczamy.
    $targetPath = parse_url($target, PHP_URL_PATH);

    if (! is_string($targetPath) || trailingslashit($targetPath) === trailingslashit($path)) {
        return;
    }

    wp_safe_redirect($target, 301);
    exit;
}, 2);
