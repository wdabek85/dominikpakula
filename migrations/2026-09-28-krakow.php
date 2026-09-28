<?php
/**
 * Podstrona usługi: Zakupy ze stylistą → Kraków (wireframe v1, 28.09.2026) — przebudowa.
 * Wcześniej treść Krakowa była w ~40% kopią strony „Zakupy ze stylistą” (kanibalizacja).
 * Układ jak Warszawa / Wrocław (bez sekcji ceny — cena w sidebarze; „Poznajmy się” = service-video).
 * Idempotentny. Poprzednią treść zapisuje do <bedrock>/sql/backup przed nadpisaniem.
 *
 * Uruchom: wp eval-file migrations/2026-09-28-krakow.php
 */

require_once __DIR__ . '/lib/blocks.php';

$parent = get_page_by_path('zakupy-ze-stylista', OBJECT, 'service');
if (! $parent) {
    WP_CLI::error('Brak usługi-rodzica zakupy-ze-stylista.');
}

$link = fn (string $path, string $text) => sprintf('<a href="%s">%s</a>', esc_url(home_url($path)), $text);

$blocks = [];

// Od rozmowy do ubrań
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Proces Współpracy',
    'stext_heading' => 'Od rozmowy do ubrań dobranych dla Ciebie',
    'stext_body' => '<p>Przed każdymi zakupami spotykamy się, żeby ustalić, czego będziemy szukać. Dzięki temu czas w sklepach możemy poświęcić na przymiarki i wybór konkretnych rzeczy.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-process', [
    'process_description' => 'Zakupy nie mają limitu czasu ani liczby sklepów. Jest przestrzeń na porównanie propozycji, pytania i spokojną decyzję.',
    'process_steps' => [
        [
            'process_step_title' => 'Ustalamy, czego potrzebujesz',
            'process_step_description' => 'Rozmawiamy o tym, co nosisz, w czym czujesz się dobrze i jakich ubrań Ci brakuje. Ustalamy budżet oraz priorytety. Na tym spotkaniu omawiam też przygotowanie i organizację zakupów oraz odpowiadam na Twoje pytania.',
        ],
        [
            'process_step_title' => 'Sprawdzamy ubrania w przymierzalni',
            'process_step_description' => 'Wybieram propozycje i pomagam ocenić je na Twojej sylwetce. Porównujemy kroje, rozmiary i kolory. Zwracam uwagę na szczegóły dopasowania, a Ty sprawdzasz, jak czujesz się w danym ubraniu.',
        ],
        [
            'process_step_title' => 'Łączymy rzeczy w zestawy',
            'process_step_description' => 'Już podczas przymiarek pokazuję Ci, z czym nosić wybrane ubrania. Sprawdzamy różne połączenia i ich zastosowanie w Twoim życiu. Przed podjęciem decyzji wiesz, do czego przyda Ci się każda rzecz.',
        ],
    ],
]);

// Gdzie na zakupy
$blocks[] = mig_block('service-text', [
    'stext_heading' => 'Gdzie wybierzemy się na zakupy w Krakowie?',
    'stext_body' => '<p>Miejsce wybieramy po rozmowie o Twoich potrzebach. Innych propozycji będziemy szukać, gdy uzupełniasz ubrania do biura, a innych, gdy zależy Ci na swobodnej garderobie na co dzień. Dobieram sklepy tak, żeby ich oferta odpowiadała temu, czego szukasz i ile chcesz wydać.</p>'
        . '<p>Planując zakupy w Krakowie, możemy wziąć pod uwagę Galerię Krakowską przy ul. Pawiej, Bonarkę przy ul. Kamieńskiego lub Galerię Kazimierz przy ul. Podgórskiej. O wyborze zdecydują potrzebne sklepy i ustalony plan. Konkretną lokalizację uzgodnimy przed zakupami.</p>',
]);

// Kiedy warto (5 punktów: 3 + 2 „szczególnie”, jak w innych miastach)
$blocks[] = mig_block('service-desc-alt', [
    'descb_label' => 'Dla kogo',
    'descb_heading' => 'Kiedy warto skorzystać z pomocy przy zakupach?',
    'descb_positive_title' => 'Pomogę Ci, jeśli:',
    'descb_positive_items' => [
        ['item_text' => 'często przymierzasz ubrania, ale trudno Ci ocenić, czy dobrze leżą;'],
        ['item_text' => 'kupujesz rzeczy, do których później brakuje Ci reszty stroju;'],
        ['item_text' => 'chcesz spróbować czegoś nowego i potrzebujesz konkretnych propozycji.'],
    ],
    'descb_highlight_title' => 'Szczególnie, jeśli:',
    'descb_highlight_items' => [
        ['item_text' => 'chcesz dopasować garderobę do nowej pracy lub zmiany stylu życia;'],
        ['item_text' => 'potrzebujesz innych fasonów po zmianie sylwetki.'],
    ],
    'descb_negative_title' => 'Wybierz zakres pomocy, którego potrzebujesz',
    'descb_negative_items' => [
        ['item_text' => 'Strój na jedno ważne wydarzenie — sprawdź ' . $link('/uslugi/stylizacja-okazjonalna/', 'stylizację okazjonalną')],
        ['item_text' => 'Wolisz wybierać ubrania bez wizyty w sklepach — skorzystaj z ' . $link('/uslugi/zakupy-online/', 'zakupów online ze stylistą')],
    ],
]);

// Co zyskujesz
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Dlaczego Warto',
    'stext_heading' => 'Co zyskujesz podczas wspólnych zakupów?',
    'stext_body' => '<p>Przy każdej propozycji wyjaśniam, dlaczego warto ją przymierzyć i na co zwrócić uwagę. Dzięki temu lepiej poznajesz swoje możliwości i łatwiej oceniasz kolejne ubrania.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-what', [
    'what_items' => [
        ['what_item_title' => 'Łatwiejsze decyzje w sklepach.', 'what_item_description' => 'Wyszukuję propozycje zgodne z naszym planem i pomagam je porównać. Możesz skupić się na przymiarkach, zamiast samodzielnie przeglądać całą ofertę.'],
        ['what_item_title' => 'Lepsze dopasowanie do sylwetki.', 'what_item_description' => 'Sprawdzamy między innymi długość rękawów, ułożenie spodni i swobodę w ramionach. Pokazuję Ci, po czym rozpoznać właściwy krój i rozmiar.'],
        ['what_item_title' => 'Styl, w którym czujesz się sobą.', 'what_item_description' => 'Biorę pod uwagę Twój gust, codzienne zajęcia i wygodę. Możesz sprawdzić nowe fasony lub kolory i zdecydować, które z nich chcesz wprowadzić do swojej garderoby.'],
        ['what_item_title' => 'Praktyczna wiedza o jakości.', 'what_item_description' => 'Przyglądamy się materiałom i wykończeniu ubrań. Tłumaczę, jak skład wpływa na komfort noszenia oraz pielęgnację i co warto sprawdzić przed zakupem.'],
        ['what_item_title' => 'Przemyślane wykorzystanie budżetu.', 'what_item_description' => 'Wybieramy według ustalonych priorytetów. Oceniamy cenę, dopasowanie i możliwości noszenia danej rzeczy, żeby miała swoje miejsce w Twojej garderobie.'],
        ['what_item_title' => '14 dni wsparcia e-mailowego.', 'what_item_description' => 'W cenie usługi otrzymujesz również wsparcie e-mailowe przez 14 dni.'],
    ],
]);

// Poznaj mnie — ten sam blok co na innych usługach
$blocks[] = '<!-- wp:acf/service-video {"name":"acf/service-video","mode":"preview"} /-->';

// CTA rezerwacji
$blocks[] = mig_block('service-cta', [
    'scta_eyebrow' => 'Zacznijmy od rozmowy',
    'scta_heading' => 'Zaplanujmy Twoje zakupy w Krakowie',
    'scta_text' => 'Opowiedz mi, czego potrzebujesz i jakie zmiany chcesz wprowadzić w swoim ubiorze. Wyjaśnię, jak mogę Ci pomóc, i odpowiem na pytania. Pierwsza rozmowa jest bezpłatna — decyzję o wspólnych zakupach podejmiesz po niej.',
    'scta_button_text' => 'Umów bezpłatną rozmowę',
    'scta_secondary_text' => 'Kup voucher',
    'scta_secondary_url' => home_url('/voucher/'),
]);

// --- Post ---
$existing = get_page_by_path('zakupy-ze-stylista/krakow', OBJECT, 'service');
$postarr = [
    'post_type' => 'service',
    'post_status' => 'publish',
    'post_title' => 'Zakupy ze stylistą Kraków',
    'post_name' => 'krakow',
    'post_parent' => $parent->ID,
    'menu_order' => 10,
    'post_content' => implode("\n\n", $blocks),
];
if ($existing) {
    $postarr['ID'] = $existing->ID;
    // Backup poprzedniej treści (tylko gdy się zmienia)
    if ($existing->post_content !== $postarr['post_content']) {
        $dir = dirname(ABSPATH, 2) . '/sql/backup';
        wp_mkdir_p($dir);
        file_put_contents("{$dir}/post-{$existing->ID}-krakow-" . date('Ymd-His') . '.html', $existing->post_content);
    }
}

// wp_slash — inaczej wp_insert_post zje backslashe z JSON-a bloków
$postId = wp_insert_post(wp_slash($postarr), true);
if (is_wp_error($postId)) {
    WP_CLI::error($postId->get_error_message());
}

// --- Sidebar + hero ---
update_field('service_sidebar_title', 'Zakupy ze stylistą w Krakowie', $postId);
update_field('service_sidebar_description', 'Dobre zakupy zaczynają się od tego, czego potrzebujesz na co dzień. Pomogę Ci wybrać ubrania do pracy, na spotkania i na wolny czas — dopasowane do Twojej sylwetki, gustu i budżetu. Podczas przymiarek sprawdzimy, jak leżą, i ułożymy z nich zestawy, które możesz od razu nosić.', $postId);
update_field('service_price', '1800 zł', $postId);
update_field('service_hero_caption', "Znajdź ubrania, po które\nbędziesz chętnie sięgać.", $postId);
if (! get_field('service_hero_icon', $postId) && ($icon = get_field('service_hero_icon', $parent->ID))) {
    update_field('service_hero_icon', is_array($icon) ? $icon['ID'] : $icon, $postId);
}
update_field('service_included_heading', 'Co obejmuje cena?', $postId);
update_field('service_included_items', array_map(fn ($t) => ['service_included_item' => $t], [
    'Spotkanie przed zakupami i ustalenie Twoich potrzeb.',
    'Dobór sklepów do planu zakupów i budżetu.',
    'Wspólne zakupy bez limitu czasu i liczby sklepów.',
    'Pomoc w doborze fasonów, rozmiarów i materiałów oraz łączeniu ubrań.',
    'Wsparcie e-mailowe przez 14 dni.',
]), $postId);

// Zdjęcie: Kraków ma już własne — nie nadpisujemy (fallback: zdjęcie usługi-rodzica)
if (! has_post_thumbnail($postId) && ($thumb = get_post_thumbnail_id($parent->ID))) {
    set_post_thumbnail($postId, $thumb);
}

// --- Rank Math ---
update_post_meta($postId, 'rank_math_title', 'Zakupy ze stylistą Kraków | Dominik Pakuła');
update_post_meta($postId, 'rank_math_description', 'Zakupy ze stylistą w Krakowie dla mężczyzn. Dobierz ubrania do swojej sylwetki, potrzeb i budżetu. Cena 1 800 zł. Umów bezpłatną rozmowę.');
update_post_meta($postId, 'rank_math_focus_keyword', 'zakupy ze stylistą Kraków,zakupy ze stylistą w Krakowie,personal shopper Kraków,stylista Kraków');

WP_CLI::success(sprintf('Kraków: ID %d, %s', $postId, get_permalink($postId)));
