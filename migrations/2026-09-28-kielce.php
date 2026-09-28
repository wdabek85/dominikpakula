<?php
/**
 * Podstrona usługi: Zakupy ze stylistą → Kielce (wireframe v1, 28.09.2026).
 * Układ jak pozostałe miasta (bez sekcji ceny — cena w sidebarze; „Poznajmy się” = service-video).
 * Idempotentny.
 *
 * Uruchom: wp eval-file migrations/2026-09-28-kielce.php
 */

require_once __DIR__ . '/lib/city.php';

$blocks = [];

// Jak przebiegają zakupy
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Proces Współpracy',
    'stext_heading' => 'Jak przebiegają zakupy ze stylistą?',
    'stext_body' => '<p>Przed każdymi zakupami spotykamy się, żeby przygotować plan dopasowany do Ciebie. W sklepach korzystamy z tych ustaleń i sprawdzamy, które propozycje najlepiej Ci odpowiadają.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-process', [
    'process_description' => 'Zakupy odbywają się bez limitu czasu i liczby sklepów. Mamy czas na przymiarki, porównanie możliwości i decyzje, z którymi czujesz się dobrze.',
    'process_steps' => [
        [
            'process_step_title' => 'Spotykamy się przed zakupami',
            'process_step_description' => 'Chcę wiedzieć, jak się ubierasz, co lubisz i czego brakuje Ci w garderobie. Rozmawiamy o budżecie i sytuacjach, na które potrzebujesz ubrań. Wyjaśniam też, jak przygotować się do zakupów, omawiam ich organizację i odpowiadam na pytania.',
        ],
        [
            'process_step_title' => 'Przymierzamy konkretne propozycje',
            'process_step_description' => 'Pomagam znaleźć odpowiednie ubrania i porównujemy je na Twojej sylwetce. Sprawdzamy długości, proporcje i swobodę ruchu. Pokazuję, co zmienia inny krój lub rozmiar, a Ty oceniasz wygodę i to, czy dany fason Ci się podoba.',
        ],
        [
            'process_step_title' => 'Sprawdzamy, z czym to nosić',
            'process_step_description' => 'Łączymy wybrane rzeczy w całe stroje. Pokazuję Ci, jak zmiana butów, koszuli czy okrycia wpływa na charakter zestawu. Dzięki temu przed zakupem widzisz, jak wykorzystasz nowe ubrania.',
        ],
    ],
]);

// Gdzie na zakupy
$blocks[] = mig_block('service-text', [
    'stext_heading' => 'Gdzie zrobimy zakupy w Kielcach?',
    'stext_body' => '<p>Najpierw ustalamy, jakich ubrań szukasz i ile chcesz na nie przeznaczyć. Na tej podstawie dobieram sklepy: inne propozycje sprawdzimy przy kompletowaniu ubrań do pracy, a inne przy szukaniu wygodnych zestawów na wolny czas.</p>'
        . '<p>W Kielcach możemy rozważyć Galerię Echo przy ul. Świętokrzyskiej 20 lub Galerię Korona Kielce przy ul. Warszawskiej 26. Wybierzemy miejsce z ofertą sklepów odpowiednią dla Ciebie. Lokalizację uzgodnimy podczas spotkania przed zakupami.</p>',
]);

// W czym mogę pomóc (5 punktów: 3 + 2 „szczególnie”, jak w innych miastach)
$blocks[] = mig_block('service-desc-alt', [
    'descb_label' => 'Dla kogo',
    'descb_heading' => 'W czym mogę Ci pomóc?',
    'descb_positive_title' => 'Wspólne zakupy sprawdzą się, gdy:',
    'descb_positive_items' => [
        ['item_text' => 'chcesz lepiej wyglądać na co dzień i potrzebujesz pomocy w wyborze ubrań;'],
        ['item_text' => 'masz trudność z dobraniem kroju lub rozmiaru do swojej sylwetki;'],
        ['item_text' => 'w sklepach brakuje Ci pomysłów i chcesz przymierzyć propozycje wybrane dla Ciebie.'],
    ],
    'descb_highlight_title' => 'Szczególnie, gdy:',
    'descb_highlight_items' => [
        ['item_text' => 'po zakupach okazuje się, że nowe rzeczy trudno połączyć z resztą garderoby;'],
        ['item_text' => 'zmieniła się Twoja praca, sylwetka albo sposób spędzania czasu.'],
    ],
    'descb_negative_title' => 'Szukasz innej formy współpracy?',
    'descb_negative_items' => [
        ['item_text' => 'Pojedyncze ważne wydarzenie — wybierz ' . mig_link('/uslugi/stylizacja-okazjonalna/', 'stylizację okazjonalną')],
        ['item_text' => 'Wolisz przymierzać ubrania w domu — sprawdź ' . mig_link('/uslugi/zakupy-online/', 'zakupy online ze stylistą')],
    ],
]);

// Co ułatwi współpraca
$blocks[] = mig_block('service-text', [
    'stext_label' => 'Dlaczego Warto',
    'stext_heading' => 'Co ułatwi Ci współpraca z osobistym stylistą?',
    'stext_body' => '<p>Przymiarki to okazja, żeby dowiedzieć się, co Ci służy i dlaczego. Na konkretnych ubraniach pokazuję zasady, z których możesz korzystać także przy samodzielnych zakupach.</p>',
    'stext_attached' => 1,
]);
$blocks[] = mig_block('service-what', [
    'what_items' => [
        ['what_item_title' => 'Konkretny wybór ubrań.', 'what_item_description' => 'Wybieram rzeczy zgodne z Twoimi potrzebami i pomagam ocenić różnice między nimi. Łatwiej zdecydować, co kupić, gdy masz przed sobą przemyślane propozycje.'],
        ['what_item_title' => 'Dopasowanie, które potrafisz ocenić.', 'what_item_description' => 'Pokazuję, gdzie ubranie powinno przylegać, a gdzie potrzebujesz swobody. Uczysz się zauważać szczegóły, które decydują o tym, jak leżą spodnie, koszula czy marynarka.'],
        ['what_item_title' => 'Ubrania zgodne z Twoim gustem.', 'what_item_description' => 'Twoje upodobania pomagają mi dobrać propozycje. Podczas przymiarek możesz sprawdzić nowe możliwości, a ostatecznie wybrać to, co podoba Ci się i jest wygodne.'],
        ['what_item_title' => 'Świadomy wybór materiałów.', 'what_item_description' => 'Czytamy metki i oglądamy wykończenie. Wyjaśniam, co skład tkaniny oznacza dla komfortu oraz pielęgnacji i kiedy dany materiał będzie dobrym wyborem.'],
        ['what_item_title' => 'Priorytety dopasowane do budżetu.', 'what_item_description' => 'Zaczynamy od rzeczy, których najbardziej potrzebujesz. Przy wyborze uwzględniamy cenę i to, jak często oraz z czym będziesz nosić dane ubranie.'],
        ['what_item_title' => '14 dni wsparcia e-mailowego.', 'what_item_description' => 'W cenie usługi otrzymujesz również wsparcie e-mailowe przez 14 dni.'],
    ],
]);

// Poznaj mnie — ten sam blok co na innych usługach
$blocks[] = '<!-- wp:acf/service-video {"name":"acf/service-video","mode":"preview"} /-->';

// CTA rezerwacji
$blocks[] = mig_block('service-cta', [
    'scta_eyebrow' => 'Twój pierwszy krok',
    'scta_heading' => 'Porozmawiajmy o zakupach w Kielcach',
    'scta_text' => 'Powiedz mi, z czym masz trudność przy wybieraniu ubrań i czego oczekujesz od wspólnych zakupów. Opowiem Ci o współpracy i odpowiem na pytania. Po bezpłatnej rozmowie zdecydujesz, czy chcesz umówić zakupy.',
    'scta_button_text' => 'Umów bezpłatną rozmowę',
    'scta_secondary_text' => 'Kup voucher',
    'scta_secondary_url' => home_url('/voucher/'),
]);

mig_city_page([
    'slug' => 'kielce',
    'title' => 'Zakupy ze stylistą Kielce',
    'order' => 40,
    'sidebar_title' => 'Zakupy ze stylistą w Kielcach',
    'sidebar_description' => 'Pomogę Ci znaleźć ubrania, które dobrze leżą, pasują do siebie i sprawdzają się w Twojej codzienności. Zaczniemy od spotkania, na którym poznam Twoje potrzeby i budżet. Potem wspólnie wybierzemy fasony, porównamy rozmiary i sprawdzimy gotowe połączenia podczas przymiarek.',
    'hero_caption' => "Wybieraj z pewnością.\nUbieraj się po swojemu.",
    'included_heading' => 'W ramach współpracy',
    'included' => [
        'Spotkanie przed zakupami: potrzeby, budżet i plan działania.',
        'Indywidualny dobór sklepów i propozycji ubrań.',
        'Wspólne zakupy bez limitu czasu i liczby sklepów.',
        'Dobór fasonów, rozmiarów i materiałów oraz układanie zestawów.',
        'Wsparcie e-mailowe przez 14 dni.',
    ],
    'rank_title' => 'Zakupy ze stylistą Kielce | Dominik Pakuła',
    'rank_description' => 'Zakupy ze stylistą w Kielcach. Wybierz ze mną ubrania dopasowane do sylwetki, stylu życia i budżetu. Cena 1 800 zł. Umów bezpłatną rozmowę.',
    'rank_keywords' => 'zakupy ze stylistą Kielce,zakupy ze stylistą w Kielcach,personal shopper Kielce,stylista Kielce',
    // Brak zdjęcia Kielc — tymczasowo zdjęcie usługi-rodzica. Po dodaniu pliku do migrations/assets:
    // 'image' => 'zakupy-ze-stylista-kielce.webp', 'image_alt' => '…',
], $blocks);
