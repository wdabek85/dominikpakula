<?php

/**
 * Blog filters — automatic TOC id injection on H2/H3 in single post content.
 */

namespace App\Blog;

add_filter('the_content', __NAMESPACE__ . '\\add_heading_ids', 20);

/**
 * Add slug-based `id` to H2 and H3 that don't already have one.
 * Only runs on single post / guide view (not archive, not other post types, not admin).
 */
function add_heading_ids(string $content): string
{
    if (! is_singular(['post', 'guide']) || is_admin() || ! in_the_loop() || ! is_main_query()) {
        return $content;
    }

    if (! preg_match('/<h[23][\s>]/i', $content)) {
        return $content;
    }

    $usedSlugs = [];

    return preg_replace_callback(
        '/<(h[23])(\s[^>]*)?>(.*?)<\/\1>/is',
        function ($match) use (&$usedSlugs) {
            $tag = $match[1];
            $attrs = $match[2] ?? '';
            $inner = $match[3];

            if (preg_match('/\sid\s*=\s*["\'][^"\']+["\']/i', $attrs)) {
                return $match[0];
            }

            $text = trim(strip_tags($inner));
            if ($text === '') {
                return $match[0];
            }

            $slug = heading_slug($text);
            if ($slug === '') {
                return $match[0];
            }

            $base = $slug;
            $i = 2;
            while (in_array($slug, $usedSlugs, true)) {
                $slug = $base . '-' . $i;
                $i++;
            }
            $usedSlugs[] = $slug;

            return '<' . $tag . $attrs . ' id="' . esc_attr($slug) . '">' . $inner . '</' . $tag . '>';
        },
        $content
    ) ?? $content;
}

/**
 * Polish-aware slug for heading anchors.
 * Uses sanitize_title when WP is loaded (handles locale transliteration if WPLANG set),
 * falls back to a safe ASCII slugifier.
 */
function heading_slug(string $text): string
{
    if (function_exists('sanitize_title')) {
        $slug = sanitize_title($text);
        if ($slug !== '') {
            return $slug;
        }
    }

    $text = preg_replace('/[^\p{L}\p{N}\s-]+/u', '', $text);
    $text = preg_replace('/\s+/u', '-', trim($text));

    return mb_strtolower($text, 'UTF-8');
}
