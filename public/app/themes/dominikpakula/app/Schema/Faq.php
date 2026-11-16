<?php

namespace App\Schema;

/**
 * FAQPage z bloków `acf/service-faq` w treści wpisu — to samo źródło (pole faq_items),
 * z którego renderuje się widoczna sekcja FAQ, więc teksty są identyczne.
 */
class Faq
{
    protected const BLOCK = 'acf/service-faq';

    public static function node(int $postId): ?array
    {
        $questions = [];

        foreach (self::blocks(\parse_blocks((string) \get_post_field('post_content', $postId))) as $i => $block) {
            foreach (self::rows($block, "schema_faq_{$postId}_{$i}") as $row) {
                $questions[] = [
                    '@type' => 'Question',
                    'name' => $row['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $row['answer'],
                    ],
                ];
            }
        }

        if (! $questions) {
            return null;
        }

        return [
            '@type' => 'FAQPage',
            '@id' => \get_permalink($postId) . '#faq',
            'mainEntity' => $questions,
        ];
    }

    /**
     * Bloki FAQ, także zagnieżdżone (np. w grupie/kolumnach).
     */
    protected static function blocks(array $blocks): array
    {
        $found = [];

        foreach ($blocks as $block) {
            if (($block['blockName'] ?? '') === self::BLOCK) {
                $found[] = $block;
            }
            if (! empty($block['innerBlocks'])) {
                array_push($found, ...self::blocks($block['innerBlocks']));
            }
        }

        return $found;
    }

    /**
     * Pytania i odpowiedzi tak, jak czyta je composer bloku (get_field na danych bloku).
     */
    protected static function rows(array $block, string $blockId): array
    {
        $data = $block['attrs']['data'] ?? [];

        if (! $data || ! function_exists('acf_setup_meta')) {
            return [];
        }

        \acf_setup_meta($data, $blockId, true);
        $items = \get_field('faq_items') ?: [];
        \acf_reset_meta($blockId);

        $rows = [];

        foreach ((array) $items as $item) {
            $question = self::text($item['faq_question'] ?? '');
            $answer = self::text($item['faq_answer'] ?? '');

            if ($question !== '' && $answer !== '') {
                $rows[] = ['question' => $question, 'answer' => $answer];
            }
        }

        return $rows;
    }

    protected static function text(mixed $value): string
    {
        return trim(\html_entity_decode(\wp_strip_all_tags((string) $value), ENT_QUOTES, 'UTF-8'));
    }
}
