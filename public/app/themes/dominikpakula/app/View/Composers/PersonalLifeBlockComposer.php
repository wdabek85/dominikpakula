<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PersonalLifeBlockComposer extends Composer
{
    protected static $views = [
        'blocks.personal-life',
    ];

    public function with(): array
    {
        $image = \get_field('pl_image');

        return [
            'heading' => \get_field('pl_heading') ?: '',
            'body' => \wpautop(\get_field('pl_body') ?: ''),
            'image' => is_array($image) ? ($image['url'] ?? '') : '',
            'imageAlt' => is_array($image) ? ($image['alt'] ?? '') : '',
        ];
    }
}
