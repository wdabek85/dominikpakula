<?php
/**
 * Podstrona usługi: Zakupy ze stylistą → Warszawa (wireframe v4, 28.09.2026).
 * Idempotentny: tworzy albo nadpisuje post `service` /uslugi/zakupy-ze-stylista/warszawa/.
 * Linki budowane z home_url(), więc ten sam plik działa lokalnie, na stagingu i prod.
 *
 * Uruchom: wp eval-file migrations/2026-09-28-warszawa.php
 */

$parent = get_page_by_path('zakupy-ze-stylista', OBJECT, 'service');
if (! $parent) {
    WP_CLI::error('Brak usługi-rodzica zakupy-ze-stylista.');
}

$url = fn (string $path) => home_url($path);
$link = fn (string $path, string $text) => sprintf('<a href="%s">%s</a>', esc_url($url($path)), $text);

/**
 * Pola grupy przypiętej do bloku: name => field (z sub_fields dla repeaterów).
 */
function wa_block_fields(string $block): array
{
    $fields = [];
    foreach (acf_get_field_groups(['block' => $block]) as $group) {
        foreach (acf_get_fields($group) as $field) {
            $fields[$field['name']] = $field;
        }
    }
    if (! $fields) {
        WP_CLI::error("Brak pól ACF dla {$block}");
    }
    return $fields;
}

/**
 * Dane bloku ACF w formacie zapisu edytora: wartość + `_nazwa` => klucz pola.
 * Repeatery: lista wierszy [sub_name => value].
 */
function wa_block(string $name, array $values): string
{
    $fields = wa_block_fields("acf/{$name}");
    $data = [];

    foreach ($values as $key => $value) {
        if (! isset($fields[$key])) {
            WP_CLI::error("Blok {$name}: nieznane pole {$key}");
        }
        $field = $fields[$key];

        if ($field['type'] === 'repeater') {
            $subs = array_column($field['sub_fields'], 'key', 'name');
            foreach (array_values($value) as $i => $row) {
                foreach ($row as $sub => $subValue) {
                    if (! isset($subs[$sub])) {
                        WP_CLI::error("Blok {$name}: nieznane pod-pole {$key}.{$sub}");
                    }
                    $data["{$key}_{$i}_{$sub}"] = $subValue;
                    $data["_{$key}_{$i}_{$sub}"] = $subs[$sub];
                }
            }
            $data[$key] = count($value);
        } else {
            $data[$key] = $value;
        }
        $data["_{$key}"] = $field['key'];
    }

    $attrs = ['name' => "acf/{$name}", 'data' => $data, 'mode' => 'preview'];

    return '<!-- wp:acf/' . $name . ' ' . serialize_block_attributes($attrs) . ' /-->';
}

$blocks = [];

// 2. Jak zaplanujemy zakupy
$blocks[] = wa_block('service-text', [
    'stext_label' => 'Proces Współpracy',
    'stext_heading' => 'Jak zaplanujemy zakupy w Warszawie?',
    'stext_body' => '<p>Zanim ruszymy do sklepów, ustalamy cel zakupów i plan działania. Dzięki temu na miejscu możemy skupić się na przymiarkach i wyborze ubrań.</p>',
    'stext_attached' => 1,
]);
$blocks[] = wa_block('service-process', [
    'process_description' => 'Na przymiarki i decyzje mamy tyle czasu, ile potrzebujesz. Usługa nie ma limitu godzin ani liczby odwiedzonych sklepów.',
    'process_steps' => [
        [
            'process_step_title' => 'Spotkanie przed zakupami',
            'process_step_description' => 'Przed każdymi zakupami spotykamy się, żeby omówić Twoje potrzeby, budżet i organizację dnia. Wyjaśniam, jak się przygotować, odpowiadam na pytania i na tej podstawie dobieram sklepy.',
        ],
        [
            'process_step_title' => 'Pomoc przy każdej przymiarce',
            'process_step_description' => 'Wyszukuję ubrania i sprawdzam z Tobą, jak leżą: w ramionach, w pasie, na całej sylwetce. Porównujemy fasony i rozmiary. Wyjaśniam, co warto wybrać i dlaczego, a Ty oceniasz, w czym czujesz się dobrze.',
        ],
        [
            'process_step_title' => 'Zestawy sprawdzone przed zakupem',
            'process_step_description' => 'Już podczas przymiarek pokazuję Ci, z czym nosić wybrane rzeczy. Sprawdzamy, jak pasują do pozostałych zakupów i ubrań, które masz. Dzięki temu przy kasie wiesz, kiedy i do czego założysz każdą z nich.',
        ],
    ],
]);

// 3. Gdzie na zakupy
$blocks[] = wa_block('service-text', [
    'stext_heading' => 'Gdzie wybierzemy się na zakupy w Warszawie?',
    'stext_body' => '<p>Miejsce zakupów dobieram do tego, czego potrzebujesz i ile chcesz wydać. Po naszej rozmowie wybieram sklepy, których oferta odpowiada Twoim oczekiwaniom — od ubrań do pracy po swobodną garderobę na co dzień.</p>'
        . '<p>Przy planowaniu zakupów możemy wziąć pod uwagę takie miejsca jak Westfield Arkadia, Westfield Mokotów (dawna Galeria Mokotów), Złote Tarasy czy Elektrownia Powiśle. Konkretną lokalizację i plan spotkania ustalimy wcześniej, żeby czas na miejscu poświęcić na przymiarki i wybór ubrań.</p>'
        . '<p>Polecam m.in. COS, ARKET i Massimo Dutti. Pełną listę sklepów dobieram indywidualnie do Twojego stylu, sylwetki i budżetu.</p>',
]);

// 4. Kiedy warto
$blocks[] = wa_block('service-desc-alt', [
    'descb_label' => 'Dla kogo',
    'descb_heading' => 'Kiedy warto wybrać się ze mną na zakupy?',
    'descb_positive_title' => 'Pomogę Ci, jeśli:',
    'descb_positive_items' => [
        ['item_text' => 'wracasz ze sklepów z kolejną rzeczą, do której brakuje reszty stroju;'],
        ['item_text' => 'nosisz wciąż te same ubrania, bo w pozostałych nie czujesz się dobrze;'],
        ['item_text' => 'zależy Ci na dobrym wyglądzie, ale wybieranie ubrań zabiera Ci zbyt dużo czasu.'],
    ],
    'descb_highlight_title' => 'Szczególnie, jeśli:',
    'descb_highlight_items' => [
        ['item_text' => 'nowa praca lub częstsze spotkania wymagają zmiany sposobu ubierania;'],
        ['item_text' => 'zmieniła się Twoja sylwetka i trudno Ci znaleźć odpowiedni fason.'],
    ],
    'descb_negative_title' => 'Potrzebujesz czegoś innego?',
    'descb_negative_items' => [
        ['item_text' => 'Strój na jedno ważne wydarzenie — sprawdź ' . $link('/uslugi/stylizacja-okazjonalna/', 'stylizację okazjonalną')],
        ['item_text' => 'Wolisz wybierać ubrania z domu — zobacz ' . $link('/uslugi/zakupy-online/', 'zakupy online ze stylistą')],
    ],
]);

// 5. Co zyskasz
$blocks[] = wa_block('service-text', [
    'stext_label' => 'Dlaczego Warto',
    'stext_heading' => 'Co zyskasz dzięki wspólnym zakupom?',
    'stext_body' => '<p>Przy każdej propozycji wyjaśniam, na co patrzę i dlaczego warto ją przymierzyć. Te wskazówki wykorzystasz także wtedy, gdy znów wybierzesz się do sklepu sam.</p>',
    'stext_attached' => 1,
]);
$blocks[] = wa_block('service-what', [
    'what_items' => [
        ['what_item_title' => 'Łatwiejsze decyzje w sklepie.', 'what_item_description' => 'Masz obok kogoś, kto zawęża wybór i wyjaśnia różnice między ubraniami. Możesz skupić się na przymierzaniu i porównaniu rzeczy, które odpowiadają Twoim potrzebom.'],
        ['what_item_title' => 'Lepsze dopasowanie ubrań.', 'what_item_description' => 'Zobaczysz, jak długość spodni, szerokość koszuli czy krój marynarki wpływają na wygląd sylwetki. Nauczysz się rozpoznawać, kiedy ubranie dobrze na Tobie leży.'],
        ['what_item_title' => 'Styl, w którym czujesz się sobą.', 'what_item_description' => 'Biorę pod uwagę to, jak pracujesz, spędzasz wolny czas i co lubisz nosić. Twoje odczucia podczas przymiarek są równie ważne jak dopasowanie ubrania.'],
        ['what_item_title' => 'Więcej rozeznania w jakości.', 'what_item_description' => 'Na konkretnych ubraniach pokażę Ci, jak czytać skład i oceniać wykończenie. Wyjaśnię też, jakie znaczenie materiał ma dla wygody i pielęgnacji.'],
        ['what_item_title' => 'Przemyślane wydatki.', 'what_item_description' => 'Ustalamy, czego potrzebujesz najbardziej, i do tego dobieramy zakupy. Każdą propozycję oceniamy także pod kątem ceny oraz tego, jak często będziesz ją nosić.'],
        ['what_item_title' => 'Pomoc także po spotkaniu.', 'what_item_description' => 'Przez 14 dni po zakupach możesz napisać do mnie mailowo. Jeśli przy układaniu stroju pojawi się pytanie, pomogę Ci dobrać połączenie.'],
    ],
]);

// 6. Poznaj mnie — ten sam blok co na innych usługach (hardcoded nagłówek + przycisk otwierający #about-modal)
$blocks[] = '<!-- wp:acf/service-video {"name":"acf/service-video","mode":"preview"} /-->';

// 7. CTA rezerwacji
$blocks[] = wa_block('service-cta', [
    'scta_eyebrow' => 'Zacznijmy od rozmowy',
    'scta_heading' => 'Czego potrzebujesz w swojej garderobie?',
    'scta_text' => 'Opowiedz mi, co lubisz nosić, z czym masz trudność i na jakie sytuacje potrzebujesz ubrań. Wyjaśnię, jak mogę Ci pomóc, i omówimy organizację zakupów w Warszawie. Po rozmowie zdecydujesz, czy chcesz się umówić.',
    'scta_button_text' => 'Umów bezpłatną rozmowę',
    'scta_secondary_text' => 'Kup voucher',
    'scta_secondary_url' => $url('/voucher/'),
]);

$content = implode("\n\n", $blocks);

// --- Post ---
$existing = get_page_by_path('zakupy-ze-stylista/warszawa', OBJECT, 'service');
$postarr = [
    'post_type' => 'service',
    'post_status' => 'publish',
    'post_title' => 'Zakupy ze stylistą Warszawa',
    'post_name' => 'warszawa',
    'post_parent' => $parent->ID,
    'post_content' => $content,
    'post_excerpt' => 'Zakupy ze stylistą w Warszawie dla mężczyzn — dobór ubrań do sylwetki, stylu i budżetu.',
];
if ($existing) {
    $postarr['ID'] = $existing->ID;
}

// wp_slash — inaczej wp_insert_post zje backslashe z JSON-a bloków (< itd.).
$postId = wp_insert_post(wp_slash($postarr), true);
if (is_wp_error($postId)) {
    WP_CLI::error($postId->get_error_message());
}

// --- Pola usługi (sidebar + hero) ---
update_field('service_sidebar_title', 'Zakupy ze stylistą w Warszawie', $postId);
update_field('service_sidebar_description', 'Pomogę Ci wybrać ubrania, w których dobrze wyglądasz i swobodnie się czujesz. Zanim spotkamy się na zakupach w Warszawie, porozmawiamy o Twoim stylu, potrzebach i budżecie. W sklepach dobiorę fasony, sprawdzę dopasowanie i pokażę Ci, jak łączyć nowe rzeczy z tymi, które już nosisz.', $postId);
update_field('service_price', '1800 zł', $postId);
update_field('service_hero_icon', 325, $postId);
update_field('service_hero_caption', "Wiesz, co kupić.\nWiesz, jak to nosić.", $postId);
update_field('service_included_heading', 'Co obejmuje cena?', $postId);
update_field('service_included_items', array_map(fn ($t) => ['service_included_item' => $t], [
    'Indywidualną konsultację o Twoich potrzebach, stylu i budżecie.',
    'Plan zakupów i wybór sklepów w Warszawie.',
    'Wspólne zakupy bez limitu czasu i liczby sklepów.',
    'Dobór ubrań oraz wskazówki dotyczące fasonów, materiałów i łączenia rzeczy w zestawy.',
    'Kontakt mailowy przez 14 dni po zakupach.',
]), $postId);

// Zdjęcie główne — to samo co na karcie „Warszawa” w local-seo rodzica (zakupy-ze-stylista-warszawa.webp).
set_post_thumbnail($postId, 439);

// --- Rank Math ---
update_post_meta($postId, 'rank_math_title', 'Zakupy ze stylistą Warszawa | Dominik Pakuła');
update_post_meta($postId, 'rank_math_description', 'Zakupy ze stylistą w Warszawie dla mężczyzn. Dobierz ze mną ubrania do swojej sylwetki, stylu i budżetu. Cena: 1 800 zł. Umów bezpłatną rozmowę.');
update_post_meta($postId, 'rank_math_focus_keyword', 'zakupy ze stylistą Warszawa,zakupy ze stylistą w Warszawie,personal shopper Warszawa,stylista Warszawa');

// --- Karta „Warszawa” w local-seo na usłudze-rodzicu → link do nowej podstrony ---
$parentBlocks = parse_blocks($parent->post_content);
$changed = false;
foreach ($parentBlocks as &$block) {
    if ($block['blockName'] !== 'acf/local-seo') {
        continue;
    }
    $data = &$block['attrs']['data'];
    for ($i = 0; isset($data["local_items_{$i}_title"]); $i++) {
        if (stripos($data["local_items_{$i}_title"], 'Warszaw') !== false) {
            $data["local_items_{$i}_url"] = get_permalink($postId);
            $changed = true;
        }
    }
    unset($data);
}
unset($block);
if ($changed) {
    wp_update_post(wp_slash(['ID' => $parent->ID, 'post_content' => serialize_blocks($parentBlocks)]));
}

WP_CLI::success(sprintf('Warszawa: ID %d, %s (local-seo rodzica: %s)', $postId, get_permalink($postId), $changed ? 'zaktualizowane' : 'bez zmian'));
