<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class BlogPersonalQuoteBlockComposer extends Composer
{
    protected static $views = [
        'blocks.blog-personal-quote',
    ];

    public function with(): array
    {
        $image = \get_field('personal_quote_image') ?: null;
        $imageUrl = '';
        if (is_array($image)) {
            $imageUrl = $image['sizes']['medium'] ?? $image['url'] ?? '';
        }

        return [
            'text' => \get_field('personal_quote_text') ?: 'Najlepszy styl to taki, w którym czujesz się sobą — nie naśladujesz nikogo.',
            'author' => \get_field('personal_quote_author') ?: 'Dominik Pakuła',
            'role' => \get_field('personal_quote_role') ?: 'Stylista',
            'image' => $imageUrl,
        ];
    }
}
