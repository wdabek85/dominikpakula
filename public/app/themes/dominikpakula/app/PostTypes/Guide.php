<?php

/**
 * Guide Custom Post Type (Poradniki).
 */

namespace App\PostTypes;

add_action('init', function () {
    register_post_type('guide', [
        'labels' => [
            'name' => 'Poradniki',
            'singular_name' => 'Poradnik',
            'add_new' => 'Dodaj poradnik',
            'add_new_item' => 'Dodaj nowy poradnik',
            'edit_item' => 'Edytuj poradnik',
            'new_item' => 'Nowy poradnik',
            'view_item' => 'Zobacz poradnik',
            'search_items' => 'Szukaj poradników',
            'not_found' => 'Nie znaleziono poradników',
            'not_found_in_trash' => 'Brak poradników w koszu',
            'all_items' => 'Wszystkie poradniki',
            'menu_name' => 'Poradniki',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-book-alt',
        'menu_position' => 27,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'poradniki', 'with_front' => false],
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    ]);
});
