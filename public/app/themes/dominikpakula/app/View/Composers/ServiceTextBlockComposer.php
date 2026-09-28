<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceTextBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-text',
    ];

    public function with(): array
    {
        $buttonText = \get_field('stext_button_text') ?: '';
        $buttonUrl = \get_field('stext_button_url') ?: '';

        return [
            'label' => \get_field('stext_label') ?: '',
            'heading' => \get_field('stext_heading') ?: '',
            'body' => \wp_kses_post(\get_field('stext_body') ?: ''),
            'imageHtml' => $this->imageHtml(),
            'buttonText' => $buttonText,
            'buttonUrl' => $buttonUrl,
            // Bez linku przycisk otwiera modal rezerwacji z zaznaczoną bieżącą usługą.
            'bookingService' => $buttonText && ! $buttonUrl ? $this->serviceName() : '',
            'attached' => (bool) \get_field('stext_attached'),
        ];
    }

    /**
     * <img> z srcset/sizes/width/height (wp_get_attachment_image), lazy — blok nigdy nie jest above the fold.
     */
    protected function imageHtml(): string
    {
        $imageId = (int) \get_field('stext_image');

        if (! $imageId) {
            return '';
        }

        $alt = \get_post_meta($imageId, '_wp_attachment_image_alt', true) ?: '';

        return \wp_get_attachment_image($imageId, 'medium_large', false, [
            'class' => 'size-full object-cover',
            'alt' => $alt,
            'loading' => 'lazy',
            'sizes' => '(min-width: 1024px) 260px, 100vw',
        ]) ?: '';
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
