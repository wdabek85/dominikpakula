<?php
/**
 * 16.11.2026 — strona główna, sekcja „Gdzie działam”:
 *  - blok acf/service-areas przeniesiony pod blog (acf/blog), nad newsletter;
 *  - nowy tekst z „{miasta}” (lista miast składa się z podstron, ServiceAreasBlockComposer);
 *  - areas_links = tylko Zakupy online (miasta dopisują się same, po nim);
 *  - pole service_city_genitive (dopełniacz) na 5 podstronach miast.
 * Idempotentny.
 *
 * Uruchom: wp eval-file migrations/2026-11-16-gdzie-dzialam.php [dry]
 */

require_once __DIR__ . '/lib/blocks.php';

$dry = in_array('dry', $args ?? [], true);

$text = 'Działam w całej Polsce. Zakupy online ze stylistą zrobisz z dowolnego miasta, a na zakupy stacjonarne przyjeżdżam do {miasta} – dojazd jest zawsze w cenie usługi. Kolejne miasta dochodzą stopniowo.';

// --- Dopełniacz na podstronach miast ---
$genitive = ['krakow' => 'Krakowa', 'warszawa' => 'Warszawy', 'poznan' => 'Poznania', 'wroclaw' => 'Wrocławia', 'kielce' => 'Kielc'];
foreach ($genitive as $slug => $value) {
    $post = get_page_by_path("zakupy-ze-stylista/{$slug}", OBJECT, 'service');
    if (! $post) {
        WP_CLI::warning("Brak strony {$slug}");
        continue;
    }
    WP_CLI::log("{$slug}: service_city_genitive = {$value}");
    if (! $dry) {
        update_post_meta($post->ID, 'service_city_genitive', $value);
        update_post_meta($post->ID, '_service_city_genitive', 'field_service_city_genitive');
    }
}

// --- Strona główna ---
$front = get_post((int) get_option('page_on_front'));
$blocks = parse_blocks($front->post_content);
$names = array_column($blocks, 'blockName');

$areasAt = array_search('acf/service-areas', $names, true);
if ($areasAt === false) {
    WP_CLI::error('Brak bloku acf/service-areas na stronie głównej');
}

$online = get_page_by_path('zakupy-online', OBJECT, 'service');
$areas = $blocks[$areasAt];
$areas['attrs']['data']['areas_text'] = $text;
$areas['attrs']['data']['_areas_text'] = 'field_areas_text';
$areas['attrs']['data']['areas_links'] = $online ? [(string) $online->ID] : [];
$areas['attrs']['data']['_areas_links'] = 'field_areas_links';

// Wytnij blok razem z następującym separatorem (\n\n), wstaw po acf/blog.
$separator = $blocks[$areasAt + 1] ?? null;
$cut = ($separator && $separator['blockName'] === null) ? 2 : 1;
array_splice($blocks, $areasAt, $cut);

$blogAt = array_search('acf/blog', array_column($blocks, 'blockName'), true);
if ($blogAt === false) {
    WP_CLI::error('Brak bloku acf/blog na stronie głównej');
}
// Układ „blog, \n\n, Gdzie działam, \n\n, newsletter”.
$sep = ['blockName' => null, 'attrs' => [], 'innerBlocks' => [], 'innerHTML' => "\n\n", 'innerContent' => ["\n\n"]];
$at = (($blocks[$blogAt + 1]['blockName'] ?? 'x') === null) ? $blogAt + 2 : $blogAt + 1;
array_splice($blocks, $at, 0, $at === $blogAt + 2 ? [$areas, $sep] : [$sep, $areas, $sep]);

$order = array_values(array_filter(array_column($blocks, 'blockName')));
WP_CLI::log('Kolejność: ' . implode(' → ', $order));

$new = serialize_blocks($blocks);
if ($new === $front->post_content) {
    WP_CLI::success('Strona główna bez zmian');
    return;
}

if (! $dry) {
    $dir = dirname(ABSPATH, 2) . '/sql/backup';
    wp_mkdir_p($dir);
    file_put_contents("{$dir}/post-{$front->ID}-home-" . date('Ymd-His') . '.html', $front->post_content);
    // wp_slash — inaczej wp_update_post zje backslashe z JSON-a bloków
    wp_update_post(wp_slash(['ID' => $front->ID, 'post_content' => $new]));
}

WP_CLI::success($dry ? 'dry — nic nie zapisano' : 'gotowe');
