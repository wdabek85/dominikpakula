<?php

namespace App\View\Composers;

use App\Services\Glossary;
use Roots\Acorn\View\Composer;

/**
 * Archiwum słowniczka (CPT glossary) — /slowniczek/.
 *
 * Hasła z głównego zapytania grupowane po literze (App\Services\Glossary).
 * Pasek alfabetu pokazuje wszystkie litery; te bez haseł są nieaktywne.
 */
class ArchiveGlossaryComposer extends Composer
{
    protected static $views = [
        'archive-glossary',
    ];

    public function with(): array
    {
        global $wp_query;

        $groups = Glossary::groups($wp_query->posts ?? []);

        return [
            'heroTitle' => $this->option('glossary_title') ?: 'Słowniczek stylu',
            'heroDescription' => $this->option('glossary_description')
                ?: 'Pojęcia ze świata męskiej mody i stylizacji wyjaśnione prostym językiem — od A do Ż.',
            'letters' => Glossary::letters($groups),
            'groups' => $groups,
        ];
    }

    protected function option(string $name): string
    {
        return function_exists('get_field') ? (string) (\get_field($name, 'option') ?: '') : '';
    }
}
