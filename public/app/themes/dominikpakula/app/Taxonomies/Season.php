<?php

/**
 * Season Taxonomy — przypisanie wpisów blogowych do sezonów (np. lato, zima, wesele, wieczór).
 */

namespace App\Taxonomies;

add_action('init', function () {
    register_taxonomy('season', ['post'], [
        'labels' => [
            'name' => 'Sezony',
            'singular_name' => 'Sezon',
            'search_items' => 'Szukaj sezonów',
            'all_items' => 'Wszystkie sezony',
            'parent_item' => 'Sezon nadrzędny',
            'parent_item_colon' => 'Sezon nadrzędny:',
            'edit_item' => 'Edytuj sezon',
            'update_item' => 'Aktualizuj sezon',
            'add_new_item' => 'Dodaj nowy sezon',
            'new_item_name' => 'Nazwa nowego sezonu',
            'menu_name' => 'Sezony',
        ],
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'rewrite' => ['slug' => 'sezon', 'with_front' => false],
    ]);
});
