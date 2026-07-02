<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\Blog\reading_time;
use function App\Blog\related_guides;

class SingleGuideComposer extends Composer
{
    protected static $views = [
        'single-guide',
        'partials.guide.*',
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

        $permalink = get_permalink($postId) ?: '';
        $title = get_the_title($postId);
        $guidesUrl = $this->guidesUrl();

        $categories = $this->guideCategories($postId, $guidesUrl);

        $manualExcerpt = has_excerpt($postId) ? wp_strip_all_tags($post->post_excerpt) : '';

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
            'guidesUrl' => $guidesUrl,
            'categories' => $categories,
            'primaryCategory' => $categories[0] ?? null,
            'authorName' => get_the_author_meta('display_name', $authorId),
            'relatedGuides' => $this->mapRelatedGuides($postId, 3),
            'shareLinks' => $this->shareLinks($title, $permalink),
        ];
    }

    /**
     * URL strony zbiorczej poradników (WP page o slugu "poradniki"), fallback /poradniki/.
     */
    protected function guidesUrl(): string
    {
        $page = get_page_by_path('poradniki');
        if ($page) {
            $link = get_permalink($page);
            if ($link) {
                return $link;
            }
        }

        return home_url('/poradniki/');
    }

    /**
     * Terminy guide_category przypisane do poradnika, z linkiem do przefiltrowanej strony zbiorczej.
     */
    protected function guideCategories(int $postId, string $guidesUrl): array
    {
        $terms = get_the_terms($postId, 'guide_category');
        if (is_wp_error($terms) || ! $terms) {
            return [];
        }

        $items = [];
        foreach ($terms as $term) {
            $items[] = [
                'name' => $term->name,
                'slug' => $term->slug,
                'url' => add_query_arg('category', $term->slug, $guidesUrl),
            ];
        }

        return $items;
    }

    protected function mapRelatedGuides(int $postId, int $limit): array
    {
        $posts = related_guides($postId, $limit);
        $items = [];

        foreach ($posts as $p) {
            $thumbId = \get_post_thumbnail_id($p->ID);
            $excerpt = $p->post_excerpt !== ''
                ? wp_trim_words($p->post_excerpt, 20, '…')
                : wp_trim_words(strip_shortcodes($p->post_content), 20, '…');

            $items[] = [
                'title' => get_the_title($p->ID),
                'url' => get_permalink($p->ID),
                'date' => get_the_date('d.m.Y', $p->ID),
                'excerpt' => $excerpt,
                'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'medium_large') ?: '') : '',
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
            'guidesUrl' => home_url('/poradniki/'),
            'categories' => [],
            'primaryCategory' => null,
            'authorName' => '',
            'relatedGuides' => [],
            'shareLinks' => ['messenger' => '#', 'whatsapp' => '#', 'facebook' => '#', 'email' => '#'],
        ];
    }
}
