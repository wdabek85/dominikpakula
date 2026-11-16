<?php
/**
 * Podstrona usługi: Zakupy ze stylistą → Poznań (prompt 4, 16.11.2026).
 * Szablon i teksty „bez zmian” jak Warszawa (2026-09-28-warszawa.php), Warszawa → Poznań.
 * Bez pytania o dojazd w FAQ i bez zdania z markami — czekają na potwierdzenie właściciela.
 * Do tego: „Gdzie działam” na głównej (+ Poznań), meta description rodzica.
 * Stopka, sekcja miast u rodzica (local_source=children), „Zobacz też” i areaServed
 * w ProfessionalService biorą miasta z podstron — Poznań dochodzi sam.
 * Idempotentny.
 *
 * Uruchom: wp eval-file migrations/2026-11-16-poznan.php [dry]
 */

require_once __DIR__ . '/lib/city.php';

$dry = in_array('dry', $args ?? [], true);

$blocks = [];

// Jak zaplanujemy zakupy
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Proces Współpracy',
    'stext_heading' => 'Jak zaplanujemy zakupy w Poznaniu?',
    'stext_body' => '<p>Poznań to kilka dużych galerii w różnych częściach miasta, więc trasę układamy wcześniej: tak, żeby nie tracić czasu na dojazdy i od razu trafić do sklepów, które pasują do Twojego stylu i budżetu. Na miejscu cały czas poświęcamy na przymiarki.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-process', [
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

// Gdzie na zakupy (bez zdania z markami — do potwierdzenia u właściciela)
$blocks[] = mig_block('service-text', [
    'stext_heading' => 'Gdzie wybierzemy się na zakupy w Poznaniu?',
    'stext_body' => '<p>Sklepy dobieram do tego, czego potrzebujesz i ile chcesz wydać – od garderoby do biura po swobodne ubrania na weekend.</p>'
        . '<p>W Poznaniu najczęściej bierzemy pod uwagę:</p>'
        . '<ul>'
        . '<li><strong>Stary Browar</strong> – w centrum, dobry wybór przy szukaniu lepszej jakości i ponadczasowych fasonów,</li>'
        . '<li><strong>Posnania</strong> – największa galeria w mieście, dużo sklepów w jednym miejscu, wygodna przy większych zakupach,</li>'
        . '<li><strong>Poznań City Center</strong> – przy dworcu Poznań Główny, wygodna, jeśli przyjeżdżasz spoza miasta,</li>'
        . '<li><strong>Galeria Malta</strong> – spokojniejsza, przy Jeziorze Maltańskim.</li>'
        . '</ul>'
        . '<p>Konkretną galerię i plan dnia ustalamy przed spotkaniem. Często łączymy dwie lokalizacje, jeśli to skraca szukanie.</p>'
        . '<p>Pełną listę sklepów dobieram indywidualnie do Twojego stylu, sylwetki i budżetu.</p>',
]);

// Dla kogo (bez zmian)
$blocks[] = mig_block('service-desc-alt', [
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
        ['item_text' => 'Strój na jedno ważne wydarzenie — sprawdź ' . mig_link('/uslugi/stylizacja-okazjonalna/', 'stylizację okazjonalną')],
        ['item_text' => 'Wolisz wybierać ubrania z domu — zobacz ' . mig_link('/uslugi/zakupy-online/', 'zakupy online ze stylistą')],
    ],
]);

// Dlaczego warto (bez zmian)
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Dlaczego Warto',
    'stext_heading' => 'Co zyskasz dzięki wspólnym zakupom?',
    'stext_body' => '<p>Przy każdej propozycji wyjaśniam, na co patrzę i dlaczego warto ją przymierzyć. Te wskazówki wykorzystasz także wtedy, gdy znów wybierzesz się do sklepu sam.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-what', [
    'what_items' => [
        ['what_item_title' => 'Łatwiejsze decyzje w sklepie.', 'what_item_description' => 'Masz obok kogoś, kto zawęża wybór i wyjaśnia różnice między ubraniami. Możesz skupić się na przymierzaniu i porównaniu rzeczy, które odpowiadają Twoim potrzebom.'],
        ['what_item_title' => 'Lepsze dopasowanie ubrań.', 'what_item_description' => 'Zobaczysz, jak długość spodni, szerokość koszuli czy krój marynarki wpływają na wygląd sylwetki. Nauczysz się rozpoznawać, kiedy ubranie dobrze na Tobie leży.'],
        ['what_item_title' => 'Styl, w którym czujesz się sobą.', 'what_item_description' => 'Biorę pod uwagę to, jak pracujesz, spędzasz wolny czas i co lubisz nosić. Twoje odczucia podczas przymiarek są równie ważne jak dopasowanie ubrania.'],
        ['what_item_title' => 'Więcej rozeznania w jakości.', 'what_item_description' => 'Na konkretnych ubraniach pokażę Ci, jak czytać skład i oceniać wykończenie. Wyjaśnię też, jakie znaczenie materiał ma dla wygody i pielęgnacji.'],
        ['what_item_title' => 'Przemyślane wydatki.', 'what_item_description' => 'Ustalamy, czego potrzebujesz najbardziej, i do tego dobieramy zakupy. Każdą propozycję oceniamy także pod kątem ceny oraz tego, jak często będziesz ją nosić.'],
        ['what_item_title' => 'Pomoc także po spotkaniu.', 'what_item_description' => 'Przez 14 dni po zakupach możesz napisać do mnie mailowo. Jeśli przy układaniu stroju pojawi się pytanie, pomogę Ci dobrać połączenie.'],
    ],
]);

// Poznaj mnie — ten sam blok co na innych usługach
$blocks[] = '<!-- wp:acf/service-video {"name":"acf/service-video","mode":"preview"} /-->';

// CTA końcowe (+ voucher → /voucher/, miasta nie mają osobnych wariantów vouchera)
$blocks[] = mig_block('service-cta', [
    'scta_eyebrow' => 'Zacznijmy od rozmowy',
    'scta_heading' => 'Czego potrzebujesz w swojej garderobie?',
    'scta_text' => 'Opowiedz mi, co lubisz nosić, z czym masz trudność i na jakie sytuacje potrzebujesz ubrań. Wyjaśnię, jak mogę Ci pomóc, i omówimy organizację zakupów w Poznaniu. Po rozmowie zdecydujesz, czy chcesz się umówić.',
    'scta_button_text' => 'Umów bezpłatną rozmowę',
    'scta_secondary_text' => 'Kup voucher',
    'scta_secondary_url' => home_url('/voucher/'),
]);

// Lokalne FAQ (→ FAQPage w JSON-LD przez app/Schema/Faq.php). Pytanie o dojazd — po potwierdzeniu kosztu.
$blocks[] = mig_block('service-faq', [
    'faq_label' => 'Zakupy ze stylistą w Poznaniu – pytania',
    'faq_items' => [
        ['faq_question' => 'Ile trwają zakupy?', 'faq_answer' => 'Tyle, ile potrzebujesz. Usługa nie ma limitu godzin ani liczby sklepów – plan dnia ustalamy na rozmowie przed zakupami.'],
        ['faq_question' => 'W której galerii się spotkamy?', 'faq_answer' => 'Dobieram ją do Twoich potrzeb. Najczęściej to Stary Browar, Posnania albo Poznań City Center – dokładne miejsce ustalamy przed spotkaniem.'],
        ['faq_question' => 'Mieszkam pod Poznaniem. Czy to problem?', 'faq_answer' => 'Nie. Spotykamy się w wybranej galerii w Poznaniu. Jeśli wolisz nie jeździć, zobacz zakupy online ze stylistą.'],
    ],
]);

if ($dry) {
    WP_CLI::log('[dry] Poznań: ' . count($blocks) . ' bloków; bez zapisu.');
} else {
    $postId = mig_city_page([
        'slug' => 'poznan',
        'title' => 'Zakupy ze stylistą Poznań',
        'order' => 25, // po Warszawie (20), przed Wrocławiem (30) — kolejność jak w zdaniu „Gdzie działam”
        'sidebar_title' => 'Zakupy ze stylistą Poznań',
        'sidebar_description' => 'Pomogę Ci wybrać ubrania, w których dobrze wyglądasz i swobodnie się czujesz – także w Poznaniu. Zanim pójdziemy na zakupy, porozmawiamy o Twoim stylu, pracy, budżecie i o tym, czego w szafie brakuje Ci najbardziej. Na miejscu dobieram fasony, sprawdzam dopasowanie i od razu pokazuję, jak łączyć nowe rzeczy z tymi, które już masz.',
        'hero_caption' => "Wiesz, co kupić.\nWiesz, jak to nosić.",
        'included_heading' => 'Co obejmuje cena?',
        'included' => [
            'Indywidualną konsultację o Twoich potrzebach, stylu i budżecie.',
            'Plan zakupów i wybór sklepów w Poznaniu.',
            'Wspólne zakupy bez limitu czasu i liczby sklepów.',
            'Dobór ubrań oraz wskazówki dotyczące fasonów, materiałów i łączenia rzeczy w zestawy.',
            'Kontakt mailowy przez 14 dni po zakupach.',
        ],
        'rank_title' => 'Stylista męski Poznań – zakupy ze stylistą 1800 zł',
        'rank_description' => 'Stylista męski w Poznaniu: wspólne zakupy w najlepszych galeriach miasta. Ubrania dobrane do sylwetki i budżetu. 1800 zł. Umów bezpłatną rozmowę.',
        'rank_keywords' => 'stylista męski Poznań,zakupy ze stylistą Poznań,zakupy ze stylistą w Poznaniu,personal shopper Poznań',
        // Brak zdjęcia Poznania — zdjęcie usługi-rodzica (zdjęcie Warszawy pokazuje Warszawę).
    ], $blocks);
    update_field('service_city', 'Poznań', $postId);
    wp_update_post(['ID' => $postId, 'post_excerpt' => 'Zakupy ze stylistą w Poznaniu dla mężczyzn — dobór ubrań do sylwetki, stylu i budżetu.']);
}

// --- Strona główna: „Gdzie działam” — zdanie + link do Poznania po Warszawie ---
$front = get_post((int) get_option('page_on_front'));
$poznan = get_page_by_path('zakupy-ze-stylista/poznan', OBJECT, 'service');
$warszawa = get_page_by_path('zakupy-ze-stylista/warszawa', OBJECT, 'service');
$frontBlocks = parse_blocks($front->post_content);
$frontChanged = false;
foreach ($frontBlocks as &$block) {
    if ($block['blockName'] !== 'acf/service-areas') {
        continue;
    }
    $data = &$block['attrs']['data'];
    $text = 'Zakupy ze stylistą robię w Krakowie, Warszawie, Poznaniu, Wrocławiu i Kielcach, a zakupy online z całej Polski.';
    if (($data['areas_text'] ?? '') !== $text) {
        $data['areas_text'] = $text;
        $frontChanged = true;
    }
    $links = array_map('strval', (array) ($data['areas_links'] ?? []));
    if ($poznan && ! in_array((string) $poznan->ID, $links, true)) {
        $at = $warszawa ? array_search((string) $warszawa->ID, $links, true) : false;
        array_splice($links, $at === false ? count($links) : $at + 1, 0, [(string) $poznan->ID]);
        $data['areas_links'] = $links;
        $frontChanged = true;
    }
    unset($data);
}
unset($block);
WP_CLI::log('Strona główna „Gdzie działam”: ' . ($frontChanged ? 'do zmiany' : 'bez zmian') . ($poznan ? '' : ' (brak posta Poznań — linku nie dodano)'));
if ($frontChanged && ! $dry) {
    wp_update_post(wp_slash(['ID' => $front->ID, 'post_content' => serialize_blocks($frontBlocks)]));
}

// --- Rodzic: meta description ---
$parent = mig_city_parent();
$desc = 'Personal shopper dla mężczyzn: wspólne zakupy w Krakowie, Warszawie, Poznaniu, Wrocławiu i Kielcach. Ubrania dobrane do sylwetki i budżetu. 1800 zł.';
WP_CLI::log('Rodzic meta description: ' . get_post_meta($parent->ID, 'rank_math_description', true) . ' → ' . $desc);
if (! $dry) {
    update_post_meta($parent->ID, 'rank_math_description', $desc);
}

WP_CLI::success($dry ? 'dry — nic nie zapisano' : 'Poznań gotowy');
