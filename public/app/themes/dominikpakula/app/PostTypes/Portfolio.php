<?php

/**
 * Portfolio Custom Post Type.
 */

namespace App\PostTypes;

add_action('init', function () {
    register_post_type('portfolio', [
        'labels' => [
            'name' => 'Portfolio',
            'singular_name' => 'Realizacja',
            'add_new' => 'Dodaj realizację',
            'add_new_item' => 'Dodaj nową realizację',
            'edit_item' => 'Edytuj realizację',
            'new_item' => 'Nowa realizacja',
            'view_item' => 'Zobacz realizację',
            'search_items' => 'Szukaj realizacji',
            'not_found' => 'Nie znaleziono realizacji',
            'not_found_in_trash' => 'Brak realizacji w koszu',
            'all_items' => 'Wszystkie realizacje',
            'menu_name' => 'Portfolio',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-portfolio',
        'menu_position' => 26,
        'supports' => ['title', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'realizacje', 'with_front' => false],
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    ]);
});
