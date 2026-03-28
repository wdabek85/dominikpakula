<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServicesBlockComposer extends Composer
{
    protected static $views = [
        'blocks.services.index',
    ];

    public function with(): array
    {
        $cards = [];
        $rawCards = \get_field('services_cards') ?: [];

        foreach ($rawCards as $card) {
            $cards[] = [
                'name' => $card['services_card_name'] ?? '',
                'problem' => $card['services_card_problem'] ?? '',
                'icon' => $card['services_card_icon'] ?? null,
                'description' => $card['services_card_description'] ?? '',
                'linkText' => $card['services_card_link_text'] ?? 'Dowiedz się więcej',
                'linkUrl' => $card['services_card_link_url'] ?? '#',
            ];
        }

        return [
            'title' => \get_field('services_title') ?: '',
            'subtitle' => \get_field('services_subtitle') ?: '',
            'highlightImage' => \get_field('services_highlight_image'),
            'highlightTitle' => \get_field('services_highlight_title') ?: '',
            'highlightDescription' => \get_field('services_highlight_description') ?: '',
            'cards' => $cards,
        ];
    }
}
