<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PageHeaderBlockComposer extends Composer
{
    protected static $views = [
        'blocks.page-header',
    ];

    public function with(): array
    {
        return [
            'breadcrumb' => \get_field('page_header_breadcrumb') ?: '',
            'headerTitle' => \get_field('page_header_title') ?: '',
            'headerDescription' => \get_field('page_header_description') ?: '',
        ];
    }
}
