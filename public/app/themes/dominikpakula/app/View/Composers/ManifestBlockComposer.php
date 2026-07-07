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
        $avatar = \get_field('manifest_avatar');
        $image = \get_field('manifest_image');

        return [
            'text' => \get_field('manifest_text') ?: '',
            'label' => \get_field('manifest_label') ?: '',
            'avatar' => is_array($avatar) ? ($avatar['url'] ?? '') : '',
            'avatarAlt' => is_array($avatar) ? ($avatar['alt'] ?? '') : '',
            'image' => is_array($image) ? ($image['url'] ?? '') : '',
            'imageAlt' => is_array($image) ? ($image['alt'] ?? '') : '',
        ];
    }
}
