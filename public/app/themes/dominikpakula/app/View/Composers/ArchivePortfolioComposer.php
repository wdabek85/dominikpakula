<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class ArchivePortfolioComposer extends Composer
{
    protected static $views = [
        'archive-portfolio',
    ];

    public function with(): array
    {
        $perPage = 12;
        $paged = max(1, (int) (get_query_var('paged') ?: ($_GET['paged'] ?? 1)));

        $query = new WP_Query([
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'posts_per_page' => $perPage,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        $items = [];
        if ($query->have_posts()) {
            $ids = wp_list_pluck($query->posts, 'ID');
            update_post_thumbnail_cache($query);
            update_meta_cache('post', $ids);

            foreach ($query->posts as $post) {
                $thumbId = \get_post_thumbnail_id($post->ID);
                $items[] = [
                    'title' => get_the_title($post->ID),
                    'category' => \get_field('portfolio_category', $post->ID) ?: '',
                    'image' => $thumbId ? (wp_get_attachment_image_url($thumbId, 'large') ?: '') : '',
                    'link' => get_permalink($post->ID),
                ];
            }
        }
        wp_reset_postdata();

        return [
            'items' => $items,
            'paginationHtml' => $this->paginationHtml($query, $paged),
        ];
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
