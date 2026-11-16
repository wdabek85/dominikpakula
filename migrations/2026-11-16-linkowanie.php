<?php
/**
 * Linkowanie wewnętrzne (16.11.2026):
 *  1. pole „Miasto” (service_city) w podstronach miast — mianownik do stopki / „Zobacz też” / schema,
 *  2. strona główna: blok „Gdzie działam” (acf/service-areas) zaraz pod blokiem usług,
 *  3. /o-mnie/: przyciski „Zobacz realizacje” + „Sprawdź usługi” w bloku logotypów marek,
 *  4. menu „Stopka – Informacje” (O mnie, Konsultacje, Kontakt, Poradniki, Blog) w lokalizacji footer_info_navigation.
 * Idempotentny — elementy, które już są, pomija.
 *
 * Uruchom: wp eval-file migrations/2026-11-16-linkowanie.php [dry]
 */

use App\Services\ServiceCatalog;

require_once __DIR__ . '/lib/blocks.php';

$dry = ($args[0] ?? '') === 'dry';
$say = fn (string $msg) => WP_CLI::log(($dry ? '[dry] ' : '') . $msg);

$serviceId = function (string $path): int {
    $id = ServiceCatalog::idByPath($path);
    if (! $id) {
        WP_CLI::error("Brak opublikowanej usługi: {$path}");
    }
    return $id;
};

$pageId = function (string $path): int {
    $page = get_page_by_path($path);
    if (! $page || $page->post_status !== 'publish') {
        WP_CLI::error("Brak opublikowanej strony: /{$path}/");
    }
    return (int) $page->ID;
};

$savePost = function (int $id, string $content) use ($dry) {
    if ($dry) {
        return;
    }
    $result = wp_update_post(['ID' => $id, 'post_content' => wp_slash($content)], true);
    if (is_wp_error($result)) {
        WP_CLI::error($result->get_error_message());
    }
};

// 1. Miasta: service_city ---------------------------------------------------------------
foreach (ServiceCatalog::cityIds() as $cityId) {
    if (trim((string) get_field('service_city', $cityId)) !== '') {
        $say("Miasto {$cityId}: service_city już ustawione — pomijam");
        continue;
    }
    $city = ServiceCatalog::cityName($cityId);
    $say("Miasto {$cityId}: service_city = {$city}");
    if (! $dry) {
        update_field('service_city', $city, $cityId);
    }
}

// 2. Strona główna: „Gdzie działam” pod acf/services -------------------------------------
$frontId = (int) get_option('page_on_front');
$front = $frontId ? get_post($frontId) : null;

if (! $front) {
    WP_CLI::warning('Brak statycznej strony głównej — pomijam „Gdzie działam”');
} elseif (has_block('acf/service-areas', $front)) {
    $say('Strona główna: blok „Gdzie działam” już jest — pomijam');
} elseif (! preg_match('/<!-- wp:acf\/services \{.*?\} \/-->/s', $front->post_content, $m)) {
    WP_CLI::error('Strona główna: nie znalazłem bloku acf/services, nie wiem gdzie wstawić sekcję');
} else {
    $links = [];
    foreach (['zakupy-ze-stylista/krakow', 'zakupy-ze-stylista/warszawa', 'zakupy-ze-stylista/wroclaw', 'zakupy-ze-stylista/kielce', 'zakupy-online'] as $path) {
        $links[] = (string) $serviceId($path);
    }
    $block = mig_block('service-areas', [
        'areas_eyebrow' => '',
        'areas_heading' => 'Gdzie działam',
        'areas_text' => 'Zakupy ze stylistą robię w Krakowie, Warszawie, Wrocławiu i Kielcach, a zakupy online z całej Polski.',
        'areas_links' => $links,
    ]);
    $content = str_replace($m[0], $m[0] . "\n\n" . $block, $front->post_content);
    $savePost($frontId, $content);
    $say("Strona główna ({$frontId}): wstawiony blok „Gdzie działam” pod usługami (linki: " . implode(', ', $links) . ')');
}

// 3. /o-mnie/: przyciski pod logotypami marek --------------------------------------------
$aboutId = $pageId('o-mnie');
$about = get_post($aboutId);

if (! preg_match('/<!-- wp:acf\/brand-logos (\{.*?\}) \/-->/s', $about->post_content, $m)) {
    WP_CLI::warning('/o-mnie/: brak bloku logotypów — pomijam przyciski');
} else {
    $attrs = json_decode($m[1], true);
    if (! is_array($attrs) || ! isset($attrs['data'])) {
        WP_CLI::error('/o-mnie/: nie umiem odczytać danych bloku logotypów');
    }
    if (! empty($attrs['data']['logos_links'])) {
        $say('/o-mnie/: przyciski pod logotypami już są — pomijam');
    } else {
        $rows = [
            ['label' => 'Zobacz realizacje', 'url' => get_post_type_archive_link('portfolio')],
            ['label' => 'Sprawdź usługi', 'url' => get_permalink($pageId('uslugi'))],
        ];
        $field = mig_block_fields('acf/brand-logos')['logos_links'];
        $subs = array_column($field['sub_fields'], 'key', 'name');
        foreach ($rows as $i => $row) {
            foreach ($row as $sub => $value) {
                $attrs['data']["logos_links_{$i}_{$sub}"] = $value;
                $attrs['data']["_logos_links_{$i}_{$sub}"] = $subs[$sub];
            }
        }
        $attrs['data']['logos_links'] = count($rows);
        $attrs['data']['_logos_links'] = $field['key'];

        $content = str_replace($m[0], '<!-- wp:acf/brand-logos ' . serialize_block_attributes($attrs) . ' /-->', $about->post_content);
        $savePost($aboutId, $content);
        $say("/o-mnie/ ({$aboutId}): przyciski „Zobacz realizacje” → {$rows[0]['url']}, „Sprawdź usługi” → {$rows[1]['url']}");
    }
}

// 4. Menu „Stopka – Informacje” ------------------------------------------------------------
$menuName = 'Stopka – Informacje';
$menu = wp_get_nav_menu_object($menuName);
$items = ['o-mnie' => 'O mnie', 'konsultacje' => 'Konsultacje', 'kontakt' => 'Kontakt', 'poradniki' => 'Poradniki', 'blog' => 'Blog'];

if ($menu) {
    $say("Menu „{$menuName}” już istnieje (ID {$menu->term_id}) — nie dodaję pozycji");
    $menuId = (int) $menu->term_id;
} else {
    $menuId = 0;
    if (! $dry) {
        $menuId = wp_create_nav_menu($menuName);
        if (is_wp_error($menuId)) {
            WP_CLI::error($menuId->get_error_message());
        }
    }
    foreach ($items as $path => $label) {
        $id = $pageId($path);
        $say("Menu: {$label} → " . get_permalink($id));
        if (! $dry) {
            wp_update_nav_menu_item($menuId, 0, [
                'menu-item-title' => $label,
                'menu-item-object' => 'page',
                'menu-item-object-id' => $id,
                'menu-item-type' => 'post_type',
                'menu-item-status' => 'publish',
            ]);
        }
    }
}

$locations = get_theme_mod('nav_menu_locations', []);
if ($menuId && (int) ($locations['footer_info_navigation'] ?? 0) !== $menuId) {
    $say("Menu ID {$menuId} → lokalizacja footer_info_navigation");
    if (! $dry) {
        $locations['footer_info_navigation'] = $menuId;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

WP_CLI::success($dry ? 'Podgląd zakończony — nic nie zapisano.' : 'Linkowanie wewnętrzne: gotowe.');
