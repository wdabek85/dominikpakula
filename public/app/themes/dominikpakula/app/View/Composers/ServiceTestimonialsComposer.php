<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceTestimonialsComposer extends Composer
{
    protected static $views = [
        'sections.service.testimonials',
    ];

    public function with(): array
    {
        $posts = get_posts([
            'post_type' => 'testimonial',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        $testimonials = [];

        foreach ($posts as $post) {
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
            'testimonials' => $testimonials,
        ];
    }
}
