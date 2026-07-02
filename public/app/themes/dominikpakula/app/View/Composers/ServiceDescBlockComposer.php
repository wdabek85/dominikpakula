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
                    'allow_html' => false,
                ],
                [
                    'eyebrow' => \get_field('desc_highlight_eyebrow') ?: 'Polecam',
                    'number' => '02',
                    'title' => \get_field('desc_highlight_title') ?: 'Sprawdza się szczególnie, jeśli:',
                    'items' => $this->highlightItems(),
                    'allow_html' => false,
                ],
                [
                    'eyebrow' => \get_field('desc_negative_eyebrow') ?: 'Raczej nie',
                    'number' => '03',
                    'title' => \get_field('desc_negative_title') ?: 'To nie ta usługa, jeśli:',
                    'items' => $this->negativeItems(),
                    'allow_html' => true,
                ],
            ],
        ];
    }

    // Listy 3 sekcji są pobierane z repeaterów ACF (desc_positive_items /
    // desc_highlight_items / desc_negative_items), każdy z sub-fieldem `item_text`.
    // Sekcja "negative" używa WYSIWYG (linki do innych usług) — composer
    // sanitizuje przez wp_kses_post i ściąga <p> wrapper od wpautop.
    // Jeśli repeater w danej usłudze jest pusty — wracamy do hardcoded fallbacków.
    protected function positiveItems(): array
    {
        return $this->itemsFromRepeater('desc_positive_items') ?: [
            'masz pełną szafę, ale dalej nie masz gotowych zestawów',
            'chcesz wyglądać lepiej, ale bez błądzenia po sklepach i kupowania w ciemno',
            'masz chaos w ubraniach (różne style, rozmiary, przypadkowe zakupy)',
            'wiesz, że brakuje Ci „bazowych" rzeczy, ale nie wiesz, jakie konkretnie',
            'chcesz mieć prostą garderobę, która działa: praca / codziennie / wyjście',
        ];
    }

    protected function highlightItems(): array
    {
        return $this->itemsFromRepeater('desc_highlight_items') ?: [
            'zmieniła Ci się sylwetka albo styl życia i obecne ubrania przestały pasować',
            'zaczynasz nową pracę / masz więcej spotkań i chcesz wyglądać bardziej profesjonalnie',
            'chcesz uporządkować szafę i jednocześnie od razu uzupełnić braki',
        ];
    }

    protected function negativeItems(): array
    {
        return $this->itemsFromRepeater('desc_negative_items', true) ?: [
            'potrzebujesz tylko jednej stylizacji na konkretną okazję — wtedy lepsza będzie stylizacja okazjonalna',
        ];
    }

    protected function itemsFromRepeater(string $field, bool $allowHtml = false): array
    {
        $rows = \get_field($field) ?: [];
        $items = [];

        foreach ($rows as $row) {
            $raw = $row['item_text'] ?? '';

            if ($allowHtml) {
                $clean = \wp_kses_post((string) $raw);
                $clean = preg_replace('#</?p[^>]*>#i', '', $clean);
                // Dopisz " →" wewnątrz każdego <a>...</a>, żeby strzałka
                // była częścią linku (klikalna, nie odrywa się przy zawijaniu).
                $clean = preg_replace('/(<a[^>]*>)(.*?)(<\/a>)/iu', '$1$2 →$3', (string) $clean);
                $clean = trim((string) $clean);
            } else {
                $clean = trim((string) $raw);
            }

            if ($clean !== '') {
                $items[] = $clean;
            }
        }

        return $items;
    }
}
