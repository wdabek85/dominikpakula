<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceDescAltBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-desc-alt',
    ];

    public function with(): array
    {
        return [
            'label' => \get_field('descb_label') ?: 'Dla kogo',
            'heading' => \get_field('descb_heading') ?: 'Czy ta usługa jest dla Ciebie?',
            'positive' => [
                'title' => \get_field('descb_positive_title') ?: 'Ta usługa jest dla Ciebie, jeśli:',
                'items' => $this->items('descb_positive_items') ?: [
                    'masz pełną szafę, ale dalej nie masz gotowych zestawów',
                    'chcesz wyglądać lepiej, bez błądzenia po sklepach i kupowania w ciemno',
                    'masz chaos w ubraniach (różne style, rozmiary, przypadkowe zakupy)',
                    'chcesz mieć prostą garderobę, która działa: praca / codziennie / wyjście',
                ],
            ],
            'negative' => [
                'title' => \get_field('descb_negative_title') ?: 'To nie ta usługa, jeśli:',
                'items' => $this->items('descb_negative_items') ?: [
                    'potrzebujesz tylko jednej stylizacji na konkretną okazję',
                    'szukasz gotowej listy zakupów bez konsultacji',
                ],
            ],
        ];
    }

    protected function items(string $field): array
    {
        $rows = \get_field($field) ?: [];
        $items = [];

        foreach ($rows as $row) {
            $val = trim((string) ($row['item_text'] ?? ''));
            if ($val !== '') {
                $items[] = $val;
            }
        }

        return $items;
    }
}
