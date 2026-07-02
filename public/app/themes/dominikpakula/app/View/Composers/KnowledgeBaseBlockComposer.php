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
        return [
            'latestPost' => $this->latestBlogPost(),
            'guides' => $this->latestGuides(4),
        ];
    }

    protected function latestBlogPost(): ?array
    {
        $posts = get_posts([
            'post_type' => 'post',
            'posts_per_page' => 1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'update_post_term_cache' => false,
        ]);

        if (! $posts) {
            return null;
        }

        $post = $posts[0];
        $thumbId = \get_post_thumbnail_id($post->ID);

        return [
            'title' => get_the_title($post->ID),
            'url' => get_permalink($post->ID),
            'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'large') ?: '') : '',
        ];
    }

    protected function latestGuides(int $limit): array
    {
        $posts = get_posts([
            'post_type' => 'guide',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'update_post_term_cache' => false,
        ]);

        if (! $posts) {
            return [];
        }

        $ids = wp_list_pluck($posts, 'ID');
        update_post_thumbnail_cache(new \WP_Query(['post__in' => $ids, 'post_type' => 'guide', 'posts_per_page' => -1]));

        $items = [];
        foreach ($posts as $post) {
            $thumbId = \get_post_thumbnail_id($post->ID);
            $excerpt = $post->post_excerpt !== ''
                ? wp_trim_words($post->post_excerpt, 18, '…')
                : wp_trim_words(strip_shortcodes($post->post_content), 18, '…');

            $items[] = [
                'title' => get_the_title($post->ID),
                'url' => get_permalink($post->ID),
                'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'medium') ?: '') : '',
                'excerpt' => $excerpt,
            ];
        }

        return $items;
    }
}
