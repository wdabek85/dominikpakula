<?php

/**
 * ACF Blocks registration.
 */

namespace App;

use function Roots\view;

add_action('acf/init', function () {
    if (! function_exists('acf_register_block_type')) {
        return;
    }

    $blocks = [
        [
            'name' => 'hero',
            'title' => 'Hero',
            'description' => 'Sekcja hero z tłem, nagłówkiem, opisem i CTA',
            'icon' => 'cover-image',
            'render_template' => 'blocks.hero',
        ],
        [
            'name' => 'video',
            'title' => 'Video',
            'description' => 'Sekcja wideo z YouTube embed i opisem',
            'icon' => 'video-alt3',
            'render_template' => 'blocks.video',
        ],
        [
            'name' => 'services',
            'title' => 'Usługi',
            'description' => 'Sekcja z kartami usług i zdjęciem wyróżniającym',
            'icon' => 'grid-view',
            'render_template' => 'blocks.services.index',
        ],
        [
            'name' => 'offer',
            'title' => 'Pełna Oferta',
            'description' => 'Siatka kart z pełną ofertą usług i cenami',
            'icon' => 'screenoptions',
            'render_template' => 'blocks.offer.index',
        ],
        [
            'name' => 'process',
            'title' => 'Proces Współpracy',
            'description' => 'Sekcja z krokami procesu współpracy',
            'icon' => 'editor-ol',
            'render_template' => 'blocks.process.index',
        ],
        [
            'name' => 'testimonials',
            'title' => 'Opinie',
            'description' => 'Slider z opiniami klientów (zdjęcia i wideo)',
            'icon' => 'format-quote',
            'render_template' => 'blocks.testimonials.index',
        ],
        [
            'name' => 'portfolio',
            'title' => 'Portfolio',
            'description' => 'Slider z realizacjami portfolio',
            'icon' => 'portfolio',
            'render_template' => 'blocks.portfolio.index',
        ],
        [
            'name' => 'voucher',
            'title' => 'Voucher',
            'description' => 'Sekcja CTA z voucherem prezentowym',
            'icon' => 'tickets-alt',
            'render_template' => 'blocks.voucher',
        ],
        [
            'name' => 'blog',
            'title' => 'Blog',
            'description' => 'Sekcja z 3 najnowszymi wpisami blogowymi',
            'icon' => 'admin-post',
            'render_template' => 'blocks.blog',
        ],
        [
            'name' => 'newsletter',
            'title' => 'Newsletter',
            'description' => 'Sekcja zapisu do newslettera z formularzem',
            'icon' => 'email',
            'render_template' => 'blocks.newsletter',
        ],
        [
            'name' => 'contact',
            'title' => 'Kontakt',
            'description' => 'Sekcja kontaktowa z formularzem i danymi',
            'icon' => 'phone',
            'render_template' => 'blocks.contact',
        ],
        [
            'name' => 'service-desc',
            'title' => 'Opis Usługi / Dla Kogo',
            'description' => 'Blok opisu usługi z etykietą i treścią WYSIWYG',
            'icon' => 'text-page',
            'render_template' => 'blocks.service-desc',
        ],
        [
            'name' => 'service-what',
            'title' => 'Opis Usługi / Co Dostaniesz',
            'description' => 'Blok z listą elementów oferty i ikonkami',
            'icon' => 'yes-alt',
            'render_template' => 'blocks.service-what',
        ],
        [
            'name' => 'knowledge-base',
            'title' => 'Baza Wiedzy',
            'description' => 'Najnowszy wpis blogowy + lista poradników',
            'icon' => 'book',
            'render_template' => 'blocks.knowledge-base',
        ],
        [
            'name' => 'page-header',
            'title' => 'Nagłówek Podstrony',
            'description' => 'Breadcrumb + duży tytuł + opis (kontakt, blog)',
            'icon' => 'heading',
            'render_template' => 'blocks.page-header',
        ],
        [
            'name' => 'features',
            'title' => 'Dlaczego Warto / Voucher',
            'description' => 'Sekcja z nagłówkiem i kartami (ikona + tytuł + opis)',
            'icon' => 'columns',
            'render_template' => 'blocks.features',
        ],
        [
            'name' => 'subpage-hero',
            'title' => 'Hero Podstrona',
            'description' => 'Hero sekcja dla podstron z tytułem i dwoma zdjęciami',
            'icon' => 'cover-image',
            'render_template' => 'blocks.subpage-hero',
        ],
        [
            'name' => 'service-faq',
            'title' => 'Opis Usługi / FAQ',
            'description' => 'Accordion z najczęściej zadawanymi pytaniami',
            'icon' => 'editor-help',
            'render_template' => 'blocks.service-faq',
        ],
        [
            'name' => 'service-process',
            'title' => 'Opis Usługi / Proces Współpracy',
            'description' => 'Timeline z krokami procesu współpracy',
            'icon' => 'editor-ol',
            'render_template' => 'blocks.service-process',
        ],
        [
            'name' => 'service-why',
            'title' => 'Opis Usługi / Dlaczego Warto',
            'description' => 'Blok z benefitami, opisem i zdjęciem',
            'icon' => 'star-filled',
            'render_template' => 'blocks.service-why',
        ],
        [
            'name' => 'service-trust',
            'title' => 'Opis Usługi / Zaufanie i Doświadczenie',
            'description' => '2 karty side-by-side: lewa (społeczny dowód) + prawa (zdjęcie + doświadczenie)',
            'icon' => 'images-alt2',
            'render_template' => 'blocks.service-trust',
        ],
        [
            'name' => 'service-video',
            'title' => 'Opis Usługi / Video CTA',
            'description' => 'Zdjęcie + przycisk otwierający modal „Poznaj mnie” (treść globalna: Ustawienia → Sekcja: Poznaj mnie).',
            'icon' => 'video-alt3',
            'render_template' => 'blocks.service-video',
        ],
        [
            'name' => 'local-seo',
            'title' => 'Linki lokalne (SEO)',
            'description' => 'Siatka kart z linkami do podstron lokalnych (zdjęcie + tytuł + „Dowiedz się więcej”). Pod SEO, na dole wybranych usług.',
            'icon' => 'location-alt',
            'render_template' => 'blocks.local-seo',
        ],
        [
            'name' => 'brand-logos',
            'title' => 'Logotypy marek',
            'description' => 'Nagłówek + siatka logotypów marek (grayscale, kolor na hover). Repeater: logo + nazwa + link.',
            'icon' => 'awards',
            'render_template' => 'blocks.brand-logos',
        ],
        [
            'name' => 'manifest',
            'title' => 'Filozofia / Cytat',
            'description' => 'Duży cudzysłów + cytat + avatar/podpis po lewej, szerokie zdjęcie po prawej. Wg Figmy.',
            'icon' => 'format-quote',
            'render_template' => 'blocks.manifest',
        ],
        [
            'name' => 'text-columns',
            'title' => 'Tekst 2 kolumny (nagłówek + treść)',
            'description' => 'Nagłówek po lewej + akapity po prawej. Editorial, reużywalny.',
            'icon' => 'columns',
            'render_template' => 'blocks.text-columns',
        ],
        [
            'name' => 'blog-archive',
            'title' => 'Blog – Archiwum z filtrami',
            'description' => 'Pasek filtrów (kategorie + sezon) + grid wszystkich wpisów + paginacja',
            'icon' => 'list-view',
            'render_template' => 'blocks.blog-archive',
        ],
        [
            'name' => 'guides-archive',
            'title' => 'Poradniki – Archiwum',
            'description' => 'Grid wszystkich poradników + paginacja (pusty stan z zachętą do newslettera)',
            'icon' => 'book-alt',
            'render_template' => 'blocks.guides-archive',
        ],
        [
            'name' => 'subscribe',
            'title' => 'Newsletter + Instagram',
            'description' => 'Dwie karty obok siebie: zapis na newsletter + zachęta do śledzenia Instagrama',
            'icon' => 'megaphone',
            'render_template' => 'blocks.subscribe',
        ],
        [
            'name' => 'contact-bar',
            'title' => 'Pasek kontaktowy',
            'description' => 'Adres + dane formalne (NIP) + telefon + email w 3 kolumnach (np. pod headerem strony Kontakt)',
            'icon' => 'id-alt',
            'render_template' => 'blocks.contact-bar',
        ],
        [
            'name' => 'personal-intro',
            'title' => 'Personal Intro',
            'description' => 'Zdjęcie + krótki tekst od Dominika (humanizacja, obniżenie bariery kontaktu)',
            'icon' => 'admin-users',
            'render_template' => 'blocks.personal-intro',
        ],
        [
            'name' => 'contact-channels',
            'title' => 'Kanały kontaktu',
            'description' => '4 kafelki: Zadzwoń / WhatsApp / Instagram DM / Email — instant CTA bez formularza',
            'icon' => 'phone',
            'render_template' => 'blocks.contact-channels',
        ],
        [
            'name' => 'next-steps',
            'title' => 'Co dalej? (3 kroki)',
            'description' => 'Timeline 3 kroków: co się stanie po kontakcie. Set expectations dla użytkownika.',
            'icon' => 'list-view',
            'render_template' => 'blocks.next-steps',
        ],
        [
            'name' => 'consultation-process',
            'title' => 'Konsultacja / Jak to działa',
            'description' => 'Schodkowe 4 kroki procesu konsultacji + CTA otwierające modal rezerwacji. Dedykowana podstrona /konsultacje/.',
            'icon' => 'editor-ol',
            'render_template' => 'blocks.consultation-process',
        ],
        [
            'name' => 'lookbook-section',
            'title' => 'Lookbook — sekcja produktowa',
            'description' => 'Heading + opis + galeria zdjęć z brandami i linkami do sklepu. 3 layouty (grid-3 / grid-4 / split z modelem).',
            'icon' => 'screenoptions',
            'render_template' => 'blocks.lookbook-section',
        ],
        [
            'name' => 'blog-pullquote',
            'title' => 'Pull quote (wyróżniona myśl)',
            'description' => 'Duża wyróżniona myśl z cudzysłowem — do akcentowania kluczowych wniosków w artykule.',
            'icon' => 'format-quote',
            'render_template' => 'blocks.blog-pullquote',
        ],
        [
            'name' => 'blog-callout',
            'title' => 'Callout (Pro tip / info / warning)',
            'description' => 'Boxed wstawka z ikoną i krótkim akcentowanym tekstem (3 warianty: tip / info / warning).',
            'icon' => 'lightbulb',
            'render_template' => 'blocks.blog-callout',
        ],
        [
            'name' => 'blog-personal-quote',
            'title' => 'Cytat osobisty (Dominik z foto)',
            'description' => 'Cytat od Dominika z jego foto i rolą — buduje personal brand wewnątrz artykułu.',
            'icon' => 'businessperson',
            'render_template' => 'blocks.blog-personal-quote',
        ],
    ];

    foreach ($blocks as $block) {
        $template = $block['render_template'];
        unset($block['render_template']);

        acf_register_block_type(array_merge($block, [
            'category' => 'theme',
            'mode' => 'preview',
            'supports' => [
                'align' => false,
                'anchor' => true,
            ],
            'render_callback' => function ($block) use ($template) {
                echo view($template, ['block' => $block])->render();
            },
        ]));
    }
});

add_filter('block_categories_all', function ($categories) {
    array_unshift($categories, [
        'slug' => 'theme',
        'title' => 'Motyw',
    ]);

    return $categories;
});
