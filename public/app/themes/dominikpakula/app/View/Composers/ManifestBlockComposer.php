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
        return [
            'eyebrow' => \get_field('manifest_eyebrow') ?: '',
            'text' => \get_field('manifest_text') ?: '',
            'attribution' => \get_field('manifest_attribution') ?: '',
        ];
    }
}
