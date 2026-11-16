<?php

namespace App\Schema;

use App\Services\ServiceCatalog;

/**
 * Węzeł Service dla podstrony CPT `service` (usługa główna lub miasto).
 *
 * areaServed: miasto → tylko to miasto; zakupy online → Polska; pozostałe → pełna lista.
 */
class ServiceNode
{
    /** Ścieżka usługi świadczonej zdalnie w całej Polsce. */
    public const ONLINE_PATH = 'zakupy-online';

    /**
     * Nazwa usługi = H1 strony (pole „Tytuł w sidebarze”, fallback: tytuł wpisu).
     */
    public static function name(int $id): string
    {
        $name = trim((string) \get_field('service_sidebar_title', $id)) ?: \get_the_title($id);

        return \html_entity_decode(\wp_strip_all_tags($name), ENT_QUOTES, 'UTF-8');
    }

    public static function node(int $id): array
    {
        $url = \get_permalink($id);
        $node = [
            '@type' => 'Service',
            '@id' => $url . '#service',
            'name' => self::name($id),
            'url' => $url,
            'provider' => ['@id' => Business::id()],
            'areaServed' => self::areaServed($id),
        ];

        $description = trim((string) \get_field('service_sidebar_description', $id));
        if ($description !== '') {
            $node['description'] = \wp_strip_all_tags($description);
        }

        $price = ServiceCatalog::priceAmount($id);
        if ($price !== '') {
            $node['offers'] = [
                '@type' => 'Offer',
                'price' => $price,
                'priceCurrency' => 'PLN',
                'url' => $url,
            ];
        }

        return $node;
    }

    protected static function areaServed(int $id): array
    {
        if (\wp_get_post_parent_id($id)) {
            return [['@type' => 'City', 'name' => ServiceCatalog::cityName($id)]];
        }

        if ($id === ServiceCatalog::idByPath(self::ONLINE_PATH)) {
            return [['@type' => 'Country', 'name' => 'Polska']];
        }

        return Business::areaServed();
    }
}
