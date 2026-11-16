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
        $cities = $this->cityIds();

        return [
            'eyebrow' => trim((string) \get_field('areas_eyebrow')),
            'heading' => trim((string) \get_field('areas_heading')) ?: 'Gdzie działam',
            'text' => $this->text($cities),
            'links' => $this->links($cities),
        ];
    }

    /**
     * Miasta = opublikowane podstrony usług (ServiceCatalog::cityIds — to samo źródło co stopka,
     * „Zobacz też” i areaServed). Nowe miasto = nowa podstrona, bez edycji tego bloku.
     *
     * @return int[]
     */
    protected function cityIds(): array
    {
        return array_map('intval', ServiceCatalog::cityIds());
    }

    /**
     * Tekst z pola; „{miasta}” → lista miast w dopełniaczu („Krakowa, Warszawy i Kielc”).
     */
    protected function text(array $cities): string
    {
        $text = trim((string) \get_field('areas_text'));

        if ($text === '' || ! str_contains($text, '{miasta}')) {
            return $text;
        }

        $names = array_values(array_filter(array_map(
            fn (int $id) => trim((string) \get_field('service_city_genitive', $id)) ?: ServiceCatalog::cityName($id),
            $cities
        )));

        $last = array_pop($names);
        $list = $names ? implode(', ', $names) . ' i ' . $last : (string) $last;

        return str_replace('{miasta}', $list, $text);
    }

    /**
     * Najpierw linki wybrane w bloku (np. Zakupy online), potem wszystkie miasta, których tam nie ma.
     * Treść linku: miasta — fraza lokalna („stylista męski Kraków”), jak w stopce; reszta — tytuł strony.
     */
    protected function links(array $cities): array
    {
        $selected = \get_field('areas_links');
        $selected = is_array($selected)
            ? array_map(fn ($id) => (int) (is_object($id) ? $id->ID : $id), $selected)
            : [];

        $ids = array_values(array_unique(array_filter(array_merge($selected, $cities))));
        $links = [];

        foreach ($ids as $id) {
            if (\get_post_status($id) !== 'publish') {
                continue;
            }

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
