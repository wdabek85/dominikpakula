<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class BlogArchiveBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-archive',
    ];

    public function with(): array
    {
        $perPage = 9;

        $currentCategory = isset($_GET['category']) ? sanitize_title(wp_unslash($_GET['category'])) : '';
        $currentSeason = isset($_GET['season']) ? sanitize_title(wp_unslash($_GET['season'])) : '';
        $paged = max(1, (int) (get_query_var('paged') ?: ($_GET['paged'] ?? 1)));

        $taxQuery = ['relation' => 'AND'];
        if ($currentCategory !== '') {
            $taxQuery[] = [
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $currentCategory,
            ];
        }
        if ($currentSeason !== '') {
            $taxQuery[] = [
                'taxonomy' => 'season',
                'field' => 'slug',
                'terms' => $currentSeason,
            ];
        }

        $query = new WP_Query([
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $perPage,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
            'tax_query' => count($taxQuery) > 1 ? $taxQuery : [],
        ]);

        $items = [];
        if ($query->have_posts()) {
            $ids = wp_list_pluck($query->posts, 'ID');
            update_post_thumbnail_cache($query);
            update_meta_cache('post', $ids);

            foreach ($query->posts as $post) {
                $authorId = (int) $post->post_author;
                $primaryCategory = $this->primaryTerm($post->ID, 'category');

                $items[] = [
                    'title' => get_the_title($post->ID),
                    'excerpt' => wp_trim_words(get_the_excerpt($post), 28, '…'),
                    'date' => get_the_date('j F Y', $post->ID),
                    'url' => get_permalink($post->ID),
                    'image' => get_the_post_thumbnail_url($post->ID, 'medium_large') ?: '',
                    'category' => $primaryCategory,
                    'author' => get_the_author_meta('display_name', $authorId),
                    'authorAvatar' => get_avatar_url($authorId, ['size' => 80]) ?: '',
                    'authorRole' => \get_field('author_role', 'user_' . $authorId) ?: '',
                ];
            }
        }
        wp_reset_postdata();

        return [
            'posts' => $items,
            'categories' => $this->terms('category'),
            'seasons' => $this->terms('season'),
            'currentCategory' => $currentCategory,
            'currentSeason' => $currentSeason,
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

    protected function primaryTerm(int $postId, string $taxonomy): string
    {
        $terms = get_the_terms($postId, $taxonomy);
        if (is_wp_error($terms) || ! $terms) {
            return '';
        }

        // Pomiń "bez kategorii" jeśli istnieją inne
        $real = array_values(array_filter($terms, fn ($t) => $t->slug !== 'bez-kategorii' && $t->slug !== 'uncategorized'));
        $pick = $real[0] ?? $terms[0];

        return $pick->name ?? '';
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
