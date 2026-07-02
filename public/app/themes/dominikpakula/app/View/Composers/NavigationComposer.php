<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NavigationComposer extends Composer
{
    protected static $views = [
        'sections.header',
        'sections.header.nav-desktop',
        'sections.header.nav-mobile',
        'sections.footer',
    ];

    public function with(): array
    {
        return [
            'navServices' => $this->services(),
            'navBlog' => $this->postsForNav('post', 3),
            'navGuides' => $this->postsForNav('guide', 3),
            'footerMenu' => $this->menuForLocation('footer_navigation'),
        ];
    }

    protected function menuForLocation(string $location): array
    {
        $locations = get_nav_menu_locations();
        $menuId = $locations[$location] ?? 0;

        if (! $menuId) {
            return [];
        }

        $items = wp_get_nav_menu_items($menuId);
        if (! $items) {
            return [];
        }

        $current = home_url(add_query_arg(null, null));

        $links = [];
        foreach ($items as $item) {
            $links[] = [
                'label' => $item->title,
                'url' => $item->url,
                'target' => $item->target ?: '_self',
                'isCurrent' => untrailingslashit($item->url) === untrailingslashit($current),
            ];
        }

        return $links;
    }

    protected function services(): array
    {
        $services = get_posts([
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_status' => 'publish',
            'update_post_term_cache' => false,
        ]);

        if (! $services) {
            return [];
        }

        $ids = wp_list_pluck($services, 'ID');
        update_post_thumbnail_cache(new \WP_Query(['post__in' => $ids, 'post_type' => 'service', 'posts_per_page' => -1]));
        update_meta_cache('post', $ids);

        $items = [];
        foreach ($services as $service) {
            $thumbId = \get_post_thumbnail_id($service->ID);
            $items[] = [
                'title' => get_the_title($service->ID),
                'url' => get_permalink($service->ID),
                'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'large') ?: '') : '',
                'description' => \get_field('service_sidebar_description', $service->ID) ?: '',
            ];
        }

        return $items;
    }

    protected function postsForNav(string $postType, int $limit): array
    {
        $posts = get_posts([
            'post_type' => $postType,
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
        update_post_thumbnail_cache(new \WP_Query(['post__in' => $ids, 'post_type' => $postType, 'posts_per_page' => -1]));

        $items = [];
        foreach ($posts as $post) {
            $thumbId = \get_post_thumbnail_id($post->ID);
            $excerpt = $post->post_excerpt !== ''
                ? wp_trim_words($post->post_excerpt, 16, '…')
                : wp_trim_words(strip_shortcodes($post->post_content), 16, '…');

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
