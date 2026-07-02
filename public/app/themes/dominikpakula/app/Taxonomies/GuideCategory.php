<?php

/**
 * Guide Category Taxonomy — kategorie tematyczne poradników (CPT guide).
 */

namespace App\Taxonomies;

add_action('init', function () {
    register_taxonomy('guide_category', ['guide'], [
        'labels' => [
            'name' => 'Kategorie poradników',
            'singular_name' => 'Kategoria poradnika',
            'search_items' => 'Szukaj kategorii',
            'all_items' => 'Wszystkie kategorie',
            'parent_item' => 'Kategoria nadrzędna',
            'parent_item_colon' => 'Kategoria nadrzędna:',
            'edit_item' => 'Edytuj kategorię',
            'update_item' => 'Aktualizuj kategorię',
            'add_new_item' => 'Dodaj nową kategorię',
            'new_item_name' => 'Nazwa nowej kategorii',
            'menu_name' => 'Kategorie',
        ],
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        'show_in_nav_menus' => true,
        'rewrite' => ['slug' => 'temat-poradnika', 'with_front' => false],
    ]);
});

/**
 * Jednorazowy flush rewrite rules po dodaniu taksonomii guide_category.
 * Odpala się raz (po rejestracji CPT + taksonomii, priorytet 20), zapisuje wersję w opcji.
 * Bumpnij stałą przy kolejnych zmianach rewrite (nowe CPT/taksonomie/slugi), by wymusić ponowny flush.
 */
add_action('init', function () {
    $version = '2026070201';

    if (get_option('dp_rewrite_version') === $version) {
        return;
    }

    flush_rewrite_rules(false);
    update_option('dp_rewrite_version', $version);
}, 20);

