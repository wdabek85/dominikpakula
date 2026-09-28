<?php

namespace App\View\Composers;

use App\Services\ServiceCatalog;
use Roots\Acorn\View\Composer;

class LocalSeoBlockComposer extends Composer
{
    protected static $views = [
        'blocks.local-seo',
    ];

    public function with(): array
    {
        return [
            'eyebrow' => \get_field('local_eyebrow') ?: 'Okolica',
            'heading' => \get_field('local_heading') ?: 'Zakupy ze stylistą w Twoim mieście',
            'items' => \get_field('local_source') === 'children' ? $this->childItems() : $this->manualItems(),
        ];
    }

    /**
     * Podstrony bieżącej usługi (np. miasta) — tytuł, zdjęcie wyróżniające, permalink.
     */
    protected function childItems(): array
    {
        $items = [];

        foreach (ServiceCatalog::childIds((int) \get_the_ID()) as $id) {
            $thumbId = (int) \get_post_thumbnail_id($id);
            $image = $thumbId ? \wp_get_attachment_image_src($thumbId, 'medium_large') : null;

            $items[] = [
                'title' => \get_the_title($id),
                'url' => \get_permalink($id),
                'image' => $image ? [
                    'url' => $image[0],
                    'width' => $image[1],
                    'height' => $image[2],
                    'alt' => \get_post_meta($thumbId, '_wp_attachment_image_alt', true) ?: '',
                ] : null,
            ];
        }

        return $items;
    }

    /**
     * Stary tryb: pozycje repeatera — tylko kompletne (tytuł + URL).
     */
    protected function manualItems(): array
    {
        $rows = \get_field('local_items');

        if (! $rows || ! is_array($rows)) {
            return [];
        }

        $items = [];

        foreach ($rows as $row) {
            $title = $row['title'] ?? '';
            $url = $row['url'] ?? '';

            if (! $title || ! $url) {
                continue;
            }

            $items[] = [
                'title' => $title,
                'url' => $url,
                'image' => is_array($row['image'] ?? null) ? $row['image'] : null,
            ];
        }

        return $items;
    }
}
