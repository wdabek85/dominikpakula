<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class PersonalIntroBlockComposer extends Composer
{
    protected static $views = [
        'blocks.personal-intro',
    ];

    public function with(): array
    {
        return [
            'introImage' => \get_field('intro_image') ?: null,
            'introHeading' => \get_field('intro_heading') ?: 'Cześć, jestem Dominik',
            'introText' => \get_field('intro_text') ?: 'Pisz do mnie bez krępacji — żadnych głupich pytań nie ma. Każdą wiadomość czytam osobiście i zwykle odpowiadam w ciągu 24 godzin.',
            'introBadge' => \get_field('intro_badge') ?: 'Odpowiadam w 24h',
        ];
    }
}
