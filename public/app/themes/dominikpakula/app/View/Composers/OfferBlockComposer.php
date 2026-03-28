<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class OfferBlockComposer extends Composer
{
    protected static $views = [
        'blocks.offer.index',
    ];

    public function with(): array
    {
        $cards = [];
        $rawCards = \get_field('offer_cards') ?: [];

        foreach ($rawCards as $card) {
            $cards[] = [
                'title' => $card['offer_card_title'] ?? '',
                'icon' => $card['offer_card_icon'] ?? null,
                'description' => $card['offer_card_description'] ?? '',
                'price' => $card['offer_card_price'] ?? '',
                'linkText' => $card['offer_card_link_text'] ?? 'Sprawdź szczegóły',
                'linkUrl' => $card['offer_card_link_url'] ?? '#',
            ];
        }

        return [
            'label' => \get_field('offer_label') ?: '',
            'title' => \get_field('offer_title') ?: '',
            'cards' => $cards,
            'buttonText' => \get_field('offer_button_text') ?: '',
            'buttonUrl' => \get_field('offer_button_url') ?: '#',
        ];
    }
}
