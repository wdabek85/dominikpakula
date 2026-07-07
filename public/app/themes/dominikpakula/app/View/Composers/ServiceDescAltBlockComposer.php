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
                'allowHtml' => false,
            ],
            'negative' => [
                'title' => \get_field('descb_negative_title') ?: 'To nie ta usługa, jeśli:',
                'items' => $this->items('descb_negative_items', true) ?: [
                    'potrzebujesz tylko jednej stylizacji na konkretną okazję',
                ],
                'allowHtml' => true,
            ],
        ];
    }

    /**
     * Punkty z repeatera. Gdy $allowHtml — dopuszcza linki (wp_kses_post),
     * ściąga <p> od WYSIWYG i dokleja „ →" wewnątrz <a> (klikalna strzałka).
     */
    protected function items(string $field, bool $allowHtml = false): array
    {
        $rows = \get_field($field) ?: [];
        $items = [];

        foreach ($rows as $row) {
            $raw = (string) ($row['item_text'] ?? '');

            if ($allowHtml) {
                $clean = \wp_kses_post($raw);
                $clean = preg_replace('#</?p[^>]*>#i', '', $clean);
                $clean = preg_replace('/(<a[^>]*>)(.*?)(<\/a>)/iu', '$1$2 →$3', (string) $clean);
                $clean = trim((string) $clean);
            } else {
                $clean = trim($raw);
            }

            if ($clean !== '') {
                $items[] = $clean;
            }
        }

        return $items;
    }
}
