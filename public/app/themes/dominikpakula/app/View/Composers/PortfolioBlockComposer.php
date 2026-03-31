<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PortfolioBlockComposer extends Composer
{
    protected static $views = [
        'blocks.portfolio.index',
    ];

    public function with(): array
    {
        $title = \get_field('portfolio_title') ?: '';
        $subtitle = \get_field('portfolio_subtitle') ?: '';

        $selectedPosts = \get_field('portfolio_items') ?: [];
        $items = [];

        foreach ($selectedPosts as $post) {
            if (! $post instanceof \WP_Post) {
                continue;
            }

            $image = \get_post_thumbnail_id($post->ID)
                ? wp_get_attachment_image_url(\get_post_thumbnail_id($post->ID), 'large')
                : '';

            $items[] = [
                'title' => get_the_title($post->ID),
                'category' => \get_field('portfolio_category', $post->ID) ?: '',
                'image' => $image,
                'link' => get_permalink($post->ID),
            ];
        }

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'items' => $items,
        ];
    }
}
