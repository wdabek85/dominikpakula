<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceDescBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-desc',
    ];

    public function with(): array
    {
        return [
            'label' => \get_field('desc_label') ?: 'Dla kogo',
            'heading' => \get_field('desc_heading') ?: 'Czy ta usługa jest dla Ciebie?',
            'sections' => [
                [
                    'eyebrow' => \get_field('desc_positive_eyebrow') ?: 'Tak',
                    'number' => '01',
                    'title' => \get_field('desc_positive_title') ?: 'Jeśli jesteś facetem i:',
                    'items' => $this->positiveItems(),
                ],
                [
                    'eyebrow' => \get_field('desc_highlight_eyebrow') ?: 'Polecam',
                    'number' => '02',
                    'title' => \get_field('desc_highlight_title') ?: 'Sprawdza się szczególnie, jeśli:',
                    'items' => $this->highlightItems(),
                ],
                [
                    'eyebrow' => \get_field('desc_negative_eyebrow') ?: 'Raczej nie',
                    'number' => '03',
                    'title' => \get_field('desc_negative_title') ?: 'To nie ta usługa, jeśli:',
                    'items' => $this->negativeItems(),
                ],
            ],
        ];
    }

    // Hardcoded fallback content (testowo). Po dorobieniu pól ACF
    // (repeatery desc_positive_items / desc_highlight_items / desc_negative_items)
    // można podmienić na get_field() — wtedy każda usługa będzie miała własne listy.
    protected function positiveItems(): array
    {
        return [
            'masz pełną szafę, ale dalej nie masz gotowych zestawów',
            'chcesz wyglądać lepiej, ale bez błądzenia po sklepach i kupowania w ciemno',
            'masz chaos w ubraniach (różne style, rozmiary, przypadkowe zakupy)',
            'wiesz, że brakuje Ci „bazowych" rzeczy, ale nie wiesz, jakie konkretnie',
            'chcesz mieć prostą garderobę, która działa: praca / codziennie / wyjście',
        ];
    }

    protected function highlightItems(): array
    {
        return [
            'zmieniła Ci się sylwetka albo styl życia i obecne ubrania przestały pasować',
            'zaczynasz nową pracę / masz więcej spotkań i chcesz wyglądać bardziej profesjonalnie',
            'chcesz uporządkować szafę i jednocześnie od razu uzupełnić braki',
        ];
    }

    protected function negativeItems(): array
    {
        return [
            'potrzebujesz tylko jednej stylizacji na konkretną okazję — wtedy lepsza będzie stylizacja okazjonalna',
        ];
    }
}
