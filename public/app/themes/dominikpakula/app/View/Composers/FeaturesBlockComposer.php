<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class FeaturesBlockComposer extends Composer
{
    protected static $views = [
        'blocks.features',
    ];

    public function with(): array
    {
        $title = \get_field('features_title') ?: '';
        $description = \get_field('features_description') ?: '';

        $cardsRaw = \get_field('features_cards') ?: [];
        $cards = [];

        foreach ($cardsRaw as $item) {
            $icon = $item['features_card_icon'] ?? null;
            $cards[] = [
                'icon' => is_array($icon) ? ($icon['url'] ?? '') : '',
                'iconAlt' => is_array($icon) ? ($icon['alt'] ?? '') : '',
                'title' => $item['features_card_title'] ?? '',
                'description' => $item['features_card_description'] ?? '',
            ];
        }

        return [
            'title' => $title,
            'description' => $description,
            'cards' => $cards,
        ];
    }
}
