<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class AboutModalComposer extends Composer
{
    protected static $views = [
        'partials.about-modal',
    ];

    public function with(): array
    {
        $settings = \function_exists('App\\AboutModal\\settings')
            ? \App\AboutModal\settings()
            : [];

        $linkUrl = $settings['link_url'] ?? '/o-mnie/';
        if ($linkUrl && str_starts_with($linkUrl, '/')) {
            $linkUrl = \home_url($linkUrl);
        }

        return [
            'aboutHeading' => $settings['heading'] ?? 'Kilka słów o mnie',
            'aboutBody' => \wpautop($settings['body'] ?? ''),
            'aboutLinkLabel' => $settings['link_label'] ?? 'Poznaj całą moją historię',
            'aboutLinkUrl' => $linkUrl ?: \home_url('/o-mnie/'),
        ];
    }
}
