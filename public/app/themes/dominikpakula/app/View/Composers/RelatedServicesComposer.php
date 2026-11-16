<?php

namespace App\View\Composers;

use App\Services\ServiceCatalog;
use Roots\Acorn\View\Composer;

/**
 * Linkowanie wewnętrzne na dole podstrony usługi (sections/service/related).
 *
 * - Miasto (podstrona usługi): „Zobacz też” → usługa-rodzic, zakupy online, pozostałe miasta.
 * - Usługa główna: „Inne usługi” → pozostałe usługi główne.
 *
 * Wszystko liczone z CPT `service`, więc nowe miasto / usługa dochodzą automatycznie.
 */
class RelatedServicesComposer extends Composer
{
    /** Ścieżka usługi „Zakupy online” — link „Wolisz online?” na stronach miast. */
    protected const ONLINE_PATH = 'zakupy-online';

    protected static $views = [
        'sections.service.related',
    ];

    public function with(): array
    {
        $id = (int) \get_the_ID();
        $parent = (int) \wp_get_post_parent_id($id);

        return $parent
            ? ['relatedHeading' => 'Zobacz też', 'relatedLinks' => $this->cityLinks($id, $parent)]
            : ['relatedHeading' => 'Inne usługi', 'relatedLinks' => $this->serviceLinks($id)];
    }

    protected function cityLinks(int $id, int $parent): array
    {
        $links = [[
            'label' => \html_entity_decode(\get_the_title($parent), ENT_QUOTES, 'UTF-8') . ' – jak to wygląda',
            'url' => \get_permalink($parent),
        ]];

        $online = ServiceCatalog::idByPath(self::ONLINE_PATH);
        if ($online && $online !== $id) {
            $links[] = [
                'label' => 'Wolisz online? Zakupy zdalne z całej Polski',
                'url' => \get_permalink($online),
            ];
        }

        foreach (ServiceCatalog::childIds($parent) as $cityId) {
            if ($cityId === $id) {
                continue;
            }
            $links[] = [
                'label' => 'Stylista męski ' . ServiceCatalog::cityName($cityId),
                'url' => \get_permalink($cityId),
            ];
        }

        return $links;
    }

    protected function serviceLinks(int $id): array
    {
        $links = [];

        foreach (ServiceCatalog::cards(ServiceCatalog::topLevelIds()) as $card) {
            if ($card['id'] === $id) {
                continue;
            }
            $links[] = [
                'label' => \html_entity_decode($card['fullTitle'], ENT_QUOTES, 'UTF-8'),
                'url' => $card['url'],
            ];
        }

        return $links;
    }
}
