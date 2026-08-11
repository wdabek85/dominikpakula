<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\Booking\contact_consent_html;

class ContactBlockComposer extends Composer
{
    protected static $views = [
        'blocks.contact',
    ];

    public function with(): array
    {
        return [
            // Treść zgody pochodzi z App\Booking\Consent — ten sam tekst trafia
            // do maila jako dowód zgody, więc nie wolno go tu dublować ręcznie.
            'gdprConsent' => contact_consent_html(),
        ];
    }
}
