<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceTrustBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-trust',
    ];

    public function with(): array
    {
        $leftImage = \get_field('trust_left_image');
        $rightImage = \get_field('trust_right_image');

        return [
            'leftImage' => $this->normalizeImage($leftImage),
            'leftText' => \get_field('trust_left_text') ?: '',
            'rightImage' => $this->normalizeImage($rightImage),
            'rightText' => \get_field('trust_right_text') ?: '',
        ];
    }

    private function normalizeImage($image): array
    {
        if (! is_array($image)) {
            return ['url' => '', 'alt' => '', 'width' => null, 'height' => null];
        }

        return [
            'url' => $image['url'] ?? '',
            'alt' => $image['alt'] ?? '',
            'width' => $image['width'] ?? null,
            'height' => $image['height'] ?? null,
        ];
    }
}
