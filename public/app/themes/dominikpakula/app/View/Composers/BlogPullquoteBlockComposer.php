<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogPullquoteBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-pullquote',
    ];

    public function with(): array
    {
        return [
            'text' => \get_field('pullquote_text') ?: 'Najważniejsza zasada w garderobie: mniej znaczy więcej, jeśli mniej jest dobrze dobrane.',
            'attribution' => \get_field('pullquote_attribution') ?: '',
        ];
    }
}
