<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ConsultationProcessBlockComposer extends Composer
{
    protected static $views = [
        'blocks.consultation-process',
    ];

    public function with(): array
    {
        return [
            'label' => \get_field('consultation_label') ?: 'Konsultacje',
            'title' => \get_field('consultation_title') ?: 'Jak działa konsultacja?',
            'lead' => wp_kses_post(\get_field('consultation_lead') ?: 'Nie wiesz, którą usługę wybrać? Umów bezpłatną konsultację. Poznajemy Twój styl i potrzeby, a potem wspólnie dobieramy najlepsze rozwiązanie — bez zobowiązań.'),
            'steps' => $this->steps(),
            'ctaLabel' => \get_field('consultation_cta_label') ?: 'Umów konsultację',
            'ctaService' => \get_field('consultation_cta_service') ?: 'Konsultacja',
            'footer' => wp_kses_post(\get_field('consultation_footer') ?: 'Konkretną godzinę ustalamy przy potwierdzeniu terminu.'),
        ];
    }

    protected function steps(): array
    {
        $raw = \get_field('consultation_steps') ?: [];

        if ($raw) {
            $steps = [];
            foreach ($raw as $step) {
                $steps[] = [
                    'number' => $step['consultation_step_number'] ?? '',
                    'title' => $step['consultation_step_title'] ?? '',
                    'description' => $step['consultation_step_description'] ?? '',
                ];
            }

            return $steps;
        }

        // Fallback — hardcoded 4 kroki konsultacji
        return [
            [
                'number' => '01',
                'title' => 'Wybierasz termin',
                'description' => 'Wskazujesz wolny dzień w kalendarzu online. Zajmuje to chwilę, bez zakładania konta.',
            ],
            [
                'number' => '02',
                'title' => 'Potwierdzamy',
                'description' => 'Dostajesz potwierdzenie SMS-em lub mailem. Damy znać, jeśli trzeba coś doprecyzować.',
            ],
            [
                'number' => '03',
                'title' => 'Rozmawiamy',
                'description' => 'Na konsultacji poznajemy Twój styl, potrzeby i budżet — i doradzamy właściwą usługę.',
            ],
            [
                'number' => '04',
                'title' => 'Umawiamy usługę',
                'description' => 'Po rozmowie rezerwujemy konkretny termin wybranej usługi. Zero zgadywania.',
            ],
        ];
    }
}
