<?php

/**
 * Testimonial Custom Post Type.
 */

namespace App\PostTypes;

add_action('init', function () {
    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Opinie',
            'singular_name' => 'Opinia',
            'add_new' => 'Dodaj opinię',
            'add_new_item' => 'Dodaj nową opinię',
            'edit_item' => 'Edytuj opinię',
            'new_item' => 'Nowa opinia',
            'view_item' => 'Zobacz opinię',
            'search_items' => 'Szukaj opinii',
            'not_found' => 'Nie znaleziono opinii',
            'not_found_in_trash' => 'Brak opinii w koszu',
            'all_items' => 'Wszystkie opinie',
            'menu_name' => 'Opinie',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-format-quote',
        'menu_position' => 25,
        'supports' => ['title', 'thumbnail'],
        'has_archive' => false,
        'rewrite' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
    ]);
});
