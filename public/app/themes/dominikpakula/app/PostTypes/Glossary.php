<?php

/**
 * Glossary Custom Post Type (Słowniczek).
 */

namespace App\PostTypes;

add_action('init', function () {
    register_post_type('glossary', [
        'labels' => [
            'name' => 'Słowniczek',
            'singular_name' => 'Hasło',
            'add_new' => 'Dodaj hasło',
            'add_new_item' => 'Dodaj nowe hasło',
            'edit_item' => 'Edytuj hasło',
            'new_item' => 'Nowe hasło',
            'view_item' => 'Zobacz hasło',
            'search_items' => 'Szukaj haseł',
            'not_found' => 'Nie znaleziono haseł',
            'not_found_in_trash' => 'Brak haseł w koszu',
            'all_items' => 'Wszystkie hasła',
            'menu_name' => 'Słowniczek',
        ],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-editor-spellcheck',
        'menu_position' => 28,
        'supports' => ['title', 'editor', 'excerpt'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'slowniczek', 'with_front' => false],
        'exclude_from_search' => false,
        'publicly_queryable' => true,
    ]);
});

/**
 * Archiwum pokazuje wszystkie hasła naraz (litery A–Ż), bez paginacji.
 */
add_action('pre_get_posts', function (\WP_Query $query) {
    if (! is_admin() && $query->is_main_query() && $query->is_post_type_archive('glossary')) {
        $query->set('posts_per_page', -1);
        $query->set('no_found_rows', true);
    }
});
