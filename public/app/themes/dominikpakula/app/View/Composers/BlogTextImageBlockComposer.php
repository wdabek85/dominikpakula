<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogTextImageBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-text-image',
    ];

    public function with(): array
    {
        return [
            'heading' => \get_field('ti_heading') ?: '',
            'headingTag' => $this->headingTag(),
            'text' => $this->text(),
            'image' => $this->normalizeImage(\get_field('ti_image')),
            'imageFirst' => \get_field('ti_image_position') === 'left',
            'alignClass' => \get_field('ti_text_align') === 'center' ? 'text-center' : 'text-left',
            'imageSizeClass' => $this->imageSizeClass(),
        ];
    }

    /**
     * Limit wysokości zdjęcia. Bez niego pionowe grafiki (np. plansze 1:2) rozpychają
     * sekcję na kilkaset pikseli i zjadają layout.
     */
    private function imageSizeClass(): string
    {
        return match (\get_field('ti_image_size')) {
            'small' => 'max-h-[380px]',
            'large' => 'max-h-[720px]',
            'full' => '',
            default => 'max-h-[560px]',
        };
    }

    /**
     * Poziom nagłówka. Tylko h2/h3 — spis treści (Blog\Filters::add_heading_ids)
     * indeksuje wyłącznie te dwa poziomy.
     */
    private function headingTag(): string
    {
        return \get_field('ti_heading_level') === 'h3' ? 'h3' : 'h2';
    }

    /**
     * Treść z WYSIWYG. wp_kses_post ucina niedozwolone tagi, akapity zostają —
     * odstępy między nimi robi `space-y` na wrapperze w widoku.
     */
    private function text(): string
    {
        $text = \get_field('ti_text');

        return $text ? wp_kses_post($text) : '';
    }

    private function normalizeImage($image): array
    {
        if (! is_array($image)) {
            return ['url' => '', 'alt' => '', 'width' => null, 'height' => null];
        }

        return [
            'url' => $image['url'] ?? '',
            'alt' => $image['alt'] ?? '',
            'width' => $image['width'] ?? null,
            'height' => $image['height'] ?? null,
        ];
    }
}
