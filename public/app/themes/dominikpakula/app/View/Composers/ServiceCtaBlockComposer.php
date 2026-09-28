<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceCtaBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-cta',
    ];

    public function with(): array
    {
        $secondaryText = \get_field('scta_secondary_text') ?: '';
        $secondaryUrl = \get_field('scta_secondary_url') ?: '';

        return [
            'eyebrow' => \get_field('scta_eyebrow') ?: '',
            'heading' => \get_field('scta_heading') ?: 'Porozmawiajmy o Twojej garderobie',
            'text' => \get_field('scta_text') ?: '',
            'buttonText' => \get_field('scta_button_text') ?: 'Umów bezpłatną rozmowę',
            'service' => \get_field('scta_service') ?: $this->serviceName(),
            // Drugi przycisk tylko w komplecie — bez linku nie ma „przycisku donikąd”.
            'secondaryText' => $secondaryText && $secondaryUrl ? $secondaryText : '',
            'secondaryUrl' => $secondaryText && $secondaryUrl ? $secondaryUrl : '',
        ];
    }

    protected function serviceName(): string
    {
        $postId = \get_the_ID();

        if (! $postId || \get_post_type($postId) !== 'service') {
            return '';
        }

        return \get_field('service_sidebar_title', $postId) ?: \get_the_title($postId);
    }
}
