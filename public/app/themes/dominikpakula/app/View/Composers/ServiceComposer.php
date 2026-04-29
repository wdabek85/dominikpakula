<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceComposer extends Composer
{
    protected static $views = [
        'single-service',
    ];

    public function with(): array
    {
        $thumbId = \get_post_thumbnail_id();
        $image = $thumbId ? (wp_get_attachment_image_url($thumbId, 'large') ?: '') : '';
        $imageAlt = $thumbId ? (get_post_meta($thumbId, '_wp_attachment_image_alt', true) ?: '') : '';

        $sidebarTitle = \get_field('service_sidebar_title') ?: get_the_title();
        $sidebarDescription = \get_field('service_sidebar_description') ?: '';
        $price = \get_field('service_price') ?: '';
        $tags = \get_field('service_tags') ?: [];

        return [
            'image' => $image,
            'imageAlt' => $imageAlt,
            'sidebarTitle' => $sidebarTitle,
            'sidebarDescription' => $sidebarDescription,
            'price' => $price,
            'tags' => $tags,
            'includedHeading' => \get_field('service_included_heading') ?: 'W cenie znajdziesz',
            'includedItems' => $this->includedItems(),
            'sidebarTestimonial' => $this->sidebarTestimonial(),
            'relatedServices' => $this->relatedServices(),
        ];
    }

    protected function sidebarTestimonial(): ?array
    {
        $posts = get_posts([
            'post_type' => 'testimonial',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        if (! $posts) {
            return null;
        }

        $post = $posts[0];
        $thumbId = \get_post_thumbnail_id($post->ID);

        return [
            'quote' => \get_field('testimonial_quote', $post->ID) ?: '',
            'author' => get_the_title($post->ID),
            'service' => \get_field('testimonial_service', $post->ID) ?: '',
            'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'medium') ?: '') : '',
        ];
    }

    protected function relatedServices(): array
    {
        $currentId = get_the_ID();

        $posts = get_posts([
            'post_type' => 'service',
            'posts_per_page' => 3,
            'post__not_in' => $currentId ? [$currentId] : [],
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish',
            'update_post_term_cache' => false,
        ]);

        if ($posts) {
            $ids = wp_list_pluck($posts, 'ID');
            update_post_thumbnail_cache(new \WP_Query(['post__in' => $ids, 'post_type' => 'service', 'posts_per_page' => -1]));

            $items = [];
            foreach ($posts as $post) {
                $thumbId = \get_post_thumbnail_id($post->ID);
                $items[] = [
                    'title' => get_the_title($post->ID),
                    'url' => get_permalink($post->ID),
                    'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'thumbnail') ?: '') : '',
                ];
            }

            return $items;
        }

        // Fallback dla MVP — gdy brak innych usług w CPT, pokaż przykładowe.
        return [
            [
                'title' => 'Przegląd szafy',
                'url' => home_url('/uslugi/przeglad-szafy/'),
                'image' => '',
            ],
            [
                'title' => 'Zakupy ze stylistą',
                'url' => home_url('/uslugi/zakupy-ze-stylista/'),
                'image' => '',
            ],
            [
                'title' => 'Stylizacja na okazję',
                'url' => home_url('/uslugi/stylizacja-na-okazje/'),
                'image' => '',
            ],
        ];
    }

    // ACF repeater `service_included_items` (z polem `service_included_item`)
    // z fallbackiem hardcoded dla usług bez wpisanych pozycji.
    protected function includedItems(): array
    {
        $rows = \get_field('service_included_items') ?: [];

        if ($rows && is_array($rows)) {
            $items = [];
            foreach ($rows as $row) {
                $val = is_array($row) ? ($row['service_included_item'] ?? '') : (string) $row;
                if ($val !== '') {
                    $items[] = $val;
                }
            }
            if ($items) {
                return $items;
            }
        }

        // Defaults dla usługi stylistycznej.
        return [
            'Konsultacja 1-1 (60 min)',
            'Plan stylizacji dopasowany do Ciebie',
            'Konkretne propozycje zakupowe',
            'Wsparcie e-mailowe przez 14 dni',
        ];
    }
}
