<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class KnowledgeBaseBlockComposer extends Composer
{
    protected static $views = [
        'blocks.knowledge-base',
    ];

    public function with(): array
    {
        // Latest blog post
        $latestPosts = get_posts([
            'post_type' => 'post',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        $latestPost = null;
        if (!empty($latestPosts)) {
            $post = $latestPosts[0];
            $latestPost = [
                'title' => get_the_title($post->ID),
                'url' => get_permalink($post->ID),
                'image' => get_the_post_thumbnail_url($post->ID, 'large') ?: '',
            ];
        }

        // Latest guides
        $guidePosts = get_posts([
            'post_type' => 'guide',
            'posts_per_page' => 4,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        ]);

        $guides = [];
        foreach ($guidePosts as $post) {
            $guides[] = [
                'title' => get_the_title($post->ID),
                'url' => get_permalink($post->ID),
                'image' => get_the_post_thumbnail_url($post->ID, 'medium') ?: '',
            ];
        }

        return [
            'latestPost' => $latestPost,
            'guides' => $guides,
        ];
    }
}
