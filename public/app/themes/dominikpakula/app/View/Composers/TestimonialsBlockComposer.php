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

        $posts = array_values(array_filter($selectedPosts, fn ($p) => $p instanceof \WP_Post));

        // Fallback gdy w panelu nic nie wybrano — 3 najnowsze opinie z CPT.
        if (! $posts) {
            $posts = get_posts([
                'post_type' => 'testimonial',
                'posts_per_page' => 3,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_status' => 'publish',
            ]);
        }

        if ($posts) {
            $ids = wp_list_pluck($posts, 'ID');
            update_post_thumbnail_cache(new \WP_Query(['post__in' => $ids, 'post_type' => 'testimonial', 'posts_per_page' => -1]));
            update_meta_cache('post', $ids);
        }

        $testimonials = [];
        foreach ($posts as $post) {
            $thumbId = \get_post_thumbnail_id($post->ID);
            $mediaType = strtolower(\get_field('testimonial_media_type', $post->ID) ?: 'image');

            $testimonials[] = [
                'quote' => \get_field('testimonial_quote', $post->ID) ?: '',
                'author' => get_the_title($post->ID),
                'service' => \get_field('testimonial_service', $post->ID) ?: '',
                'media_type' => $mediaType,
                'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'large') ?: '') : '',
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
