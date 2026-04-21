<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ProcessBlockComposer extends Composer
{
    protected static $views = [
        'blocks.process.index',
    ];

    public function with(): array
    {
        $steps = [];
        $rawSteps = \get_field('process_steps') ?: [];

        foreach ($rawSteps as $step) {
            $steps[] = [
                'number' => $step['process_step_number'] ?? '',
                'title' => $step['process_step_title'] ?? '',
                'description' => $step['process_step_description'] ?? '',
            ];
        }

        return [
            'label' => \get_field('process_label') ?: '',
            'title' => \get_field('process_title') ?: '',
            'description' => wp_kses_post(\get_field('process_description') ?: ''),
            'steps' => $steps,
            'footer' => wp_kses_post(\get_field('process_footer') ?: ''),
        ];
    }
}
