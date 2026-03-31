<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class SubpageHeroBlockComposer extends Composer
{
    protected static $views = [
        'blocks.subpage-hero',
    ];

    public function with(): array
    {
        $breadcrumb = \get_field('subpage_hero_breadcrumb') ?: '';
        $title = \get_field('subpage_hero_title') ?: '';
        $description = \get_field('subpage_hero_description') ?: '';

        $imageLeft = \get_field('subpage_hero_image_left');
        $imageRight = \get_field('subpage_hero_image_right');

        return [
            'breadcrumb' => $breadcrumb,
            'title' => $title,
            'description' => $description,
            'imageLeft' => is_array($imageLeft) ? ($imageLeft['url'] ?? '') : '',
            'imageLeftAlt' => is_array($imageLeft) ? ($imageLeft['alt'] ?? '') : '',
            'captionLeft' => \get_field('subpage_hero_caption_left') ?: '',
            'imageRight' => is_array($imageRight) ? ($imageRight['url'] ?? '') : '',
            'imageRightAlt' => is_array($imageRight) ? ($imageRight['alt'] ?? '') : '',
            'captionRight' => \get_field('subpage_hero_caption_right') ?: '',
        ];
    }
}
