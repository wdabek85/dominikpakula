<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LocalSeoBlockComposer extends Composer
{
    protected static $views = [
        'blocks.local-seo',
    ];

    public function with(): array
    {
        return [
            'eyebrow' => \get_field('local_eyebrow') ?: 'Okolica',
            'heading' => \get_field('local_heading') ?: 'Zakupy ze stylistą w Twoim mieście',
            'items' => $this->items(),
        ];
    }

    /**
     * Pozycje repeatera — tylko kompletne (tytuł + URL).
     */
    protected function items(): array
    {
        $rows = \get_field('local_items');

        if (! $rows || ! is_array($rows)) {
            return [];
        }

        $items = [];

        foreach ($rows as $row) {
            $title = $row['title'] ?? '';
            $url = $row['url'] ?? '';

            if (! $title || ! $url) {
                continue;
            }

            $items[] = [
                'title' => $title,
                'url' => $url,
                'image' => is_array($row['image'] ?? null) ? $row['image'] : null,
            ];
        }

        return $items;
    }
}
