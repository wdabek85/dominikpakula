<?php
/**
 * 16.11.2026 — pytanie o dojazd w istniejących blokach FAQ (właściciel potwierdził: dojazd zawsze wliczony w cenę).
 *  - 5 miast: jako pierwsze pytanie,
 *  - /uslugi/zakupy-ze-stylista/: po „W jakich miastach robisz zakupy?”,
 *  - przegląd szafy i pakiet: po pytaniu o cenę (pierwszym).
 * Odpalaj PO 2026-11-16-poznan / -miasta-faq / -faq-uslugi-konsultacje (te nadpisują FAQ — po ich ponownym
 * uruchomieniu puść też ten plik). Idempotentny: pomija stronę, na której pytanie już jest.
 *
 * Uruchom: wp eval-file migrations/2026-11-16-faq-dojazd.php [dry]
 */

require_once __DIR__ . '/lib/blocks.php';

$dry = in_array('dry', $args ?? [], true);

$city = ['faq_question' => 'Czy dojazd kosztuje dodatkowo?', 'faq_answer' => 'Nie. Dojazd jest zawsze wliczony w cenę usługi – płacisz 1800 zł niezależnie od miasta.'];
$home = ['faq_question' => 'Czy za dojazd do mnie płacę osobno?', 'faq_answer' => 'Nie. Dojazd jest zawsze wliczony w cenę usługi.'];

// slug => [pytanie, pozycja: 'first' | 'after:<treść pytania>' | 'after-first']
$targets = [
    'zakupy-ze-stylista/krakow' => [$city, 'first'],
    'zakupy-ze-stylista/warszawa' => [$city, 'first'],
    'zakupy-ze-stylista/poznan' => [$city, 'first'],
    'zakupy-ze-stylista/wroclaw' => [$city, 'first'],
    'zakupy-ze-stylista/kielce' => [$city, 'first'],
    'zakupy-ze-stylista' => [
        ['faq_question' => 'Czy dojazd kosztuje dodatkowo?', 'faq_answer' => 'Nie. Dojazd do Krakowa, Warszawy, Poznania, Wrocławia i Kielc jest zawsze wliczony w cenę usługi.'],
        'after:W jakich miastach robisz zakupy?',
    ],
    'przeglad-szafy' => [$home, 'after-first'],
    'przeglad-szafy-zakupy' => [$home, 'after-first'],
];

foreach ($targets as $slug => [$item, $position]) {
    $post = get_page_by_path($slug, OBJECT, 'service');
    if (! $post) {
        WP_CLI::warning("Brak strony {$slug}");
        continue;
    }

    $blocks = parse_blocks($post->post_content);
    $at = array_search('acf/service-faq', array_column($blocks, 'blockName'), true);
    if ($at === false) {
        WP_CLI::warning("{$slug}: brak bloku FAQ — pomijam");
        continue;
    }

    $data = $blocks[$at]['attrs']['data'];
    $items = [];
    for ($i = 0; $i < (int) ($data['faq_items'] ?? 0); $i++) {
        $items[] = [
            'faq_question' => $data["faq_items_{$i}_faq_question"] ?? '',
            'faq_answer' => $data["faq_items_{$i}_faq_answer"] ?? '',
        ];
    }

    if (in_array($item['faq_question'], array_column($items, 'faq_question'), true)) {
        WP_CLI::log("{$slug}: pytanie już jest — bez zmian");
        continue;
    }

    if ($position === 'first') {
        $index = 0;
    } elseif ($position === 'after-first') {
        $index = 1;
    } else {
        $anchor = array_search(substr($position, 6), array_column($items, 'faq_question'), true);
        if ($anchor === false) {
            WP_CLI::warning("{$slug}: brak pytania „" . substr($position, 6) . '” — pomijam');
            continue;
        }
        $index = $anchor + 1;
    }
    array_splice($items, $index, 0, [$item]);

    $blocks[$at] = parse_blocks(mig_block('service-faq', [
        'faq_label' => $data['faq_label'] ?? '',
        'faq_description' => $data['faq_description'] ?? '',
        'faq_items' => $items,
    ]))[0];

    WP_CLI::log(sprintf('%s: „%s” jako pytanie nr %d (razem %d)', $slug, $item['faq_question'], $index + 1, count($items)));
    if ($dry) {
        continue;
    }

    $dir = dirname(ABSPATH, 2) . '/sql/backup';
    wp_mkdir_p($dir);
    file_put_contents("{$dir}/post-{$post->ID}-{$post->post_name}-" . date('Ymd-His') . '.html', $post->post_content);
    // wp_slash — inaczej wp_update_post zje backslashe z JSON-a bloków
    wp_update_post(wp_slash(['ID' => $post->ID, 'post_content' => serialize_blocks($blocks)]));
}

WP_CLI::success($dry ? 'dry — nic nie zapisano' : 'gotowe');
