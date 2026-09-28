<?php
/**
 * Wspólny zapis podstrony miasta pod „Zakupy ze stylistą” — post, sidebar, zdjęcie, Rank Math.
 * Skrypt miasta buduje tylko bloki treści (mig_block) i woła mig_city_page().
 * Idempotentne: tworzy albo nadpisuje; przed nadpisaniem treści robi backup do <bedrock>/sql/backup.
 */

require_once __DIR__ . '/blocks.php';

if (! function_exists('mig_city_page')) {
    function mig_city_parent(): WP_Post
    {
        $parent = get_page_by_path('zakupy-ze-stylista', OBJECT, 'service');
        if (! $parent) {
            WP_CLI::error('Brak usługi-rodzica zakupy-ze-stylista.');
        }
        return $parent;
    }

    function mig_link(string $path, string $text): string
    {
        return sprintf('<a href="%s">%s</a>', esc_url(home_url($path)), $text);
    }

    /**
     * $city: slug, title, order, sidebar_title, sidebar_description, hero_caption,
     *        included_heading, included (string[]), rank_title, rank_description, rank_keywords,
     *        image (opcjonalnie: plik w migrations/assets + image_alt)
     */
    function mig_city_page(array $city, array $blocks): int
    {
        $parent = mig_city_parent();
        $existing = get_page_by_path('zakupy-ze-stylista/' . $city['slug'], OBJECT, 'service');
        $postarr = [
            'post_type' => 'service',
            'post_status' => 'publish',
            'post_title' => $city['title'],
            'post_name' => $city['slug'],
            'post_parent' => $parent->ID,
            'menu_order' => $city['order'],
            'post_content' => implode("\n\n", $blocks),
        ];

        if ($existing) {
            $postarr['ID'] = $existing->ID;
            if ($existing->post_content !== $postarr['post_content']) {
                $dir = dirname(ABSPATH, 2) . '/sql/backup';
                wp_mkdir_p($dir);
                file_put_contents("{$dir}/post-{$existing->ID}-{$city['slug']}-" . date('Ymd-His') . '.html', $existing->post_content);
            }
        }

        // wp_slash — inaczej wp_insert_post zje backslashe z JSON-a bloków
        $postId = wp_insert_post(wp_slash($postarr), true);
        if (is_wp_error($postId)) {
            WP_CLI::error($postId->get_error_message());
        }

        update_field('service_sidebar_title', $city['sidebar_title'], $postId);
        update_field('service_sidebar_description', $city['sidebar_description'], $postId);
        update_field('service_price', '1800 zł', $postId);
        update_field('service_hero_caption', $city['hero_caption'], $postId);
        if (! get_field('service_hero_icon', $postId) && ($icon = get_field('service_hero_icon', $parent->ID))) {
            update_field('service_hero_icon', is_array($icon) ? $icon['ID'] : $icon, $postId);
        }
        update_field('service_included_heading', $city['included_heading'], $postId);
        update_field('service_included_items', array_map(fn ($t) => ['service_included_item' => $t], $city['included']), $postId);

        mig_city_image($postId, $parent, $city['image'] ?? null, $city['image_alt'] ?? '');

        update_post_meta($postId, 'rank_math_title', $city['rank_title']);
        update_post_meta($postId, 'rank_math_description', $city['rank_description']);
        update_post_meta($postId, 'rank_math_focus_keyword', $city['rank_keywords']);

        WP_CLI::success(sprintf('%s: ID %d, %s', $city['title'], $postId, get_permalink($postId)));

        return $postId;
    }

    /**
     * Zdjęcie wyróżniające: plik z migrations/assets (import raz do biblioteki) albo — gdy brak —
     * zdjęcie usługi-rodzica. Nie nadpisuje zdjęcia ustawionego ręcznie w panelu.
     */
    function mig_city_image(int $postId, WP_Post $parent, ?string $file, string $alt): void
    {
        global $wpdb;
        $parentThumb = (int) get_post_thumbnail_id($parent->ID);
        $current = (int) get_post_thumbnail_id($postId);
        $imageId = 0;

        if ($file) {
            $imageId = (int) $wpdb->get_var($wpdb->prepare(
                "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s ORDER BY post_id LIMIT 1",
                '%/' . $wpdb->esc_like($file)
            ));
            if (! $imageId) {
                require_once ABSPATH . 'wp-admin/includes/media.php';
                require_once ABSPATH . 'wp-admin/includes/file.php';
                require_once ABSPATH . 'wp-admin/includes/image.php';
                $tmp = wp_tempnam($file);
                copy(dirname(__DIR__) . '/assets/' . $file, $tmp);
                $imageId = media_handle_sideload(['name' => $file, 'tmp_name' => $tmp], 0, get_the_title($postId));
                if (is_wp_error($imageId)) {
                    WP_CLI::error('Import zdjęcia: ' . $imageId->get_error_message());
                }
                update_post_meta($imageId, '_wp_attachment_image_alt', $alt);
                WP_CLI::log("Zaimportowano zdjęcie {$file} (ID {$imageId})");
            }
        }

        if (! $current || ($imageId && $current === $parentThumb)) {
            set_post_thumbnail($postId, $imageId ?: $parentThumb);
        }
    }
}
