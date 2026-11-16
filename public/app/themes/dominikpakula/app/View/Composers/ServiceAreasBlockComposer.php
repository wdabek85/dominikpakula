<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceAreasBlockComposer extends Composer
{
    protected static $views = [
        'blocks.service-areas',
    ];

    public function with(): array
    {
        return [
            'eyebrow' => trim((string) \get_field('areas_eyebrow')),
            'heading' => trim((string) \get_field('areas_heading')) ?: 'Gdzie działam',
            'text' => trim((string) \get_field('areas_text')),
            'links' => $this->links(),
        ];
    }

    /**
     * Wybrane usługi/miasta — tylko opublikowane; treść linku = tytuł strony.
     */
    protected function links(): array
    {
        $ids = \get_field('areas_links');

        if (! $ids || ! is_array($ids)) {
            return [];
        }

        $links = [];

        foreach ($ids as $id) {
            $id = (int) (is_object($id) ? $id->ID : $id);

            if (! $id || \get_post_status($id) !== 'publish') {
                continue;
            }

            $links[] = [
                'label' => \html_entity_decode(\get_the_title($id), ENT_QUOTES, 'UTF-8'),
                'url' => \get_permalink($id),
            ];
        }

        return $links;
    }
}
