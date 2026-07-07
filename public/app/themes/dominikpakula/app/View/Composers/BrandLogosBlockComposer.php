<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BrandLogosBlockComposer extends Composer
{
    protected static $views = [
        'blocks.brand-logos',
    ];

    public function with(): array
    {
        return [
            'eyebrow' => \get_field('logos_eyebrow') ?: '',
            'heading' => \get_field('logos_heading') ?: '',
            'lead' => \get_field('logos_lead') ?: '',
            'logos' => $this->logos(),
        ];
    }

    /**
     * Logotypy — tylko pozycje z obrazkiem.
     */
    protected function logos(): array
    {
        $rows = \get_field('logos_items');

        if (! $rows || ! is_array($rows)) {
            return [];
        }

        $logos = [];

        foreach ($rows as $row) {
            $logo = $row['logo'] ?? null;

            if (! is_array($logo) || empty($logo['url'])) {
                continue;
            }

            $logos[] = [
                'url' => $logo['url'],
                'alt' => $logo['alt'] ?: ($row['name'] ?? ''),
                'name' => $row['name'] ?? '',
                'width' => $logo['width'] ?? null,
                'height' => $logo['height'] ?? null,
                'link' => $row['url'] ?? '',
            ];
        }

        return $logos;
    }
}
