<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class GuidesArchiveBlockComposer extends Composer
{
    protected static $views = [
        'blocks.guides-archive',
    ];

    public function with(): array
    {
        $perPage = 9;
        $currentCategory = isset($_GET['category']) ? sanitize_title(wp_unslash($_GET['category'])) : '';
        $paged = max(1, (int) (get_query_var('paged') ?: ($_GET['paged'] ?? 1)));

        $taxQuery = [];
        if ($currentCategory !== '') {
            $taxQuery[] = [
                'taxonomy' => 'guide_category',
                'field' => 'slug',
                'terms' => $currentCategory,
            ];
        }

        $query = new WP_Query([
            'post_type' => 'guide',
            'post_status' => 'publish',
            'posts_per_page' => $perPage,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'update_post_term_cache' => false,
            'tax_query' => $taxQuery,
        ]);

        $items = [];
        if ($query->have_posts()) {
            $ids = wp_list_pluck($query->posts, 'ID');
            update_post_thumbnail_cache($query);
            update_meta_cache('post', $ids);

            foreach ($query->posts as $post) {
                $excerpt = $post->post_excerpt !== ''
                    ? wp_trim_words($post->post_excerpt, 28, '…')
                    : wp_trim_words(strip_shortcodes($post->post_content), 28, '…');

                $items[] = [
                    'title' => get_the_title($post->ID),
                    'excerpt' => $excerpt,
                    'date' => get_the_date('j F Y', $post->ID),
                    'url' => get_permalink($post->ID),
                    'image' => get_the_post_thumbnail_url($post->ID, 'medium_large') ?: '',
                ];
            }
        }
        wp_reset_postdata();

        return [
            'guides' => $items,
            'categories' => $this->terms('guide_category'),
            'currentCategory' => $currentCategory,
            'paginationHtml' => $this->paginationHtml($query, $paged),
            'totalFound' => (int) $query->found_posts,
        ];
    }

    protected function terms(string $taxonomy): array
    {
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ]);

        if (is_wp_error($terms) || ! $terms) {
            return [];
        }

        $items = [];
        foreach ($terms as $term) {
            $items[] = [
                'name' => $term->name,
                'slug' => $term->slug,
                'count' => (int) $term->count,
            ];
        }

        return $items;
    }

    protected function paginationHtml(WP_Query $query, int $currentPage): string
    {
        if ((int) $query->max_num_pages <= 1) {
            return '';
        }

        $base = remove_query_arg('paged', add_query_arg(null, null));

        $links = paginate_links([
            'base' => add_query_arg('paged', '%#%', $base),
            'format' => '',
            'current' => $currentPage,
            'total' => (int) $query->max_num_pages,
            'mid_size' => 1,
            'end_size' => 1,
            'prev_text' => '←',
            'next_text' => '→',
            'type' => 'array',
        ]);

        if (! is_array($links)) {
            return '';
        }

        $rendered = '';
        foreach ($links as $link) {
            $rendered .= '<li>' . $link . '</li>';
        }

        return '<ul class="flex flex-wrap items-center justify-center gap-2 mt-10 [&_a]:inline-flex [&_a]:items-center [&_a]:justify-center [&_a]:size-10 [&_a]:rounded-[2px] [&_a]:border [&_a]:border-[#19121e] [&_a]:font-poppins [&_a]:text-sm [&_a]:text-[#19121e] [&_a]:hover:bg-black/5 [&_a]:transition-colors [&_span]:inline-flex [&_span]:items-center [&_span]:justify-center [&_span]:size-10 [&_span]:rounded-[2px] [&_span]:font-poppins [&_span]:text-sm [&_.current]:bg-[#19121e] [&_.current]:text-white [&_.current]:border [&_.current]:border-[#19121e] [&_.dots]:text-[#19121e]/50">' . $rendered . '</ul>';
    }
}
