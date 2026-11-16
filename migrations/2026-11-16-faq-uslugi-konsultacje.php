<?php
/**
 * Prompt 6 (16.11.2026) — FAQ na 5 usługach zamiast tekstów zastępczych z szablonu
 * + rozbudowa /konsultacje/ (literówki w nagłówku, 3 sekcje text-columns, FAQ).
 * Zastępuje 2026-09-28-faq-przeglad-zakupy.php (pakiet dostaje nowe pytania).
 * Pominięte: pytanie stylizacji „Na ile przed wydarzeniem się zgłosić?” (czeka na liczbę dni od właściciela).
 * Idempotentny: FAQ nadpisuje dane bloku; sekcje /konsultacje/ dodaje raz.
 *
 * Uruchom: wp eval-file migrations/2026-11-16-faq-uslugi-konsultacje.php [dry]
 */

require_once __DIR__ . '/lib/city.php'; // mig_block + mig_link

$dry = in_array('dry', $args ?? [], true);

$q = fn (string $question, string $answer) => ['faq_question' => $question, 'faq_answer' => $answer];

$faqs = [
    'przeglad-szafy' => [
        $q('Ile kosztuje przegląd szafy?', '1400 zł. To stała cena usługi – rozmowa przed współpracą jest bezpłatna.'),
        $q('Gdzie odbywa się przegląd szafy?', 'U Ciebie w domu. Pracujemy na Twoich ubraniach: oglądamy, przymierzamy i od razu decydujemy, co zostaje, a co odchodzi.'),
        $q('Co dostanę po przeglądzie?', 'Gotowe zestawy ułożone z rzeczy, które już masz, proste zasady łączenia ubrań oraz listę braków z poleceniami konkretnych produktów – co warto dokupić i w jakiej kolejności.'),
        $q('Czy muszę coś wyrzucać?', 'Decyzja zawsze należy do Ciebie. Wyjaśniam, dlaczego dana rzecz działa albo nie, a Ty decydujesz, co z nią zrobić.'),
        $q('Czy po przeglądzie muszę iść na zakupy?', 'Nie. Lista braków to plan na przyszłość. Jeśli chcesz od razu je uzupełnić, wybierz pakiet Przegląd szafy + zakupy.'),
        $q('Czy mogę podarować przegląd szafy w prezencie?', 'Tak. Voucher kupisz na stronie voucherów – dostajesz go jako PDF na e-mail od razu po zakupie.'),
    ],
    'zakupy-ze-stylista' => [
        $q('Ile kosztują zakupy ze stylistą?', '1800 zł – to koszt usługi. Ubrania kupujesz za własne pieniądze, w budżecie, który ustalamy na rozmowie przed zakupami.'),
        $q('Ile trwają zakupy?', 'Tyle, ile potrzebujesz. Usługa nie ma limitu godzin ani liczby odwiedzonych sklepów.'),
        $q('W jakich miastach robisz zakupy?', 'W Krakowie, Warszawie, Poznaniu, Wrocławiu i Kielcach. Jeśli mieszkasz gdzie indziej, wybierz zakupy online ze stylistą.'),
        $q('Jak wybierasz sklepy?', 'Na podstawie rozmowy: Twojego stylu, sylwetki, potrzeb i budżetu. Plan sklepów przygotowuję przed spotkaniem, żeby na miejscu skupić się na przymiarkach.'),
        $q('Co, jeśli po zakupach będę miał pytania?', 'Przez 14 dni po zakupach możesz pisać do mnie mailowo – na przykład gdy nie wiesz, jak połączyć nowe rzeczy z tymi, które już masz.'),
        $q('Kiedy płacę?', 'Dopiero gdy po bezpłatnej rozmowie zdecydujesz się na współpracę. Obowiązuje 30-dniowa gwarancja zwrotu pieniędzy.'),
    ],
    'zakupy-online' => [
        $q('Ile kosztują zakupy online ze stylistą?', '1400 zł. To koszt usługi – ubrania zamawiasz sam z przygotowanych linków.'),
        $q('Jak wyglądają zakupy online?', 'Zaczynamy od konsultacji online: cel, styl, budżet, rozmiary i preferencje. Potem dostajesz listę konkretnych produktów z linkami i wyjaśnieniem, dlaczego warto wybrać każdy z nich, a ja układam z nich gotowe stylizacje.'),
        $q('Skąd wiesz, jaki rozmiar zamówić?', 'Na konsultacji zbieramy Twoje rozmiary i preferencje kroju. Przy każdej propozycji dostajesz rekomendację rozmiaru i fasonu, żeby ograniczyć nietrafione zamówienia.'),
        $q('Czy mogę skorzystać, jeśli nie mieszkam w dużym mieście?', 'Tak – usługa jest dla mężczyzn z całej Polski. Wszystko odbywa się online.'),
        $q('Na jakie okazje dostanę stylizacje?', 'Na te, których potrzebujesz – na przykład do pracy, na spotkanie biznesowe czy na randkę.'),
        $q('Czy po zakupach mogę dopytać o stylizacje?', 'Tak. Po zakupach zostajemy w kontakcie, żeby omówić całość i odpowiedzieć na Twoje pytania.'),
    ],
    'przeglad-szafy-zakupy' => [
        $q('Ile kosztuje pakiet?', '2800 zł za przegląd szafy i zakupy ze stylistą. Osobno te usługi kosztują 1400 zł i 1800 zł.'),
        $q('Dlaczego najpierw przegląd, a potem zakupy?', 'Bo najpierw trzeba wiedzieć, co już masz. Po przeglądzie kupujesz tylko to, co domyka garderobę, zamiast kolejnych przypadkowych rzeczy.'),
        $q('Co dostanę w pakiecie?', 'Uporządkowaną szafę, gotowe zestawy z Twoich ubrań, listę braków i wspólne zakupy, na których te braki uzupełniamy.'),
        $q('Ile trwają zakupy w pakiecie?', 'Tak jak w osobnej usłudze: bez limitu godzin i liczby sklepów.'),
        $q('Dla kogo jest pakiet?', 'Dla mężczyzn, którzy chcą zmienić garderobę kompleksowo – uporządkować to, co mają, i od razu dokupić to, czego brakuje.'),
        $q('Czy pakiet można kupić jako prezent?', 'Tak, na stronie voucherów. Voucher przychodzi jako PDF na e-mail od razu po zakupie.'),
    ],
    'stylizacja-okazjonalna' => [
        $q('Ile kosztuje stylizacja okazjonalna?', '600 zł.'),
        $q('Co dokładnie dostanę?', 'Trzy propozycje kompletnych stylizacji dopasowanych do okazji, w pliku PDF z linkami do konkretnych rzeczy i dokładnym opisem.'),
        $q('Czy muszę się z Tobą spotkać?', 'Nie. Rozmawiamy o okazji i Twoich oczekiwaniach, a gotowe stylizacje dostajesz w pliku PDF.'),
        $q('Na jakie okazje przygotowujesz stylizacje?', 'Na każde ważne wydarzenie: ślub, wesele, rozmowę o pracę, galę czy sesję zdjęciową.'),
        $q('Co, jeśli żadna propozycja mi nie odpowiada?', 'Wspólnie omawiamy wybór i w razie potrzeby nanoszę poprawki.'),
    ],
];

$faqBlock = fn (array $items) => parse_blocks(mig_block('service-faq', [
    'faq_label' => 'Najczęściej zadawane pytania',
    'faq_description' => '',
    'faq_items' => $items,
]))[0];

$gap = ['blockName' => null, 'attrs' => [], 'innerBlocks' => [], 'innerHTML' => "\n\n", 'innerContent' => ["\n\n"]];

$save = function (WP_Post $post, array $blocks, string $what) use ($dry) {
    $content = serialize_blocks($blocks);
    if ($content === $post->post_content) {
        WP_CLI::log("{$post->post_name}: bez zmian");
        return;
    }
    WP_CLI::log("{$post->post_name}: {$what}");
    if ($dry) {
        return;
    }
    $dir = dirname(ABSPATH, 2) . '/sql/backup';
    wp_mkdir_p($dir);
    file_put_contents("{$dir}/post-{$post->ID}-{$post->post_name}-" . date('Ymd-His') . '.html', $post->post_content);
    // wp_slash — inaczej wp_update_post zje backslashe z JSON-a bloków
    wp_update_post(wp_slash(['ID' => $post->ID, 'post_content' => $content]));
};

// --- Usługi: podmiana całego FAQ albo nowy blok na końcu treści ---
foreach ($faqs as $slug => $items) {
    $post = get_page_by_path($slug, OBJECT, 'service');
    if (! $post) {
        WP_CLI::warning("Brak usługi {$slug}");
        continue;
    }
    $blocks = parse_blocks($post->post_content);
    $at = array_search('acf/service-faq', array_column($blocks, 'blockName'), true);
    if ($at === false) {
        array_push($blocks, $gap, $faqBlock($items));
        $what = 'nowy blok FAQ (' . count($items) . ' pyt.) na końcu';
    } else {
        $blocks[$at] = $faqBlock($items);
        $what = 'FAQ podmienione (' . count($items) . ' pyt.)';
    }
    $save($post, $blocks, $what);
}

// --- /konsultacje/ ---
$page = get_page_by_path('konsultacje');
if (! $page) {
    WP_CLI::error('Brak strony /konsultacje/');
}
$blocks = parse_blocks($page->post_content);

foreach ($blocks as &$block) {
    if ($block['blockName'] === 'acf/page-header') {
        $block['attrs']['data']['page_header_description'] = 'Nie wiesz, która usługa będzie dla Ciebie najlepsza? Umów bezpłatną konsultację.';
    }
}
unset($block);

if (! in_array('acf/text-columns', array_column($blocks, 'blockName'), true)) {
    $new = [];
    $new[] = mig_block('text-columns', [
        'textcol_heading' => 'Dla kogo jest bezpłatna konsultacja?',
        'textcol_body' => "Dla każdego, kto chce coś zmienić w swoim wyglądzie, ale nie wie, od czego zacząć. Najczęściej zgłaszają się do mnie mężczyźni, którzy:\n\n"
            . '<ul><li>mają pełną szafę, a i tak codziennie zakładają to samo;</li>'
            . '<li>zmienili pracę, awansowali albo zaczęli częściej występować publicznie;</li>'
            . '<li>schudli lub przytyli i dotychczasowe ubrania przestały pasować;</li>'
            . '<li>chcą kupić prezent dla partnera, brata czy taty i szukają vouchera, który ma sens.</li></ul>',
    ]);
    $new[] = mig_block('text-columns', [
        'textcol_heading' => 'Czego dowiesz się na konsultacji?',
        'textcol_body' => "Rozmawiamy o Twoim stylu, pracy, trybie życia i budżecie. Na tej podstawie podpowiem, która usługa da Ci najwięcej:\n\n"
            . '<ul><li>' . mig_link('/uslugi/przeglad-szafy/', 'Przegląd szafy') . ' (1400 zł) – jeśli masz dużo ubrań, ale brakuje Ci gotowych zestawów;</li>'
            . '<li>' . mig_link('/uslugi/zakupy-ze-stylista/', 'Zakupy ze stylistą') . ' (1800 zł) – jeśli chcesz uzupełnić garderobę i kupić rzeczy, które naprawdę na Tobie leżą;</li>'
            . '<li>' . mig_link('/uslugi/przeglad-szafy-zakupy/', 'Pakiet: przegląd szafy + zakupy') . ' (2800 zł) – jeśli chcesz zmienić wszystko od A do Z;</li>'
            . '<li>' . mig_link('/uslugi/zakupy-online/', 'Zakupy online') . ' (1400 zł) – jeśli mieszkasz poza Krakowem, Warszawą, Poznaniem, Wrocławiem i Kielcami albo wolisz wybierać z domu;</li>'
            . '<li>' . mig_link('/uslugi/stylizacja-okazjonalna/', 'Stylizacja okazjonalna') . ' (600 zł) – jeśli potrzebujesz stroju na jedno konkretne wydarzenie.</li></ul>'
            . "\n\nKonsultacja jest bezpłatna i do niczego nie zobowiązuje. Jeśli uznasz, że żadna usługa nie jest Ci teraz potrzebna – też w porządku.",
    ]);
    $new[] = mig_block('text-columns', [
        'textcol_heading' => 'Jak się przygotować?',
        'textcol_body' => 'Nie musisz niczego przygotowywać. Warto tylko zastanowić się, co najbardziej przeszkadza Ci w obecnej garderobie i na jakie sytuacje potrzebujesz ubrań. Jeśli masz zdjęcia stylizacji, które Ci się podobają, możesz je pokazać – to przyspiesza rozmowę.',
    ]);
    $new[] = mig_block('service-faq', [
        'faq_label' => 'Najczęściej zadawane pytania',
        'faq_items' => [
            $q('Ile kosztuje konsultacja?', 'Nic. Konsultacja jest bezpłatna i niezobowiązująca.'),
            $q('Jak umówić konsultację?', 'Wybierz wolny termin w kalendarzu online – bez zakładania konta. Potwierdzenie dostaniesz SMS-em lub mailem.'),
            $q('Ile czekam na odpowiedź?', 'Na wiadomości z formularza odpowiadam w ciągu 24 godzin.'),
            $q('Czy po konsultacji muszę skorzystać z usługi?', 'Nie. Płacisz dopiero wtedy, gdy zdecydujesz się na konkretną usługę.'),
        ],
    ]);

    $insert = [];
    foreach ($new as $html) {
        $insert[] = $gap;
        $insert[] = parse_blocks($html)[0];
    }
    $after = array_search('acf/consultation-process', array_column($blocks, 'blockName'), true);
    if ($after === false) {
        WP_CLI::error('Brak bloku acf/consultation-process na /konsultacje/');
    }
    array_splice($blocks, $after + 1, 0, $insert);
}

$save($page, $blocks, 'nagłówek + 3 sekcje + FAQ');

WP_CLI::success($dry ? 'dry — nic nie zapisano' : 'gotowe');
