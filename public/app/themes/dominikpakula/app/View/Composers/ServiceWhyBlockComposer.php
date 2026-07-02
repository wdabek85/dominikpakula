<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceWhyBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-why',
    ];

    public function with(): array
    {
        $label = \get_field('why_label') ?: '';
        $title = \get_field('why_title') ?: '';
        $description = wp_kses_post(\get_field('why_description') ?: '');

        $benefitsRaw = \get_field('why_benefits') ?: [];
        $benefits = [];

        foreach ($benefitsRaw as $item) {
            $icon = $item['why_benefit_icon'] ?? null;
            $benefits[] = [
                'icon' => $icon ? ($icon['url'] ?? '') : '',
                'iconAlt' => $icon ? ($icon['alt'] ?? '') : '',
                'title' => $item['why_benefit_title'] ?? '',
                'description' => $item['why_benefit_description'] ?? '',
            ];
        }

        $imageField = \get_field('why_image');
        if (is_array($imageField)) {
            $image = $imageField['url'] ?? '';
            $imageAlt = $imageField['alt'] ?? '';
        } elseif (is_numeric($imageField)) {
            $image = wp_get_attachment_image_url($imageField, 'medium_large') ?: '';
            $imageAlt = get_post_meta($imageField, '_wp_attachment_image_alt', true) ?: '';
        } else {
            $image = '';
            $imageAlt = '';
        }
        $imageCaption = \get_field('why_image_caption') ?: '';

        return [
            'label' => $label,
            'title' => $title,
            'description' => $description,
            'benefits' => $benefits,
            'image' => $image,
            'imageAlt' => $imageAlt,
            'imageCaption' => $imageCaption,
        ];
    }
}
