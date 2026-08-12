<?php

/**
 * Google Tag Manager — kontener + kontekst strony w dataLayer.
 *
 * Świadomie BEZ wtyczki GTM4WP: jej wartość to automatyczny dataLayer dla
 * WooCommerce / Contact Form 7 / Gravity Forms — a tu wszystkie konwersje
 * (rezerwacja, voucher, kontakt, newsletter) to własny kod REST, o którym
 * GTM4WP i tak nic nie wie. Zostałby sam snippet kontenera, czyli to co niżej,
 * plus ekran ustawień klikany ręcznie w adminie (poza gitem) i kolejna wtyczka
 * do utrzymania. Zdarzenia wypycha `resources/js/lib/analytics.js`.
 *
 * Config — stała definiowana w config/application.php z .env:
 *   GTM_CONTAINER_ID — ID kontenera w formacie GTM-XXXXXXX (wymagane)
 *
 * Uśpione dopóki GTM_CONTAINER_ID jest puste — bezpieczne do wdrożenia z góry
 * i zarazem wyłącznik awaryjny. Każde środowisko ma własną wartość w .env,
 * więc staging może mieć inny kontener albo żadnego.
 *
 * ZGODY: Consent Mode ustawia Cookiebot wpięty jako tag WEWNĄTRZ kontenera GTM
 * (trigger „Consent Initialization – All Pages"). Nie wypisujemy tu własnych
 * `gtag('consent', 'default', …)`, bo dwa źródła defaultów potrafią się nadpisać
 * i skończyć zgodą, której użytkownik nie dał. Jeśli kiedyś Cookiebot wjedzie
 * własnym <script> w <head> zamiast przez GTM, MUSI być wyżej niż ten snippet —
 * wtedy trzeba tu podbić priorytet hooka `wp_head` powyżej priorytetu Cookiebota.
 */

namespace App\Analytics;

/**
 * ID kontenera, o ile jest ustawione i ma poprawny format.
 *
 * Walidacja formatu nie jest paranoją — ID trafia wprost do stringa w <script>,
 * więc przepuszczamy wyłącznie znaki, które GTM faktycznie stosuje.
 */
function container_id(): string
{
    if (! defined('GTM_CONTAINER_ID')) {
        return '';
    }

    $id = trim((string) constant('GTM_CONTAINER_ID'));

    return preg_match('/^GTM-[A-Z0-9]{4,}$/', $id) ? $id : '';
}

/**
 * Czy kontener ma się załadować na tym żądaniu.
 *
 * Wynik zapamiętujemy, bo pytamy o niego dwa razy (head + body) i oba muszą
 * odpowiedzieć tak samo — inaczej zostałby osierocony <noscript> bez kontenera.
 */
function should_load(): bool
{
    static $decision = null;

    if ($decision !== null) {
        return $decision;
    }

    $decision = (function (): bool {
        if (container_id() === '') {
            return false;
        }

        if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
            return false;
        }

        if (defined('REST_REQUEST') && REST_REQUEST) {
            return false;
        }

        if (is_customize_preview() || is_preview()) {
            return false;
        }

        // Redakcja nie zaśmieca statystyk własnymi wejściami. Zalogowany
        // subskrybent (bez edit_posts) jest normalnym użytkownikiem — liczymy go.
        if (is_user_logged_in() && current_user_can('edit_posts')) {
            return false;
        }

        return true;
    })();

    return $decision;
}

/**
 * Kontekst strony wpychany do dataLayer przed startem kontenera.
 *
 * Dzięki temu w GTM można budować triggery i wymiary GA4 bez zgadywania po URL-u
 * (np. „tylko wpisy z kategorii X", „tylko strony usług").
 */
function page_context(): array
{
    $context = [
        'pageType' => page_type(),
        'postId' => 0,
        'postType' => '',
        'postTitle' => '',
        'postCategory' => '',
        'postAuthor' => '',
        'isLoggedIn' => is_user_logged_in(),
    ];

    if (! is_singular()) {
        return $context;
    }

    $post = get_queried_object();

    if (! $post instanceof \WP_Post) {
        return $context;
    }

    $context['postId'] = (int) $post->ID;
    $context['postType'] = (string) $post->post_type;
    $context['postTitle'] = wp_strip_all_tags(get_the_title($post));
    $context['postAuthor'] = (string) get_the_author_meta('display_name', (int) $post->post_author);

    $terms = get_the_terms($post, 'category');

    if (is_array($terms) && $terms) {
        $context['postCategory'] = implode(', ', wp_list_pluck($terms, 'name'));
    }

    return $context;
}

/**
 * Typ strony w wartościach maszynowych — stabilnych, niezależnych od tytułów.
 */
function page_type(): string
{
    if (is_front_page()) {
        return 'front_page';
    }

    if (is_home()) {
        return 'blog';
    }

    if (is_404()) {
        return 'not_found';
    }

    if (is_search()) {
        return 'search';
    }

    if (is_page()) {
        return 'page';
    }

    if (is_singular()) {
        return 'single';
    }

    if (is_archive()) {
        return 'archive';
    }

    return 'other';
}

/*
|--------------------------------------------------------------------------
| Snippet kontenera — jak najwyżej w <head>
|--------------------------------------------------------------------------
| Priorytet 1, żeby GTM startował przed resztą skryptów i zdążył odpalić tagi
| zanim użytkownik zdąży kliknąć. Kontekst strony leci PRZED snippetem —
| po starcie kontenera push do dataLayer nie zasili już zmiennych czytanych
| przy inicjalizacji tagów.
*/
add_action('wp_head', function () {
    if (! should_load()) {
        return;
    }

    $id = container_id();
    $context = wp_json_encode(page_context(), JSON_HEX_TAG | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    echo "\n<!-- Google Tag Manager -->\n";
    echo '<script>window.dataLayer = window.dataLayer || [];window.dataLayer.push(' . $context . ");</script>\n";
    echo "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n";
    echo "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n";
    echo "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n";
    echo "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n";
    echo "})(window,document,'script','dataLayer','" . esc_js($id) . "');</script>\n";
    echo "<!-- End Google Tag Manager -->\n";
}, 1);

/*
|--------------------------------------------------------------------------
| Fallback <noscript> — zaraz po otwarciu <body>
|--------------------------------------------------------------------------
| Wymagany przez Google i weryfikowany przez Tag Assistant. W layoucie
| wp_body_open() stoi w pierwszej linii <body> (layouts/app.blade.php), więc
| iframe ląduje dokładnie tam, gdzie ma.
*/
add_action('wp_body_open', function () {
    if (! should_load()) {
        return;
    }

    $src = 'https://www.googletagmanager.com/ns.html?id=' . rawurlencode(container_id());

    echo "\n<!-- Google Tag Manager (noscript) -->\n";
    echo '<noscript><iframe src="' . esc_url($src) . '"';
    echo ' height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>' . "\n";
    echo "<!-- End Google Tag Manager (noscript) -->\n";
}, 1);
