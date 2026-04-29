<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SinglePortfolioComposer extends Composer
{
    protected static $views = [
        'single-portfolio',
    ];

    public function with(): array
    {
        return [
            'category' => \get_field('portfolio_category') ?: '',
            'intro' => \get_field('portfolio_intro') ?: '',
            'gallery' => $this->gallery(),
        ];
    }

    protected function gallery(): array
    {
        $items = \get_field('portfolio_gallery') ?: [];

        if (! is_array($items)) {
            return [];
        }

        $out = [];
        foreach ($items as $item) {
            // ACF Gallery field returns array of image arrays
            if (! is_array($item)) {
                continue;
            }

            $url = $item['sizes']['large'] ?? $item['url'] ?? '';
            if (! $url) {
                continue;
            }

            $out[] = [
                'url' => $url,
                'fullUrl' => $item['url'] ?? $url,
                'alt' => $item['alt'] ?? '',
                'caption' => $item['caption'] ?? '',
                'width' => $item['sizes']['large-width'] ?? $item['width'] ?? null,
                'height' => $item['sizes']['large-height'] ?? $item['height'] ?? null,
            ];
        }

        return $out;
    }
}
