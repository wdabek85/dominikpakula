<?php
/**
 * Podstrona usługi: Zakupy ze stylistą → Wrocław (wireframe v1, 28.09.2026).
 * Ten sam układ co Warszawa (bez sekcji ceny — cena w sidebarze; „Poznajmy się” = blok service-video).
 * Idempotentny: tworzy albo nadpisuje post `service` /uslugi/zakupy-ze-stylista/wroclaw/.
 *
 * Uruchom: wp eval-file migrations/2026-09-28-wroclaw.php
 */

require_once __DIR__ . '/lib/blocks.php';

$parent = get_page_by_path('zakupy-ze-stylista', OBJECT, 'service');
if (! $parent) {
    WP_CLI::error('Brak usługi-rodzica zakupy-ze-stylista.');
}

$link = fn (string $path, string $text) => sprintf('<a href="%s">%s</a>', esc_url(home_url($path)), $text);

$blocks = [];

// Jak wyglądają wspólne zakupy
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Proces Współpracy',
    'stext_heading' => 'Jak wyglądają wspólne zakupy?',
    'stext_body' => '<p>Do sklepów idziemy z ustalonym planem. Ty wiesz, czego szukamy, a ja wiem, jakie propozycje przygotować do przymierzenia.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-process', [
    'process_description' => 'Zakupy odbywają się bez limitu czasu i liczby sklepów. Możemy spokojnie porównać propozycje i dać Ci czas na decyzję.',
    'process_steps' => [
        [
            'process_step_title' => 'Najpierw spotkanie',
            'process_step_description' => 'Przed każdymi zakupami spotykamy się, żeby porozmawiać o Twoich oczekiwaniach, budżecie i obecnej garderobie. Omawiamy przygotowanie oraz organizację zakupów. To również czas na Twoje pytania.',
        ],
        [
            'process_step_title' => 'Przymierzamy i porównujemy',
            'process_step_description' => 'Proponuję konkretne ubrania i sprawdzam ich dopasowanie. Pokazuję, jak zmiana rozmiaru lub kroju wpływa na wygląd, i pytam o Twój komfort. Wspólnie oceniamy, które rzeczy warto wybrać.',
        ],
        [
            'process_step_title' => 'Układamy gotowe połączenia',
            'process_step_description' => 'Z wybranych ubrań tworzymy zestawy na sytuacje, o których rozmawialiśmy. Podpowiadam też, jak wykorzystać rzeczy, które już nosisz. Jeszcze przed zakupem widzisz, jak nowe elementy uzupełnią Twoją garderobę.',
        ],
    ],
]);

// Gdzie na zakupy
$blocks[] = mig_block('service-text', [
    'stext_heading' => 'Gdzie wybierzemy się na zakupy we Wrocławiu?',
    'stext_body' => '<p>Wybór miejsca wynika z planu zakupów. Kiedy wiem, jakich ubrań potrzebujesz i jaki masz budżet, dobieram sklepy, których ofertę warto sprawdzić.</p>'
        . '<p>We Wrocławiu możemy rozważyć takie miejsca jak Westfield Wroclavia przy ul. Suchej, Magnolia Park przy Legnickiej czy Pasaż Grunwaldzki przy placu Grunwaldzkim. Konkretną lokalizację ustalimy przed zakupami, uwzględniając wybrane sklepy i organizację spotkania.</p>'
        . '<p>Wśród polecanych przeze mnie marek są m.in. COS, ARKET i Massimo Dutti. Sklepy do Twojego planu dobiorę indywidualnie.</p>',
]);

// Z czym mogę pomóc (5 punktów: 3 ogólne + 2 „szczególnie”, jak w Warszawie)
$blocks[] = mig_block('service-desc-alt', [
    'descb_label' => 'Dla kogo',
    'descb_heading' => 'Z czym mogę Ci pomóc?',
    'descb_positive_title' => 'To propozycja dla Ciebie, jeśli:',
    'descb_positive_items' => [
        ['item_text' => 'podobają Ci się pojedyncze ubrania, ale trudno Ci złożyć z nich cały strój;'],
        ['item_text' => 'nie masz pewności, które fasony i rozmiary dobrze na Tobie leżą;'],
        ['item_text' => 'wolisz poświęcić czas na przymiarki z konkretną pomocą i planem.'],
    ],
    'descb_highlight_title' => 'Szczególnie, jeśli:',
    'descb_highlight_items' => [
        ['item_text' => 'potrzebujesz ubrań do nowej pracy lub częstszych spotkań zawodowych;'],
        ['item_text' => 'Twoja sylwetka albo styl życia się zmieniły i chcesz odświeżyć garderobę.'],
    ],
    'descb_negative_title' => 'Dopasuj usługę do swojego celu',
    'descb_negative_items' => [
        ['item_text' => 'Na ważne wydarzenie — wybierz ' . $link('/uslugi/stylizacja-okazjonalna/', 'stylizację okazjonalną')],
        ['item_text' => 'Wolisz wybierać ubrania z domu — sprawdź ' . $link('/uslugi/zakupy-online/', 'zakupy online ze stylistą')],
    ],
]);

// Co dają zakupy z osobistym stylistą
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Dlaczego Warto',
    'stext_heading' => 'Co dają zakupy z osobistym stylistą?',
    'stext_body' => '<p>Podczas zakupów tłumaczę swoje propozycje. Dzięki temu poznajesz zasady, do których możesz wrócić, gdy wybierasz ubrania albo układasz strój samodzielnie.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-what', [
    'what_items' => [
        ['what_item_title' => 'Wybór zawężony do Twoich potrzeb.', 'what_item_description' => 'Wyszukuję rzeczy odpowiadające temu, co ustaliliśmy przed spotkaniem. Pomagam porównać propozycje, żeby łatwiej było Ci zdecydować, co zabrać ze sobą do domu.'],
        ['what_item_title' => 'Ubrania, które dobrze leżą.', 'what_item_description' => 'Sprawdzamy proporcje, długości i swobodę ruchu. Na konkretnych przykładach pokazuję Ci, jak rozpoznać właściwe dopasowanie koszuli, spodni czy marynarki.'],
        ['what_item_title' => 'Garderoba zgodna z Twoim gustem.', 'what_item_description' => 'Twoje preferencje są punktem wyjścia. Proponuję nowe możliwości, a przy wyborze biorę pod uwagę zarówno wygląd ubrania, jak i to, czy chcesz je nosić.'],
        ['what_item_title' => 'Wiedza o materiałach.', 'what_item_description' => 'Oglądamy skład, fakturę i wykończenie. Wyjaśniam, co materiał oznacza dla wygody oraz pielęgnacji ubrania i na co zwracać uwagę przy kolejnych zakupach.'],
        ['what_item_title' => 'Zakupy z ustalonymi priorytetami.', 'what_item_description' => 'Zaczynamy od rzeczy, których najbardziej potrzebujesz. Przy każdej propozycji uwzględniamy cenę, jej zastosowanie i to, jak pasuje do pozostałych ubrań.'],
        ['what_item_title' => '14 dni wsparcia e-mailowego.', 'what_item_description' => 'W cenie usługi otrzymujesz także wsparcie e-mailowe przez 14 dni.'],
    ],
]);

// Poznaj mnie — ten sam blok co na innych usługach
$blocks[] = '<!-- wp:acf/service-video {"name":"acf/service-video","mode":"preview"} /-->';

// CTA rezerwacji
$blocks[] = mig_block('service-cta', [
    'scta_eyebrow' => 'Pierwszy krok',
    'scta_heading' => 'Porozmawiajmy o Twoich zakupach we Wrocławiu',
    'scta_text' => 'Powiedz mi, jakie ubrania chcesz znaleźć i w czym potrzebujesz pomocy. Przedstawię Ci sposób współpracy i odpowiem na pytania. Po bezpłatnej rozmowie zdecydujesz, czy chcesz umówić wspólne zakupy.',
    'scta_button_text' => 'Umów bezpłatną rozmowę',
    'scta_secondary_text' => 'Kup voucher',
    'scta_secondary_url' => home_url('/voucher/'),
]);

// --- Post ---
$existing = get_page_by_path('zakupy-ze-stylista/wroclaw', OBJECT, 'service');
$postarr = [
    'post_type' => 'service',
    'post_status' => 'publish',
    'post_title' => 'Zakupy ze stylistą Wrocław',
    'post_name' => 'wroclaw',
    'post_parent' => $parent->ID,
    'menu_order' => 30,
    'post_content' => implode("\n\n", $blocks),
];
if ($existing) {
    $postarr['ID'] = $existing->ID;
}

// wp_slash — inaczej wp_insert_post zje backslashe z JSON-a bloków
$postId = wp_insert_post(wp_slash($postarr), true);
if (is_wp_error($postId)) {
    WP_CLI::error($postId->get_error_message());
}

// --- Sidebar + hero ---
update_field('service_sidebar_title', 'Zakupy ze stylistą we Wrocławiu', $postId);
update_field('service_sidebar_description', 'Pomogę Ci znaleźć ubrania, które dobrze leżą i pasują do tego, jak żyjesz. Przed zakupami we Wrocławiu spotkamy się, żeby ustalić Twoje potrzeby i budżet. W sklepach porównamy fasony, dobierzemy rozmiary i sprawdzimy, jak wybrane rzeczy łączą się w zestawy.', $postId);
update_field('service_price', '1800 zł', $postId);
update_field('service_hero_caption', "Dobrze dobrane ubrania.\nŁatwiejsze codzienne wybory.", $postId);
if ($icon = get_field('service_hero_icon', $parent->ID)) {
    update_field('service_hero_icon', is_array($icon) ? $icon['ID'] : $icon, $postId);
}
update_field('service_included_heading', 'W ramach usługi otrzymujesz', $postId);
update_field('service_included_items', array_map(fn ($t) => ['service_included_item' => $t], [
    'Indywidualne spotkanie przed zakupami.',
    'Plan zakupów i dobór sklepów do Twoich potrzeb.',
    'Wspólne zakupy we Wrocławiu bez limitu czasu i liczby sklepów.',
    'Pomoc w wyborze fasonów, rozmiarów i materiałów oraz tworzeniu zestawów.',
    'Wsparcie e-mailowe przez 14 dni.',
]), $postId);

// Zdjęcie: panorama Wrocławia z migrations/assets — import do biblioteki (raz), potem jako wyróżniające.
// Nie nadpisuje zdjęcia ustawionego później w panelu (podmienia tylko brak zdjęcia albo tymczasowe zdjęcie rodzica).
$imageFile = 'zakupy-ze-stylista-wroclaw.webp';
$imageId = (int) $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare(
    "SELECT post_id FROM {$GLOBALS['wpdb']->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s ORDER BY post_id LIMIT 1",
    '%/' . $GLOBALS['wpdb']->esc_like($imageFile)
));
if (! $imageId) {
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $tmp = wp_tempnam($imageFile);
    copy(__DIR__ . '/assets/' . $imageFile, $tmp);
    $imageId = media_handle_sideload(['name' => $imageFile, 'tmp_name' => $tmp], 0, 'Zakupy ze stylistą Wrocław');
    if (is_wp_error($imageId)) {
        WP_CLI::error('Import zdjęcia: ' . $imageId->get_error_message());
    }
    update_post_meta($imageId, '_wp_attachment_image_alt', 'Panorama Wrocławia ze Sky Tower o zachodzie słońca');
    WP_CLI::log("Zaimportowano zdjęcie Wrocławia (ID {$imageId})");
}
$currentThumb = (int) get_post_thumbnail_id($postId);
if (! $currentThumb || $currentThumb === (int) get_post_thumbnail_id($parent->ID)) {
    set_post_thumbnail($postId, $imageId);
}

// --- Rank Math ---
update_post_meta($postId, 'rank_math_title', 'Zakupy ze stylistą Wrocław | Dominik Pakuła');
update_post_meta($postId, 'rank_math_description', 'Zakupy ze stylistą we Wrocławiu dla mężczyzn. Wybierz ubrania do swojej sylwetki, stylu i budżetu. Cena 1 800 zł. Umów bezpłatną rozmowę.');
update_post_meta($postId, 'rank_math_focus_keyword', 'zakupy ze stylistą Wrocław,zakupy ze stylistą we Wrocławiu,personal shopper Wrocław,stylista Wrocław');

WP_CLI::success(sprintf('Wrocław: ID %d, %s', $postId, get_permalink($postId)));
