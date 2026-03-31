<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceFaqBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-faq',
    ];

    public function with(): array
    {
        $label = \get_field('faq_label') ?: '';
        $description = \get_field('faq_description') ?: '';

        $itemsRaw = \get_field('faq_items') ?: [];
        $items = [];

        foreach ($itemsRaw as $item) {
            $items[] = [
                'question' => $item['faq_question'] ?? '',
                'answer' => $item['faq_answer'] ?? '',
            ];
        }

        return [
            'label' => $label,
            'description' => $description,
            'items' => $items,
        ];
    }
}
