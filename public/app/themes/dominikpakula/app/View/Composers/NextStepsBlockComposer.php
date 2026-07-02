<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class NextStepsBlockComposer extends Composer
{
    protected static $views = [
        'blocks.next-steps',
    ];

    public function with(): array
    {
        return [
            'stepsHeading' => \get_field('steps_heading') ?: 'Co dalej? Tak wygląda nasza pierwsza wymiana',
            'stepsSubtitle' => \get_field('steps_subtitle') ?: 'Bez tajemnic — wiesz dokładnie co Cię czeka.',
            'steps' => $this->steps(),
        ];
    }

    protected function steps(): array
    {
        // Hardcoded — w razie potrzeby zmiany tekstu edytuj tutaj.
        // Pola ACF mogą być dodane jako repeater 'steps_items' jeśli klient
        // potrzebuje pełnej kontroli z panelu (na razie 3 stałe kroki wystarczą).
        return [
            [
                'number' => '01',
                'title' => 'Piszesz',
                'text' => 'Wypełnij formularz albo napisz na wybranym kanale. Każda wiadomość trafia bezpośrednio do mnie.',
            ],
            [
                'number' => '02',
                'title' => 'Odpowiadam w 24h',
                'text' => 'Odpiszę osobiście, doprecyzujemy Twoje potrzeby i ustalimy najlepszą formę współpracy.',
            ],
            [
                'number' => '03',
                'title' => 'Spotykamy się',
                'text' => 'Krótka rozmowa video albo spotkanie na żywo, żeby się poznać i zaplanować pierwsze kroki.',
            ],
        ];
    }
}
