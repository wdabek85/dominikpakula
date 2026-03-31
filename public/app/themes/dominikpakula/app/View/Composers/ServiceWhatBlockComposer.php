<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceWhatBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-what',
    ];

    public function with(): array
    {
        $label = \get_field('what_label') ?: '';
        $title = \get_field('what_title') ?: '';

        $itemsRaw = \get_field('what_items') ?: [];
        $items = [];

        foreach ($itemsRaw as $item) {
            $icon = $item['what_item_icon'] ?? null;
            $items[] = [
                'icon' => is_array($icon) ? ($icon['url'] ?? '') : '',
                'iconAlt' => is_array($icon) ? ($icon['alt'] ?? '') : '',
                'title' => $item['what_item_title'] ?? '',
                'description' => $item['what_item_description'] ?? '',
            ];
        }

        return [
            'label' => $label,
            'title' => $title,
            'items' => $items,
        ];
    }
}
