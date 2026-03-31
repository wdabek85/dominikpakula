<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NavigationComposer extends Composer
{
    protected static $views = [
        'sections.header',
        'sections.header.nav-desktop',
        'sections.header.nav-mobile',
    ];

    public function with(): array
    {
        $services = get_posts([
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish',
        ]);

        $items = [];

        foreach ($services as $service) {
            $image = \get_post_thumbnail_id($service->ID)
                ? wp_get_attachment_image_url(\get_post_thumbnail_id($service->ID), 'thumbnail')
                : '';

            $description = \get_field('service_sidebar_description', $service->ID) ?: '';

            $items[] = [
                'title' => get_the_title($service->ID),
                'url' => get_permalink($service->ID),
                'image' => $image,
                'description' => $description,
            ];
        }

        return [
            'navServices' => $items,
        ];
    }
}
