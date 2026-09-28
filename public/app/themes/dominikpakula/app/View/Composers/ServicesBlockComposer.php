<?php

namespace App\View\Composers;

use App\Services\ServiceCatalog;
use Roots\Acorn\View\Composer;

class ServicesBlockComposer extends Composer
{
    protected static $views = [
        'blocks.services.index',
    ];

    public function with(): array
    {
        return [
            'title' => wp_kses_post(\get_field('services_title') ?: ''),
            'subtitle' => \get_field('services_subtitle') ?: '',
            'highlightImage' => \get_field('services_highlight_image'),
            'highlightTitle' => \get_field('services_highlight_title') ?: '',
            'highlightDescription' => \get_field('services_highlight_description') ?: '',
            'cards' => $this->cards(),
        ];
    }

    protected function cards(): array
    {
        $source = \get_field('services_source') ?: 'manual';

        if ($source === 'manual') {
            return $this->manualCards();
        }

        $ids = $source === 'pick' ? (\get_field('services_items') ?: []) : ServiceCatalog::topLevelIds();

        return array_map(fn (array $service) => [
            'name' => $service['title'],
            'problem' => $service['problem'],
            'icon' => $service['icon'],
            'description' => $service['excerpt'],
            'linkText' => 'Dowiedz się więcej',
            'linkUrl' => $service['url'],
        ], ServiceCatalog::cards($ids));
    }

    /**
     * Stary tryb: karty wpisane ręcznie w bloku.
     */
    protected function manualCards(): array
    {
        $cards = [];

        foreach (\get_field('services_cards') ?: [] as $card) {
            $cards[] = [
                'name' => $card['services_card_name'] ?? '',
                'problem' => $card['services_card_problem'] ?? '',
                'icon' => $card['services_card_icon'] ?? null,
                'description' => $card['services_card_description'] ?? '',
                'linkText' => $card['services_card_link_text'] ?? 'Dowiedz się więcej',
                'linkUrl' => $card['services_card_link_url'] ?? '',
            ];
        }

        return $cards;
    }
}
