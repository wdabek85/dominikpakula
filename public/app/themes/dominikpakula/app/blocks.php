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
