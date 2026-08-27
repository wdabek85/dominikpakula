<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class LookbookSectionBlockComposer extends Composer
{
    protected static $views = [
        'blocks.lookbook-section',
    ];

    public function with(): array
    {
        $title = \get_field('lookbook_title') ?: '';
        $description = \get_field('lookbook_description') ?: '';
        $items = $this->items();
        $rawLayout = \get_field('lookbook_layout') ?: 'grid-3';

        return [
            'title' => $title,
            'description' => $description,
            'layout' => $this->layout($rawLayout),
            'items' => $items,
            'featuredFirst' => $this->featuredFirst($rawLayout),
            'isEmpty' => ! $title && ! $description && ! $items,
            'isPreview' => $this->isPreview(),
        ];
    }

    /**
     * Wartość z panelu → layout renderowany w Blade.
     *
     * `grid-5` i `grid-5-right` to ten sam układ (1 duże zdjęcie + siatka 2x2),
     * różnią się wyłącznie stroną dużego zdjęcia — patrz `featuredFirst()`.
     */
    protected function layout(string $rawLayout): string
    {
        $aliases = [
            'grid-5' => 'split',
            'grid-5-right' => 'split',
        ];
        $layout = $aliases[$rawLayout] ?? $rawLayout;

        if (! in_array($layout, ['grid-3', 'grid-4', 'split'], true)) {
            $layout = 'grid-3';
        }

        return $layout;
    }

    /**
     * Strona dużego zdjęcia w layoucie split.
     *
     * Decyduje wybór layoutu w panelu: `grid-5-right` = duże zdjęcie po prawej,
     * cała reszta = po lewej. Dodatkowo honorowane jest opcjonalne pole
     * `lookbook_featured_position` ('left' | 'right'), gdyby kiedyś powstało —
     * ale domyślnie NIE istnieje i wtedy nie ma żadnego wpływu.
     *
     * Wszystko poza jawnym „prawo" daje lewą stronę, więc brak pola i stare
     * wpisy z `grid-5` renderują się dokładnie jak wcześniej.
     */
    protected function featuredFirst(string $rawLayout): bool
    {
        if ($rawLayout === 'grid-5-right') {
            return false;
        }

        return \get_field('lookbook_featured_position') !== 'right';
    }

    /**
     * Czy render leci z edytora bloków. ACF wstawia `preview => true` w tablicy
     * bloku (przekazywanej do widoku w app/blocks.php). Na froncie zawsze false —
     * dzięki temu placeholder nigdy nie wychodzi do użytkownika.
     */
    protected function isPreview(): bool
    {
        $block = $this->view->getData()['block'] ?? null;

        return is_array($block) && ! empty($block['preview']);
    }

    protected function items(): array
    {
        $rows = \get_field('lookbook_items') ?: [];

        if (! is_array($rows)) {
            return [];
        }

        $out = [];
        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $image = $row['item_image'] ?? null;
            if (! is_array($image)) {
                continue;
            }

            $url = $image['sizes']['large'] ?? $image['url'] ?? '';
            if (! $url) {
                continue;
            }

            $type = $row['item_type'] ?? 'product';
            if (! in_array($type, ['model', 'product'], true)) {
                $type = 'product';
            }

            $out[] = [
                'src' => $url,
                'fullSrc' => $image['url'] ?? $url,
                'alt' => $image['alt'] ?? '',
                'width' => $image['sizes']['large-width'] ?? $image['width'] ?? null,
                'height' => $image['sizes']['large-height'] ?? $image['height'] ?? null,
                'brand' => $row['item_brand'] ?? '',
                'shopUrl' => $row['item_url'] ?? '',
                'type' => $type,
            ];
        }

        return $out;
    }
}
