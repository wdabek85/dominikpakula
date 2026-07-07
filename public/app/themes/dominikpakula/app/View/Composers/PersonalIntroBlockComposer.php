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
            'introImage' => \get_field('intro_image') ?: $this->fallbackImage(),
            'introHeading' => \get_field('intro_heading') ?: 'Cześć, jestem Dominik',
            'introText' => \get_field('intro_text') ?: 'Pisz do mnie bez krępacji — żadnych głupich pytań nie ma. Każdą wiadomość czytam osobiście i zwykle odpowiadam w ciągu 24 godzin.',
            'introBadge' => \get_field('intro_badge') ?: 'Odpowiadam w 24h',
        ];
    }

    /**
     * Fallback portret, dopóki nie powstanie pole ACF `intro_image` dla bloku.
     * Załącznik "portret dominik" (staging ID 42). Zwraca null jeśli brak — blok pokaże inicjały „DP".
     */
    protected function fallbackImage(): ?array
    {
        $attachmentId = 42;
        $url = \wp_get_attachment_image_url($attachmentId, 'large');

        if (! $url) {
            return null;
        }

        return [
            'url' => $url,
            'alt' => \get_post_meta($attachmentId, '_wp_attachment_image_alt', true) ?: 'Dominik Pakuła',
        ];
    }
}
