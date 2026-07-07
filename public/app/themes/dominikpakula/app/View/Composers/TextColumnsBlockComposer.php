<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class TextColumnsBlockComposer extends Composer
{
    protected static $views = [
        'blocks.text-columns',
    ];

    public function with(): array
    {
        return [
            'heading' => \get_field('textcol_heading') ?: '',
            'body' => \wpautop(\get_field('textcol_body') ?: ''),
        ];
    }
}
