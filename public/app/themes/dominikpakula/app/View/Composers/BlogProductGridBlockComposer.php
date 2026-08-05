<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogProductGridBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-product-grid',
    ];

    public function with(): array
    {
        return [
            'heading' => \get_field('products_heading') ?: '',
            'headingTag' => \get_field('products_heading_level') === 'h3' ? 'h3' : 'h2',
            'text' => $this->text(),
            'alignClass' => \get_field('products_text_align') === 'left' ? 'text-left' : 'text-center',
            'items' => $this->items(),
        ];
    }

    /**
     * Wstęp z WYSIWYG — wiele akapitów jest tu normą, odstępy robi `space-y` w widoku.
     */
    private function text(): string
    {
        $text = \get_field('products_text');

        return $text ? wp_kses_post($text) : '';
    }

    /**
     * Repeater `products_items`. Pozycja bez zdjęcia jest pomijana — pusty wiersz
     * w panelu nie może wywalić siatki.
     */
    private function items(): array
    {
        $rows = \get_field('products_items');

        if (! is_array($rows)) {
            return [];
        }

        $out = [];

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $image = $row['product_image'] ?? null;

            if (! is_array($image)) {
                continue;
            }

            $url = $image['sizes']['large'] ?? $image['url'] ?? '';

            if (! $url) {
                continue;
            }

            $out[] = [
                'src' => $url,
                'alt' => $image['alt'] ?? '',
                'width' => $image['sizes']['large-width'] ?? $image['width'] ?? null,
                'height' => $image['sizes']['large-height'] ?? $image['height'] ?? null,
                'name' => $row['product_name'] ?? '',
                'url' => $row['product_url'] ?? '',
            ];
        }

        return $out;
    }
}
