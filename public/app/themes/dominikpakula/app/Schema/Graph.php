<?php

namespace App\Schema;

/**
 * Modyfikacja grafu JSON-LD Rank Math (filtr rank_math/json_ld) — bez drugiego <script>.
 *
 * - wszędzie, gdzie Rank Math dodaje wydawcę: #person = sam Person (worksFor → #business) + węzeł #business,
 *   WebSite.publisher → #business;
 * - strony (page) i usługi: bez Article i węzła autora (to nie są artykuły);
 * - strona główna: WebPage.about → #business;
 * - usługi: węzeł Service; strony z blokiem FAQ: FAQPage.
 */
class Graph
{
    /** Typy wpisu Rank Math, które usuwamy ze stron i usług. */
    protected const ARTICLE_TYPES = ['Article', 'BlogPosting', 'NewsArticle'];

    public static function filter(array $data): array
    {
        if (! $data) {
            return $data;
        }

        $isPage = \is_singular('page');
        $isService = \is_singular('service');

        if ($isPage || $isService) {
            if (in_array($data['richSnippet']['@type'] ?? '', self::ARTICLE_TYPES, true)) {
                unset($data['richSnippet']);
            }
            unset($data['ProfilePage']);
        }

        if (isset($data['publisher']) || $isService) {
            $data['publisher'] = Business::person();
            $data['business'] = Business::node();

            if (isset($data['WebSite'])) {
                $data['WebSite']['publisher'] = ['@id' => Business::id()];
            }
        }

        if (\is_front_page() && isset($data['WebPage'])) {
            $data['WebPage']['about'] = ['@id' => Business::id()];
        }

        $postId = (int) \get_queried_object_id();

        if ($isService && $postId) {
            $data['Service'] = ServiceNode::node($postId);
        }

        if (($isPage || $isService) && $postId && ($faq = Faq::node($postId))) {
            $data['FAQPage'] = $faq;
        }

        return $data;
    }

    /**
     * Usługi nie mają w Rank Math domyślnego typu schematu, przez co Rank Math pomija na nich
     * cały graf (WebSite/WebPage). Włączamy globalne encje — typ strony to WebPage.
     */
    public static function addGlobalEntities(bool $can): bool
    {
        return \is_singular('service') ? true : $can;
    }
}
