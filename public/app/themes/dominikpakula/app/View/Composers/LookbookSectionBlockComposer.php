<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LookbookSectionBlockComposer extends Composer
{
    protected static $views = [
        'blocks.lookbook-section',
    ];

    public function with(): array
    {
        $layout = \get_field('lookbook_layout') ?: 'grid-3';

        // Aliasy nazewnicze — `grid-5` (1+4=5 itemów) === `split` (1 duże + 2x2)
        $aliases = [
            'grid-5' => 'split',
        ];
        $layout = $aliases[$layout] ?? $layout;

        if (! in_array($layout, ['grid-3', 'grid-4', 'split'], true)) {
            $layout = 'grid-3';
        }

        return [
            'title' => \get_field('lookbook_title') ?: '',
            'description' => \get_field('lookbook_description') ?: '',
            'layout' => $layout,
            'items' => $this->items(),
        ];
    }

    protected function items(): array
    {
        $rows = \get_field('lookbook_items') ?: [];

        if (! is_array($rows)) {
            return [];
        }

        $out = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $image = $row['item_image'] ?? null;
            if (! is_array($image)) {
                continue;
            }

            $url = $image['sizes']['large'] ?? $image['url'] ?? '';
            if (! $url) {
                continue;
            }

            $type = $row['item_type'] ?? 'product';
            if (! in_array($type, ['model', 'product'], true)) {
                $type = 'product';
            }

            $out[] = [
                'src' => $url,
                'fullSrc' => $image['url'] ?? $url,
                'alt' => $image['alt'] ?? '',
                'width' => $image['sizes']['large-width'] ?? $image['width'] ?? null,
                'height' => $image['sizes']['large-height'] ?? $image['height'] ?? null,
                'brand' => $row['item_brand'] ?? '',
                'shopUrl' => $row['item_url'] ?? '',
                'type' => $type,
            ];
        }

        return $out;
    }
}
