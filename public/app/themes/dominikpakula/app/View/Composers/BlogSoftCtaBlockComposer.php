<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogSoftCtaBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-soft-cta',
    ];

    public function with(): array
    {
        $link = $this->link();
        $text = \get_field('soft_cta_text') ?: '';

        return [
            'text' => $text,
            'url' => $link['url'],
            'label' => $this->label($link['title']),
            'target' => $link['target'],
            'isEmpty' => ! $text && ! $link['url'],
            'isPreview' => $this->isPreview(),
        ];
    }

    /**
     * Pole `soft_cta_url`. Typ „Link" w ACF zwraca tablicę (url/title/target),
     * ale to samo pole ustawione jako Page Link albo zwykły text zwraca string —
     * obsługujemy oba, żeby zmiana typu pola w panelu niczego nie wywróciła.
     *
     * @return array{url: string, title: string, target: string}
     */
    protected function link(): array
    {
        $link = \get_field('soft_cta_url');

        if (is_array($link)) {
            return [
                'url' => is_string($link['url'] ?? null) ? $link['url'] : '',
                'title' => is_string($link['title'] ?? null) ? $link['title'] : '',
                'target' => ($link['target'] ?? '') === '_blank' ? '_blank' : '',
            ];
        }

        return [
            'url' => is_string($link) ? $link : '',
            'title' => '',
            'target' => '',
        ];
    }

    /**
     * Etykieta linku: własne pole → tytuł z pola Link → domyślna.
     * Świadomie BEZ domyślnego URL-a — adresów nie hardkodujemy, więc gdy pole
     * jest puste, blok renderuje sam tekst i nie udaje, że gdzieś prowadzi.
     */
    protected function label(string $linkTitle): string
    {
        $label = \get_field('soft_cta_label');

        if (is_string($label) && $label !== '') {
            return $label;
        }

        return $linkTitle !== '' ? $linkTitle : 'Zobacz usługi';
    }

    /**
     * Czy render leci z edytora bloków — flaga normalizowana w app/blocks.php.
     */
    protected function isPreview(): bool
    {
        $block = $this->view->getData()['block'] ?? null;

        return is_array($block) && ! empty($block['preview']);
    }
}
