<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class HeroComposer extends Composer
{
    protected static $views = [
        'blocks.hero',
    ];

    public function with(): array
    {
        return [
            'heroTitle' => \get_field('hero_title') ?: '',
            'heroDescription' => \get_field('hero_description') ?: '',
            'heroButtonText' => \get_field('hero_button_text') ?: '',
            'heroButtonUrl' => \get_field('hero_button_url') ?: '',
            'heroImage' => \get_field('hero_image'),
            'heroCardImage' => \get_field('hero_card_image'),
            'heroCardTitle' => \get_field('hero_card_title') ?: '',
            'heroCardLinkText' => \get_field('hero_card_link_text') ?: '',
            'heroCardLinkUrl' => \get_field('hero_card_link_url') ?: '',
        ];
    }
}
