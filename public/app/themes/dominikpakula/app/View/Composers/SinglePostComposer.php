<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\Blog\reading_time;
use function App\Blog\blog_url;
use function App\Blog\related_posts;

class SinglePostComposer extends Composer
{
    protected static $views = [
        'single-post',
        'partials.blog.*',
    ];

    public function with(): array
    {
        $postId = get_the_ID();
        if (! $postId) {
            return $this->emptyData();
        }

        $post = get_post($postId);
        $authorId = (int) $post->post_author;

        $thumbId = \get_post_thumbnail_id($postId);
        $heroImageAlt = $thumbId ? (get_post_meta($thumbId, '_wp_attachment_image_alt', true) ?: '') : '';
        $heroImageTag = $thumbId
            ? wp_get_attachment_image($thumbId, 'full', false, [
                'class' => 'absolute inset-0 size-full object-cover',
                'alt' => $heroImageAlt,
                'fetchpriority' => 'high',
                'decoding' => 'async',
            ])
            : '';

        $categories = get_the_category($postId);
        $primaryCategory = $categories[0] ?? null;

        $manualExcerpt = has_excerpt($postId) ? wp_strip_all_tags($post->post_excerpt) : '';

        $permalink = get_permalink($postId) ?: '';
        $title = get_the_title($postId);

        return [
            'postId' => $postId,
            'title' => $title,
            'permalink' => $permalink,
            'lead' => $manualExcerpt,
            'content' => $post->post_content,
            'date' => get_the_date('d.m.Y', $postId),
            'dateIso' => get_the_date('Y-m-d', $postId),
            'readingTime' => reading_time($post->post_content),
            'heroImageTag' => $heroImageTag,
            'heroImageAlt' => $heroImageAlt,
            'blogUrl' => blog_url(),
            'category' => $primaryCategory ? [
                'id' => $primaryCategory->term_id,
                'name' => $primaryCategory->name,
                'slug' => $primaryCategory->slug,
                'url' => get_category_link($primaryCategory->term_id),
            ] : null,
            'author' => [
                'id' => $authorId,
                'name' => get_the_author_meta('display_name', $authorId),
                'bio' => get_the_author_meta('description', $authorId),
                'avatar' => get_avatar_url($authorId, ['size' => 192]) ?: '',
                'url' => get_author_posts_url($authorId),
            ],
            'tags' => get_the_tags($postId) ?: [],
            'relatedPosts' => $this->mapRelatedPosts($postId, 3),
            'teaserPost' => $this->teaserPost($postId),
            'prevPost' => $this->adjacentPost($postId, true),
            'nextPost' => $this->adjacentPost($postId, false),
            'categoriesTop' => $this->topCategories($primaryCategory?->term_id, 6),
            'shareLinks' => $this->shareLinks($title, $permalink),
        ];
    }

    protected function mapRelatedPosts(int $postId, int $limit): array
    {
        $posts = related_posts($postId, $limit);
        $items = [];

        foreach ($posts as $p) {
            $thumbId = \get_post_thumbnail_id($p->ID);
            $items[] = [
                'title' => get_the_title($p->ID),
                'url' => get_permalink($p->ID),
                'date' => get_the_date('d.m.Y', $p->ID),
                'author' => get_the_author_meta('display_name', $p->post_author),
                'excerpt' => wp_trim_words(get_the_excerpt($p->ID), 20, '...'),
                'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'medium_large') ?: '') : '',
                'readingTime' => reading_time($p->post_content),
            ];
        }

        return $items;
    }

    protected function teaserPost(int $postId): ?array
    {
        $posts = related_posts($postId, 1);
        if (! $posts) {
            return null;
        }

        $p = $posts[0];
        $thumbId = \get_post_thumbnail_id($p->ID);

        return [
            'title' => get_the_title($p->ID),
            'url' => get_permalink($p->ID),
            'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'medium') ?: '') : '',
            'readingTime' => reading_time($p->post_content),
        ];
    }

    protected function adjacentPost(int $postId, bool $previous): ?array
    {
        $adjacent = get_adjacent_post(false, '', $previous);

        if (! $adjacent instanceof \WP_Post) {
            return null;
        }

        return [
            'title' => get_the_title($adjacent->ID),
            'url' => get_permalink($adjacent->ID),
        ];
    }

    protected function topCategories(?int $currentId, int $limit): array
    {
        $terms = get_terms([
            'taxonomy' => 'category',
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => $limit,
            'hide_empty' => true,
        ]);

        if (! $terms || is_wp_error($terms)) {
            return [];
        }

        $items = [];
        foreach ($terms as $term) {
            $items[] = [
                'name' => $term->name,
                'count' => (int) $term->count,
                'url' => get_category_link($term->term_id),
                'isCurrent' => $currentId === $term->term_id,
            ];
        }

        return $items;
    }

    protected function shareLinks(string $title, string $url): array
    {
        $encodedUrl = rawurlencode($url);
        $encodedTitle = rawurlencode($title);
        $encodedText = rawurlencode($title . ' — ' . $url);

        return [
            'messenger' => 'fb-messenger://share?link=' . $encodedUrl,
            'whatsapp' => 'https://wa.me/?text=' . $encodedText,
            'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $encodedUrl,
            'email' => 'mailto:?subject=' . $encodedTitle . '&body=' . $encodedUrl,
        ];
    }

    protected function emptyData(): array
    {
        return [
            'postId' => 0,
            'title' => '',
            'permalink' => '',
            'lead' => '',
            'content' => '',
            'date' => '',
            'dateIso' => '',
            'readingTime' => 1,
            'heroImageTag' => '',
            'heroImageAlt' => '',
            'blogUrl' => home_url('/'),
            'category' => null,
            'author' => ['id' => 0, 'name' => '', 'bio' => '', 'avatar' => '', 'url' => ''],
            'tags' => [],
            'relatedPosts' => [],
            'teaserPost' => null,
            'prevPost' => null,
            'nextPost' => null,
            'categoriesTop' => [],
            'shareLinks' => ['messenger' => '#', 'whatsapp' => '#', 'facebook' => '#', 'email' => '#'],
        ];
    }
}
