<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceProcessBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-process',
    ];

    public function with(): array
    {
        $label = \get_field('process_label') ?: '';
        $description = \get_field('process_description') ?: '';

        $stepsRaw = \get_field('process_steps') ?: [];
        $steps = [];

        foreach ($stepsRaw as $item) {
            $icon = $item['process_step_icon'] ?? null;
            $steps[] = [
                'icon' => is_array($icon) ? ($icon['url'] ?? '') : '',
                'iconAlt' => is_array($icon) ? ($icon['alt'] ?? '') : '',
                'stepLabel' => $item['process_step_label'] ?? '',
                'title' => $item['process_step_title'] ?? '',
                'description' => $item['process_step_description'] ?? '',
            ];
        }

        return [
            'label' => $label,
            'description' => $description,
            'steps' => $steps,
        ];
    }
}
