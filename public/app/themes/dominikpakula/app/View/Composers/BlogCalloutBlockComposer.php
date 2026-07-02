<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogCalloutBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-callout',
    ];

    public function with(): array
    {
        $type = \get_field('callout_type') ?: 'tip';
        if (! in_array($type, ['tip', 'info', 'warning'], true)) {
            $type = 'tip';
        }

        return [
            'type' => $type,
            'title' => \get_field('callout_title') ?: $this->defaultTitle($type),
            'text' => \get_field('callout_text') ?: '',
        ];
    }

    protected function defaultTitle(string $type): string
    {
        return match ($type) {
            'tip' => 'Pro tip',
            'info' => 'Warto wiedzieć',
            'warning' => 'Uważaj',
            default => '',
        };
    }
}
