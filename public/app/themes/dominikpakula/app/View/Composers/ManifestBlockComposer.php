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
            'eyebrow' => \get_field('manifest_eyebrow') ?: '',
            'text' => \get_field('manifest_text') ?: '',
            'attribution' => \get_field('manifest_attribution') ?: '',
            'role' => \get_field('manifest_role') ?: '',
            'image' => is_array($image) ? ($image['url'] ?? '') : '',
            'imageAlt' => is_array($image) ? ($image['alt'] ?? '') : '',
            'body' => \wpautop(\get_field('manifest_body') ?: ''),
        ];
    }
}
