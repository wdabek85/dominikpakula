<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ContactChannelsBlockComposer extends Composer
{
    protected static $views = [
        'blocks.contact-channels',
    ];

    public function with(): array
    {
        return [
            'channelsHeading' => \get_field('channels_heading') ?: 'Wybierz wygodny kanał',
            'channelsSubtitle' => \get_field('channels_subtitle') ?: 'Każda wiadomość trafia bezpośrednio do mnie. Wybierz to, co dla Ciebie najwygodniejsze.',
        ];
    }
}
