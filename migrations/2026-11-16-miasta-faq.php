<?php
/**
 * Prompt 5 (16.11.2026) — zróżnicowanie stron miast i kanibalizacja:
 *  - lokalne FAQ (acf/service-faq → FAQPage) na Warszawie, Krakowie, Wrocławiu i Kielcach,
 *    wstawiane po bloku CTA; galerie tylko te, które już są w sekcji „Gdzie…” danej strony;
 *  - title strony głównej bez „Kraków” (oddaje frazę stronie Krakowa).
 * Teksty Poznania: 2026-11-16-poznan.php (puść go ponownie). Canonicali nie rusza.
 * Idempotentny: pomija stronę, która ma już blok FAQ.
 *
 * Uruchom: wp eval-file migrations/2026-11-16-miasta-faq.php [dry]
 */

require_once __DIR__ . '/lib/city.php';

$dry = in_array('dry', $args ?? [], true);

$duration = ['faq_question' => 'Ile trwają zakupy?', 'faq_answer' => 'Tyle, ile potrzebujesz. Usługa nie ma limitu godzin ani liczby sklepów.'];
$gallery = fn (string $list) => [
    'faq_question' => 'W której galerii się spotkamy?',
    'faq_answer' => "Dobieram ją do Twoich potrzeb. Najczęściej to {$list} – dokładne miejsce ustalamy przed spotkaniem.",
];

$faqs = [
    'warszawa' => [
        'label' => 'Zakupy ze stylistą w Warszawie – pytania',
        'items' => [
            $gallery('Westfield Arkadia, Westfield Mokotów, Złote Tarasy albo Elektrownia Powiśle'),
            $duration,
            ['faq_question' => 'Mieszkam pod Warszawą. Czy to problem?', 'faq_answer' => 'Nie. Spotykamy się w wybranej galerii w Warszawie. Jeśli wolisz nie jeździć, zobacz zakupy online ze stylistą.'],
        ],
    ],
    'krakow' => [
        'label' => 'Zakupy ze stylistą w Krakowie – pytania',
        'items' => [$gallery('Galeria Krakowska, Bonarka albo Galeria Kazimierz'), $duration],
    ],
    'wroclaw' => [
        'label' => 'Zakupy ze stylistą we Wrocławiu – pytania',
        'items' => [$gallery('Westfield Wroclavia, Magnolia Park albo Pasaż Grunwaldzki'), $duration],
    ],
    'kielce' => [
        'label' => 'Zakupy ze stylistą w Kielcach – pytania',
        'items' => [$gallery('Galeria Echo albo Galeria Korona Kielce'), $duration],
    ],
];

foreach ($faqs as $slug => $faq) {
    $post = get_page_by_path("zakupy-ze-stylista/{$slug}", OBJECT, 'service');
    if (! $post) {
        WP_CLI::warning("Brak strony {$slug}");
        continue;
    }

    $blocks = parse_blocks($post->post_content);
    if (in_array('acf/service-faq', array_column($blocks, 'blockName'), true)) {
        WP_CLI::log("{$slug}: FAQ już jest — bez zmian");
        continue;
    }

    $faqBlock = parse_blocks(mig_block('service-faq', ['faq_label' => $faq['label'], 'faq_items' => $faq['items']]))[0];
    $at = array_search('acf/service-cta', array_column($blocks, 'blockName'), true);
    $at = $at === false ? count($blocks) : $at + 1;
    array_splice($blocks, $at, 0, [
        ['blockName' => null, 'attrs' => [], 'innerBlocks' => [], 'innerHTML' => "\n\n", 'innerContent' => ["\n\n"]],
        $faqBlock,
    ]);

    WP_CLI::log("{$slug}: dodaję FAQ (" . count($faq['items']) . ' pyt.) po bloku CTA');
    if ($dry) {
        continue;
    }

    $dir = dirname(ABSPATH, 2) . '/sql/backup';
    wp_mkdir_p($dir);
    file_put_contents("{$dir}/post-{$post->ID}-{$slug}-" . date('Ymd-His') . '.html', $post->post_content);
    // wp_slash — inaczej wp_update_post zje backslashe z JSON-a bloków
    wp_update_post(wp_slash(['ID' => $post->ID, 'post_content' => serialize_blocks($blocks)]));
}

// --- Strona główna: title bez „Kraków” ---
$frontId = (int) get_option('page_on_front');
$title = 'Stylista męski – Dominik Pakuła | zakupy, przegląd szafy, online';
WP_CLI::log('Title głównej: ' . get_post_meta($frontId, 'rank_math_title', true) . " → {$title}");
if (! $dry) {
    update_post_meta($frontId, 'rank_math_title', $title);
}

WP_CLI::success($dry ? 'dry — nic nie zapisano' : 'gotowe');
