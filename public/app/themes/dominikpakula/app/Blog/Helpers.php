<?php

/**
 * Blog helper functions: reading time, related posts, Polish plurals.
 */

namespace App\Blog;

/**
 * Estimate reading time in minutes. Min 1.
 * Uses UTF-8-safe preg_split (str_word_count breaks on Polish diacritics).
 */
function reading_time(string $content, int $wpm = 200): int
{
    if ($content === '') {
        return 1;
    }

    $text = strip_tags($content);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $words = preg_split('/\s+/u', trim($text), -1, PREG_SPLIT_NO_EMPTY);
    $count = is_array($words) ? count($words) : 0;

    return max(1, (int) ceil($count / max(1, $wpm)));
}

/**
 * Format reading time as "N min czytania".
 */
function reading_time_label(string $content): string
{
    return reading_time($content) . ' min czytania';
}

/**
 * Related posts — same category first, fallback newest.
 * Returns WP_Post[].
 */
function related_posts(int $postId, int $limit = 3): array
{
    $categories = wp_get_post_categories($postId, ['fields' => 'ids']);

    $args = [
        'post_type' => 'post',
        'posts_per_page' => $limit,
        'post__not_in' => [$postId],
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'update_post_term_cache' => false,
    ];

    if (! empty($categories)) {
        $args['category__in'] = $categories;
    }

    $posts = \get_posts($args);

    // Fallback: newest overall if category search returned fewer than $limit
    if (count($posts) < $limit && ! empty($categories)) {
        $remaining = $limit - count($posts);
        $excludeIds = array_merge([$postId], wp_list_pluck($posts, 'ID'));
        $fallback = \get_posts([
            'post_type' => 'post',
            'posts_per_page' => $remaining,
            'post__not_in' => $excludeIds,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
            'update_post_term_cache' => false,
        ]);
        $posts = array_merge($posts, $fallback);
    }

    if ($posts) {
        $ids = wp_list_pluck($posts, 'ID');
        update_post_thumbnail_cache(new \WP_Query(['post__in' => $ids, 'post_type' => 'post', 'posts_per_page' => -1]));
    }

    return $posts;
}

/**
 * Polish plural form picker.
 *
 * Rules: 1 → $one; 2-4 (except 12-14) → $few; else → $many.
 *
 * @example polish_plural(5, 'komentarz', 'komentarze', 'komentarzy') === 'komentarzy'
 */
function polish_plural(int $count, string $one, string $few, string $many): string
{
    $absCount = abs($count);
    $mod10 = $absCount % 10;
    $mod100 = $absCount % 100;

    if ($absCount === 1) {
        return $one;
    }

    if ($mod10 >= 2 && $mod10 <= 4 && ! ($mod100 >= 12 && $mod100 <= 14)) {
        return $few;
    }

    return $many;
}

/**
 * "{count} {word}" with Polish plural.
 */
function polish_plural_count(int $count, string $one, string $few, string $many): string
{
    return $count . ' ' . polish_plural($count, $one, $few, $many);
}

/**
 * Blog index URL.
 * Priority: Reading → Posts page → post archive → home.
 */
function blog_url(): string
{
    $pageId = (int) get_option('page_for_posts');
    if ($pageId) {
        $link = get_permalink($pageId);
        if ($link) {
            return $link;
        }
    }

    $archive = get_post_type_archive_link('post');
    if ($archive) {
        return $archive;
    }

    return home_url('/');
}
