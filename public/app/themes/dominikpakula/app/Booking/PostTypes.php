<?php

/**
 * Booking CPT registration.
 */

namespace App\Booking;

add_action('init', function () {
    register_post_type('booking', [
        'labels' => [
            'name' => 'Rezerwacje',
            'singular_name' => 'Rezerwacja',
            'add_new' => 'Dodaj rezerwację',
            'add_new_item' => 'Dodaj nową rezerwację',
            'edit_item' => 'Edytuj rezerwację',
            'new_item' => 'Nowa rezerwacja',
            'view_item' => 'Zobacz rezerwację',
            'search_items' => 'Szukaj rezerwacji',
            'not_found' => 'Nie znaleziono rezerwacji',
            'not_found_in_trash' => 'Brak rezerwacji w koszu',
            'all_items' => 'Wszystkie rezerwacje',
            'menu_name' => 'Rezerwacje',
        ],
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-calendar-alt',
        'menu_position' => 30,
        'supports' => ['title'],
        'capabilities' => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap' => true,
    ]);
});

/**
 * Helper: get all services for booking.
 */
function get_booking_services(): array
{
    $posts = \get_posts([
        'post_type' => 'service',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'post_status' => 'publish',
    ]);

    $services = [];

    foreach ($posts as $post) {
        $price = \get_field('service_price', $post->ID) ?: '';

        $services[] = [
            'id' => $post->ID,
            'title' => get_the_title($post->ID),
            'slug' => $post->post_name,
            'url' => get_permalink($post->ID),
            'excerpt' => wp_trim_words(get_the_excerpt($post->ID), 20, '...'),
            'price' => $price,
        ];
    }

    return $services;
}
