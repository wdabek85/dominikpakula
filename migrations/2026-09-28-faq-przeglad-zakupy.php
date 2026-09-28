<?php
/**
 * FAQ na stronie „Przegląd szafy + zakupy” — zamiast zaślepki z szablonu agencji
 * („realizacja projektu”, „wsparcie techniczne po wdrożeniu”).
 * Odpowiedzi wyłącznie z faktów, które już są na stronach: proces usługi, cena, sidebar,
 * opis przeglądu szafy. Bez nowych obietnic (czas trwania, dojazdy itp.).
 * Idempotentny, robi backup treści przed zmianą.
 *
 * Uruchom: wp eval-file migrations/2026-09-28-faq-przeglad-zakupy.php
 */

require_once __DIR__ . '/lib/blocks.php';

$post = get_page_by_path('przeglad-szafy-zakupy', OBJECT, 'service');
if (! $post) {
    WP_CLI::error('Brak usługi przeglad-szafy-zakupy.');
}

$faq = mig_block('service-faq', [
    'faq_label' => 'Najczęściej Zadawane Pytania',
    'faq_description' => 'Odpowiedzi na pytania, które najczęściej słyszę przed pakietem przegląd szafy + zakupy.',
    'faq_items' => [
        [
            'faq_question' => 'Czym ten pakiet różni się od osobnego przeglądu szafy i zakupów ze stylistą?',
            'faq_answer' => 'Łączy obie usługi w jeden proces: najpierw przegląd szafy, potem zakupy, które uzupełniają to, czego faktycznie brakuje. Dzięki temu nie kupujesz w ciemno. Osobno przegląd szafy (1400 zł) i zakupy ze stylistą (1800 zł) kosztują razem 3200 zł — pakiet kosztuje 2800 zł.',
        ],
        [
            'faq_question' => 'Jak wygląda przegląd szafy?',
            'faq_answer' => 'Spotykamy się u Ciebie. Oglądamy i przymierzamy ubrania, a potem dzielimy je na trzy grupy: zostaje, do przeróbki lub naprawy, do oddania. Z rzeczy, które zostają, układamy gotowe zestawy i spisujemy listę braków.',
        ],
        [
            'faq_question' => 'Zakupy robimy w sklepach czy online?',
            'faq_answer' => 'Stacjonarnie lub online — wybieramy formę, która Ci odpowiada. Szukamy rzeczy z listy braków: przymierzamy, porównujemy i wybieramy tylko to, co pasuje do Ciebie i do reszty garderoby.',
        ],
        [
            'faq_question' => 'Co dostaję na koniec?',
            'faq_answer' => 'Uporządkowaną szafę i gotowe zestawy — z rzeczy, które już miałeś, i z tych, które kupiliśmy. Do tego podsumowanie: jak łączyć ubrania i na co zwracać uwagę przy kolejnych zakupach. Przez 14 dni możesz też pisać do mnie mailowo.',
        ],
        [
            'faq_question' => 'Ile to kosztuje i kiedy płacę?',
            'faq_answer' => 'Pakiet kosztuje 2800 zł. Pierwsza rozmowa jest bezpłatna — płacisz dopiero wtedy, gdy po konsultacji zdecydujesz się na współpracę. Obowiązuje 30-dniowa gwarancja zwrotu pieniędzy.',
        ],
        [
            'faq_question' => 'Czy mogę podarować ten pakiet w prezencie?',
            'faq_answer' => 'Tak. Na stronie Voucher kupisz voucher na przegląd szafy + zakupy.',
        ],
    ],
]);

$newFaq = parse_blocks($faq)[0];
$blocks = parse_blocks($post->post_content);
$found = false;

foreach ($blocks as &$block) {
    if ($block['blockName'] === 'acf/service-faq') {
        $found = true;
        if (($block['attrs']['data'] ?? []) == $newFaq['attrs']['data']) {
            WP_CLI::success('FAQ już aktualne — bez zmian.');
            return;
        }
        $block['attrs']['data'] = $newFaq['attrs']['data'];
    }
}
unset($block);

if (! $found) {
    WP_CLI::error('Na stronie nie ma bloku FAQ (acf/service-faq).');
}

$dir = dirname(ABSPATH, 2) . '/sql/backup';
wp_mkdir_p($dir);
file_put_contents("{$dir}/post-{$post->ID}-przeglad-szafy-zakupy-" . date('Ymd-His') . '.html', $post->post_content);

wp_update_post(wp_slash(['ID' => $post->ID, 'post_content' => serialize_blocks($blocks)]));
WP_CLI::success("FAQ zaktualizowane (ID {$post->ID}).");
