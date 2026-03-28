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
