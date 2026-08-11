<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\Blog\author_photo;

class BlogBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog',
    ];

    public function with(): array
    {
        $posts = get_posts([
            'post_type' => 'post',
            'posts_per_page' => 3,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        $items = [];

        foreach ($posts as $post) {
            $image = get_the_post_thumbnail_url($post->ID, 'medium_large') ?: '';
            $authorId = (int) $post->post_author;

            $items[] = [
                'title' => get_the_title($post->ID),
                'excerpt' => wp_trim_words(get_the_excerpt($post->ID), 30, '...'),
                'date' => get_the_date('j F Y', $post->ID),
                'author' => get_the_author_meta('display_name', $authorId),
                'authorAvatar' => author_photo($authorId, 'thumbnail'),
                'authorRole' => \get_field('author_role', 'user_' . $authorId) ?: '',
                'url' => get_permalink($post->ID),
                'image' => $image,
            ];
        }

        return [
            'posts' => $items,
        ];
    }
}
