<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogHeadingImageBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-heading-image',
    ];

    public function with(): array
    {
        return [
            'heading' => \get_field('hi_heading') ?: '',
            'headingTag' => \get_field('hi_heading_level') === 'h3' ? 'h3' : 'h2',
            'alignClass' => \get_field('hi_heading_align') === 'left' ? 'text-left' : 'text-center',
            'caption' => \get_field('hi_caption') ?: '',
            'image' => $this->image(),
        ];
    }

    private function image(): array
    {
        $image = \get_field('hi_image');

        if (! is_array($image)) {
            return ['url' => '', 'alt' => '', 'width' => null, 'height' => null];
        }

        return [
            'url' => $image['sizes']['large'] ?? $image['url'] ?? '',
            'alt' => $image['alt'] ?? '',
            'width' => $image['sizes']['large-width'] ?? $image['width'] ?? null,
            'height' => $image['sizes']['large-height'] ?? $image['height'] ?? null,
        ];
    }
}
