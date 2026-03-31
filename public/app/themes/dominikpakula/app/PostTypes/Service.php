<?php

/**
 * Service Custom Post Type.
 */

namespace App\PostTypes;

add_action('init', function () {
    register_post_type('service', [
        'labels' => [
            'name' => 'Usługi',
            'singular_name' => 'Usługa',
            'add_new' => 'Dodaj usługę',
            'add_new_item' => 'Dodaj nową usługę',
            'edit_item' => 'Edytuj usługę',
            'new_item' => 'Nowa usługa',
            'view_item' => 'Zobacz usługę',
            'search_items' => 'Szukaj usług',
            'not_found' => 'Nie znaleziono usług',
            'not_found_in_trash' => 'Brak usług w koszu',
            'all_items' => 'Wszystkie usługi',
            'menu_name' => 'Usługi',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-clipboard',
        'menu_position' => 25,
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => false,
        'rewrite' => ['slug' => 'uslugi', 'with_front' => false],
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    ]);
});
