<?php

namespace App\Services;

/**
 * Jedno źródło danych o usługach dla kart (strona główna, Oferta, Voucher, rezerwacje).
 *
 * Wszystko czyta z CPT `service`: zakładka „Karta usługi” (acf-json/group_service_card.json)
 * + cena z `service_price` + link = permalink. Listy biorą tylko usługi główne
 * (post_parent = 0) — podstrony (miasta) pokazuje wyłącznie blok local-seo rodzica.
 */
class ServiceCatalog
{
    /**
     * Usługi główne w kolejności z „Atrybuty strony → Kolejność”.
     *
     * @return int[]
     */
    public static function topLevelIds(): array
    {
        return \get_posts([
            'post_type' => 'service',
            'post_status' => 'publish',
            'post_parent' => 0,
            'posts_per_page' => -1,
            'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);
    }

    /**
     * Opublikowane podstrony usługi (np. miasta).
     *
     * @return int[]
     */
    public static function childIds(int $parentId): array
    {
        if (! $parentId) {
            return [];
        }

        return \get_posts([
            'post_type' => 'service',
            'post_status' => 'publish',
            'post_parent' => $parentId,
            'posts_per_page' => -1,
            'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
            'fields' => 'ids',
            'no_found_rows' => true,
        ]);
    }

    /**
     * Karty dla listy ID — pomija nieopublikowane / nie-usługi (np. usuniętą usługę w relacji).
     *
     * @param  int[]  $ids
     */
    public static function cards(array $ids): array
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));

        if (! $ids) {
            return [];
        }

        \update_meta_cache('post', $ids);

        return array_values(array_filter(array_map([self::class, 'card'], $ids)));
    }

    public static function card(int $id): ?array
    {
        if (\get_post_type($id) !== 'service' || \get_post_status($id) !== 'publish') {
            return null;
        }

        $excerpt = trim((string) \get_field('service_card_excerpt', $id));
        $icon = \get_field('service_card_icon', $id) ?: \get_field('service_hero_icon', $id);

        return [
            'id' => $id,
            'title' => trim((string) \get_field('service_card_title', $id)) ?: \get_the_title($id),
            'fullTitle' => \get_the_title($id),
            'problem' => trim((string) \get_field('service_card_problem', $id)),
            'excerpt' => $excerpt,
            'description' => trim((string) \get_field('service_card_description', $id)) ?: $excerpt,
            'icon' => is_array($icon) && ! empty($icon['url']) ? $icon : null,
            'price' => trim((string) \get_field('service_price', $id)),
            'url' => \get_permalink($id),
        ];
    }
}
