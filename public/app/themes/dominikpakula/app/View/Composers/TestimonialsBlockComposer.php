<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TestimonialsBlockComposer extends Composer
{
    protected static $views = [
        'blocks.testimonials.index',
    ];

    public function with(): array
    {
        $title = \get_field('testimonials_title') ?: '';
        $subtitle = \get_field('testimonials_subtitle') ?: '';

        $selectedPosts = \get_field('testimonials_items') ?: [];
        $testimonials = [];

        foreach ($selectedPosts as $post) {
            if (! $post instanceof \WP_Post) {
                continue;
            }

            $mediaType = strtolower(\get_field('testimonial_media_type', $post->ID) ?: 'image');
            $image = \get_post_thumbnail_id($post->ID)
                ? wp_get_attachment_image_url(\get_post_thumbnail_id($post->ID), 'large')
                : '';

            $testimonials[] = [
                'quote' => \get_field('testimonial_quote', $post->ID) ?: '',
                'author' => get_the_title($post->ID),
                'service' => \get_field('testimonial_service', $post->ID) ?: '',
                'media_type' => $mediaType,
                'image' => $image,
                'video_url' => \get_field('testimonial_video_url', $post->ID) ?: '',
            ];
        }

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'testimonials' => $testimonials,
        ];
    }
}
