<?php

namespace App\View\Composers;

use App\Services\Glossary;
use Roots\Acorn\View\Composer;

/**
 * Pojedyncze hasło słowniczka (CPT glossary) + sidebar z wyszukiwarką i akordeonem liter.
 */
class SingleGlossaryComposer extends Composer
{
    protected static $views = [
        'single-glossary',
    ];

    public function with(): array
    {
        $postId = get_the_ID();
        $post = $postId ? get_post($postId) : null;
        $glossaryUrl = get_post_type_archive_link('glossary') ?: home_url('/slowniczek/');

        if (! $post) {
            return [
                'title' => '',
                'lead' => '',
                'content' => '',
                'glossaryUrl' => $glossaryUrl,
                'breadcrumbs' => [],
                'sidebarGroups' => [],
            ];
        }

        $title = get_the_title($post);

        return [
            'title' => $title,
            'lead' => has_excerpt($post) ? wp_strip_all_tags($post->post_excerpt) : '',
            'content' => $post->post_content,
            'glossaryUrl' => $glossaryUrl,
            'breadcrumbs' => [
                ['label' => 'Strona główna', 'url' => home_url('/')],
                ['label' => 'Słowniczek', 'url' => $glossaryUrl],
                ['label' => $title, 'url' => null],
            ],
            'sidebarGroups' => Glossary::groups(Glossary::allPosts(), (int) $post->ID),
        ];
    }
}
