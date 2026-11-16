<?php

namespace App\View\Composers;

use App\Services\ServiceCatalog;
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
     * Wybrane usługi/miasta — tylko opublikowane; treść linku = tytuł strony (miasta: fraza lokalna).
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

            // Miasta: anchor pod frazę lokalną („stylista męski Kraków”), jak w stopce; reszta — tytuł strony.
            $label = \wp_get_post_parent_id($id)
                ? 'stylista męski ' . ServiceCatalog::cityName($id)
                : \html_entity_decode(\get_the_title($id), ENT_QUOTES, 'UTF-8');

            $links[] = [
                'label' => $label,
                'url' => \get_permalink($id),
            ];
        }

        return $links;
    }
}
