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
                ? wp_get_attachment_image_url(\get_post_thumbnail_id($service->ID), 'large')
                : '';

            $description = \get_field('service_sidebar_description', $service->ID) ?: '';

            $items[] = [
                'title' => get_the_title($service->ID),
                'url' => get_permalink($service->ID),
                'image' => $image,
                'description' => $description,
            ];
        }

        // Latest blog posts for knowledge base mega-menu
        $blogPosts = get_posts([
            'post_type' => 'post',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        $navBlog = [];
        foreach ($blogPosts as $post) {
            $navBlog[] = [
                'title' => get_the_title($post->ID),
                'url' => get_permalink($post->ID),
                'image' => get_the_post_thumbnail_url($post->ID, 'medium') ?: '',
            ];
        }

        // Latest guides for knowledge base mega-menu
        $guidePosts = get_posts([
            'post_type' => 'guide',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        $navGuides = [];
        foreach ($guidePosts as $post) {
            $navGuides[] = [
                'title' => get_the_title($post->ID),
                'url' => get_permalink($post->ID),
                'image' => get_the_post_thumbnail_url($post->ID, 'medium') ?: '',
            ];
        }

        return [
            'navServices' => $items,
            'navBlog' => $navBlog,
            'navGuides' => $navGuides,
        ];
    }
}
