<?php

/**
 * ACF Blocks registration.
 *
 * Każdy blok należy do jednej grupy (`group`). Grupa decyduje o:
 * - kategorii w wyszukiwarce bloków Gutenberga,
 * - typach treści, w których blok jest w ogóle dostępny (`post_types`).
 *
 * Pusta lista `post_types` = blok dostępny wszędzie. Ograniczenie dotyczy TYLKO
 * wstawiania nowych bloków — treść, która już gdzieś istnieje, renderuje się dalej.
 * Pojedynczy blok może nadpisać `post_types` grupy własnym kluczem.
 */

namespace App;

use function Roots\view;

/**
 * Grupy bloków: kategoria w edytorze + dostępność per typ treści.
 */
function block_groups(): array
{
    return [
        'article' => [
            'category' => 'theme-article',
            'title' => 'Wpis blogowy — wstawki w treść',
            'post_types' => [],
        ],
        'blog' => [
            'category' => 'theme-blog',
            'title' => 'Blog i poradniki — sekcje',
            'post_types' => ['page'],
        ],
        'service' => [
            'category' => 'theme-service',
            'title' => 'Podstrona usługi',
            'post_types' => ['page', 'service'],
        ],
        'section' => [
            'category' => 'theme-section',
            'title' => 'Sekcje stron',
            'post_types' => ['page', 'service'],
        ],
        'contact' => [
            'category' => 'theme-contact',
            'title' => 'Kontakt i newsletter',
            'post_types' => [],
        ],
    ];
}

/**
 * Kolejność kategorii w wyszukiwarce bloków, zależna od edytowanego typu treści.
 * Najbardziej przydatna kategoria ląduje na górze listy.
 */
function block_category_order(string $postType): array
{
    return match ($postType) {
        'post', 'guide' => ['article', 'contact', 'blog', 'section', 'service'],
        'service' => ['service', 'section', 'contact', 'article', 'blog'],
        default => ['section', 'blog', 'contact', 'service', 'article'],
    };
}

add_action('acf/init', function () {
    if (! function_exists('acf_register_block_type')) {
        return;
    }

    $groups = block_groups();

    $blocks = [
        [
            'name' => 'hero',
            'title' => 'Hero',
            'description' => 'Sekcja hero z tłem, nagłówkiem, opisem i CTA',
            'icon' => 'cover-image',
            'group' => 'section',
            'render_template' => 'blocks.hero',
        ],
        [
            'name' => 'video',
            'title' => 'Video',
            'description' => 'Sekcja wideo z YouTube embed i opisem',
            'icon' => 'video-alt3',
            'group' => 'section',
            'render_template' => 'blocks.video',
        ],
        [
            'name' => 'services',
            'title' => 'Usługi',
            'description' => 'Sekcja z kartami usług i zdjęciem wyróżniającym',
            'icon' => 'grid-view',
            'group' => 'section',
            'render_template' => 'blocks.services.index',
        ],
        [
            'name' => 'offer',
            'title' => 'Pełna Oferta',
            'description' => 'Siatka kart z pełną ofertą usług i cenami',
            'icon' => 'screenoptions',
            'group' => 'section',
            'render_template' => 'blocks.offer.index',
        ],
        [
            'name' => 'process',
            'title' => 'Proces Współpracy',
            'description' => 'Sekcja z krokami procesu współpracy',
            'icon' => 'editor-ol',
            'group' => 'section',
            'render_template' => 'blocks.process.index',
        ],
        [
            'name' => 'testimonials',
            'title' => 'Opinie',
            'description' => 'Slider z opiniami klientów (zdjęcia i wideo)',
            'icon' => 'format-quote',
            'group' => 'section',
            'render_template' => 'blocks.testimonials.index',
        ],
        [
            'name' => 'portfolio',
            'title' => 'Portfolio',
            'description' => 'Slider z realizacjami portfolio',
            'icon' => 'portfolio',
            'group' => 'section',
            'render_template' => 'blocks.portfolio.index',
        ],
        [
            'name' => 'voucher',
            'title' => 'Voucher',
            'description' => 'Sekcja CTA z voucherem prezentowym',
            'icon' => 'tickets-alt',
            'group' => 'section',
            'render_template' => 'blocks.voucher',
        ],
        [
            'name' => 'blog',
            'title' => 'Blog — 3 najnowsze wpisy',
            'description' => 'Sekcja z 3 najnowszymi wpisami blogowymi',
            'icon' => 'admin-post',
            'group' => 'blog',
            'render_template' => 'blocks.blog',
        ],
        [
            'name' => 'newsletter',
            'title' => 'Newsletter',
            'description' => 'Sekcja zapisu do newslettera z formularzem',
            'icon' => 'email',
            'group' => 'contact',
            'render_template' => 'blocks.newsletter',
        ],
        [
            'name' => 'contact',
            'title' => 'Kontakt',
            'description' => 'Sekcja kontaktowa z formularzem i danymi',
            'icon' => 'phone',
            'group' => 'contact',
            'render_template' => 'blocks.contact',
        ],
        [
            'name' => 'service-desc',
            'title' => 'Opis Usługi / Dla Kogo',
            'description' => 'Blok opisu usługi z etykietą i treścią WYSIWYG',
            'icon' => 'text-page',
            'group' => 'service',
            'render_template' => 'blocks.service-desc',
        ],
        [
            'name' => 'service-what',
            'title' => 'Opis Usługi / Co Dostaniesz',
            'description' => 'Blok z listą elementów oferty i ikonkami',
            'icon' => 'yes-alt',
            'group' => 'service',
            'render_template' => 'blocks.service-what',
        ],
        [
            'name' => 'knowledge-base',
            'title' => 'Baza Wiedzy',
            'description' => 'Najnowszy wpis blogowy + lista poradników',
            'icon' => 'book',
            'group' => 'blog',
            'render_template' => 'blocks.knowledge-base',
        ],
        [
            'name' => 'page-header',
            'title' => 'Nagłówek Podstrony',
            'description' => 'Breadcrumb + duży tytuł + opis (kontakt, blog)',
            'icon' => 'heading',
            'group' => 'section',
            'render_template' => 'blocks.page-header',
        ],
        [
            'name' => 'features',
            'title' => 'Dlaczego Warto / Voucher',
            'description' => 'Sekcja z nagłówkiem i kartami (ikona + tytuł + opis)',
            'icon' => 'columns',
            'group' => 'section',
            'render_template' => 'blocks.features',
        ],
        [
            'name' => 'subpage-hero',
            'title' => 'Hero Podstrona',
            'description' => 'Hero sekcja dla podstron z tytułem i dwoma zdjęciami',
            'icon' => 'cover-image',
            'group' => 'section',
            'render_template' => 'blocks.subpage-hero',
        ],
        [
            'name' => 'service-faq',
            'title' => 'Opis Usługi / FAQ',
            'description' => 'Accordion z najczęściej zadawanymi pytaniami',
            'icon' => 'editor-help',
            'group' => 'service',
            'render_template' => 'blocks.service-faq',
        ],
        [
            'name' => 'service-process',
            'title' => 'Opis Usługi / Proces Współpracy',
            'description' => 'Timeline z krokami procesu współpracy',
            'icon' => 'editor-ol',
            'group' => 'service',
            'render_template' => 'blocks.service-process',
        ],
        [
            'name' => 'service-why',
            'title' => 'Opis Usługi / Dlaczego Warto',
            'description' => 'Blok z benefitami, opisem i zdjęciem',
            'icon' => 'star-filled',
            'group' => 'service',
            'render_template' => 'blocks.service-why',
        ],
        [
            'name' => 'service-trust',
            'title' => 'Opis Usługi / Zaufanie i Doświadczenie',
            'description' => '2 karty side-by-side: lewa (społeczny dowód) + prawa (zdjęcie + doświadczenie)',
            'icon' => 'images-alt2',
            'group' => 'service',
            'render_template' => 'blocks.service-trust',
        ],
        [
            'name' => 'service-video',
            'title' => 'Opis Usługi / Video CTA',
            'description' => 'Zdjęcie + przycisk otwierający modal „Poznaj mnie” (treść globalna: Ustawienia → Sekcja: Poznaj mnie).',
            'icon' => 'video-alt3',
            'group' => 'service',
            'render_template' => 'blocks.service-video',
        ],
        [
            'name' => 'service-desc-alt',
            'title' => 'Dla kogo — wariant B (check-lista)',
            'description' => 'Alternatywa „Dla kogo”: dwie karty obok siebie — Tak (ptaszki) vs To nie to (iksy).',
            'icon' => 'yes-alt',
            'group' => 'service',
            'render_template' => 'blocks.service-desc-alt',
        ],
        [
            'name' => 'local-seo',
            'title' => 'Karty linkowe (SEO) — miasta / okazje',
            'description' => 'Siatka kart z linkami (zdjęcie + tytuł + „Dowiedz się więcej”). Do podstron miast, okazji itp. Pod SEO.',
            'icon' => 'location-alt',
            'group' => 'section',
            'render_template' => 'blocks.local-seo',
        ],
        [
            'name' => 'brand-logos',
            'title' => 'Logotypy marek',
            'description' => 'Nagłówek + siatka logotypów marek (grayscale, kolor na hover). Repeater: logo + nazwa + link.',
            'icon' => 'awards',
            'group' => 'section',
            'render_template' => 'blocks.brand-logos',
        ],
        [
            'name' => 'manifest',
            'title' => 'Filozofia / Cytat',
            'description' => 'Duży cudzysłów + cytat + avatar/podpis po lewej, szerokie zdjęcie po prawej. Wg Figmy.',
            'icon' => 'format-quote',
            'group' => 'section',
            'post_types' => [],
            'render_template' => 'blocks.manifest',
        ],
        [
            'name' => 'text-columns',
            'title' => 'Tekst 2 kolumny (nagłówek + treść)',
            'description' => 'Nagłówek po lewej + akapity po prawej. Editorial, reużywalny.',
            'icon' => 'columns',
            'group' => 'section',
            'post_types' => [],
            'render_template' => 'blocks.text-columns',
        ],
        [
            'name' => 'blog-archive',
            'title' => 'Blog – Archiwum z filtrami',
            'description' => 'Pasek filtrów (kategorie + sezon) + grid wszystkich wpisów + paginacja',
            'icon' => 'list-view',
            'group' => 'blog',
            'render_template' => 'blocks.blog-archive',
        ],
        [
            'name' => 'guides-archive',
            'title' => 'Poradniki – Archiwum',
            'description' => 'Grid wszystkich poradników + paginacja (pusty stan z zachętą do newslettera)',
            'icon' => 'book-alt',
            'group' => 'blog',
            'render_template' => 'blocks.guides-archive',
        ],
        [
            'name' => 'subscribe',
            'title' => 'Newsletter + Instagram',
            'description' => 'Dwie karty obok siebie: zapis na newsletter + zachęta do śledzenia Instagrama',
            'icon' => 'megaphone',
            'group' => 'contact',
            'render_template' => 'blocks.subscribe',
        ],
        [
            'name' => 'contact-bar',
            'title' => 'Pasek kontaktowy',
            'description' => 'Adres + dane formalne (NIP) + telefon + email w 3 kolumnach (np. pod headerem strony Kontakt)',
            'icon' => 'id-alt',
            'group' => 'contact',
            'render_template' => 'blocks.contact-bar',
        ],
        [
            'name' => 'personal-intro',
            'title' => 'Personal Intro',
            'description' => 'Zdjęcie + krótki tekst od Dominika (humanizacja, obniżenie bariery kontaktu)',
            'icon' => 'admin-users',
            'group' => 'section',
            'render_template' => 'blocks.personal-intro',
        ],
        [
            'name' => 'contact-channels',
            'title' => 'Kanały kontaktu',
            'description' => '4 kafelki: Zadzwoń / WhatsApp / Instagram DM / Email — instant CTA bez formularza',
            'icon' => 'phone',
            'group' => 'contact',
            'render_template' => 'blocks.contact-channels',
        ],
        [
            'name' => 'next-steps',
            'title' => 'Co dalej? (3 kroki)',
            'description' => 'Timeline 3 kroków: co się stanie po kontakcie. Set expectations dla użytkownika.',
            'icon' => 'list-view',
            'group' => 'contact',
            'render_template' => 'blocks.next-steps',
        ],
        [
            'name' => 'consultation-process',
            'title' => 'Konsultacja / Jak to działa',
            'description' => 'Schodkowe 4 kroki procesu konsultacji + CTA otwierające modal rezerwacji. Dedykowana podstrona /konsultacje/.',
            'icon' => 'editor-ol',
            'group' => 'section',
            'render_template' => 'blocks.consultation-process',
        ],
        [
            'name' => 'lookbook-section',
            'title' => 'Lookbook — sekcja produktowa',
            'description' => 'Heading + opis + galeria zdjęć z brandami i linkami do sklepu. 3 layouty (grid-3 / grid-4 / split z modelem).',
            'icon' => 'screenoptions',
            'group' => 'article',
            'render_template' => 'blocks.lookbook-section',
        ],
        [
            'name' => 'blog-text-image',
            'title' => 'Tekst + zdjęcie (2 kolumny)',
            'description' => 'Nagłówek na całą szerokość (wpada do spisu treści) + tekst i zdjęcie obok siebie. Zdjęcie do wyboru po lewej lub prawej.',
            'icon' => 'align-pull-right',
            'group' => 'article',
            'render_template' => 'blocks.blog-text-image',
        ],
        [
            'name' => 'blog-product-grid',
            'title' => 'Siatka produktów (3 kolumny)',
            'description' => 'Nagłówek + wstęp + dowolna liczba zdjęć produktów z repeatera. Desktop zawsze 3 kolumny. Opcjonalny link do sklepu na kafelce.',
            'icon' => 'grid-view',
            'group' => 'article',
            'render_template' => 'blocks.blog-product-grid',
        ],
        [
            'name' => 'blog-pullquote',
            'title' => 'Pull quote (wyróżniona myśl)',
            'description' => 'Duża wyróżniona myśl z cudzysłowem — do akcentowania kluczowych wniosków w artykule.',
            'icon' => 'format-quote',
            'group' => 'article',
            'render_template' => 'blocks.blog-pullquote',
        ],
        [
            'name' => 'blog-callout',
            'title' => 'Callout (Pro tip / info / warning)',
            'description' => 'Boxed wstawka z ikoną i krótkim akcentowanym tekstem (3 warianty: tip / info / warning).',
            'icon' => 'lightbulb',
            'group' => 'article',
            'render_template' => 'blocks.blog-callout',
        ],
        [
            'name' => 'blog-personal-quote',
            'title' => 'Cytat osobisty (Dominik z foto)',
            'description' => 'Cytat od Dominika z jego foto i rolą — buduje personal brand wewnątrz artykułu.',
            'icon' => 'businessperson',
            'group' => 'article',
            'render_template' => 'blocks.blog-personal-quote',
        ],
    ];

    foreach ($blocks as $block) {
        $template = $block['render_template'];
        $group = $groups[$block['group']] ?? $groups['section'];
        $postTypes = $block['post_types'] ?? $group['post_types'];

        unset($block['render_template'], $block['group'], $block['post_types']);

        $args = array_merge($block, [
            'category' => $group['category'],
            'mode' => 'preview',
            'supports' => [
                'align' => false,
                'anchor' => true,
            ],
            'render_callback' => function ($block) use ($template) {
                echo view($template, ['block' => $block])->render();
            },
        ]);

        if ($postTypes) {
            $args['post_types'] = $postTypes;
        }

        acf_register_block_type($args);
    }
});

add_filter('block_categories_all', function ($categories, $context) {
    $groups = block_groups();
    $postType = $context->post->post_type ?? '';

    $themeCategories = [];

    foreach (block_category_order($postType) as $key) {
        if (! isset($groups[$key])) {
            continue;
        }

        $themeCategories[] = [
            'slug' => $groups[$key]['category'],
            'title' => $groups[$key]['title'],
        ];
    }

    return array_merge($themeCategories, $categories);
}, 10, 2);
