<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceDescBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-desc',
    ];

    public function with(): array
    {
        $label = \get_field('desc_label') ?: '';
        $content = \get_field('desc_content') ?: '';

        return [
            'label' => $label,
            'content' => $content,
        ];
    }
}
