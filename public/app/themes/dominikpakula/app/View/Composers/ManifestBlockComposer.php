<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ManifestBlockComposer extends Composer
{
    protected static $views = [
        'blocks.manifest',
    ];

    public function with(): array
    {
        $image = \get_field('manifest_image');

        return [
            'text' => \get_field('manifest_text') ?: '',
            'image' => is_array($image) ? ($image['url'] ?? '') : '',
            'imageAlt' => is_array($image) ? ($image['alt'] ?? '') : '',
        ];
    }
}
