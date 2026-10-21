<?php

namespace App\Services;

/**
 * Wspólna logika słowniczka (CPT glossary): grupowanie haseł po literze,
 * polskie sortowanie (Ł po L, Ś po S), kotwice liter i odmiana licznika.
 *
 * Używane przez archiwum (/slowniczek/), sidebar pojedynczego hasła i zajawkę w Bazie Wiedzy.
 */
class Glossary
{
    /**
     * Litery w pasku nawigacji — zawsze widoczne, nawet bez haseł.
     */
    public const ALPHABET = [
        'A', 'B', 'C', 'Ć', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'Ł', 'M', 'N',
        'O', 'Ó', 'P', 'Q', 'R', 'S', 'Ś', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Ź', 'Ż',
    ];

    /**
     * Wszystkie opublikowane hasła (dla sidebaru pojedynczego hasła).
     *
     * @return \WP_Post[]
     */
    public static function allPosts(): array
    {
        return \get_posts([
            'post_type' => 'glossary',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'no_found_rows' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);
    }

    /**
     * Hasła pogrupowane po literze, w kolejności alfabetu.
     *
     * @param  \WP_Post[]  $posts
     * @param  int  $currentId  ID bieżącego hasła — oznaczane jako current, jego grupa jako open
     * @return array<int, array{letter: string, id: string, count: string, open: bool, terms: array<int, array{title: string, link: string, current: bool}>}>
     */
    public static function groups(array $posts, int $currentId = 0): array
    {
        $byLetter = [];
        foreach ($posts as $post) {
            $title = trim(get_the_title($post));
            if ($title === '') {
                continue;
            }

            $byLetter[self::firstLetter($title)][] = [
                'title' => $title,
                'link' => get_permalink($post) ?: '',
                'current' => $currentId && $post->ID === $currentId,
            ];
        }

        $compare = self::comparator();

        uksort($byLetter, function (string $a, string $b) use ($compare) {
            $ia = array_search($a, self::ALPHABET, true);
            $ib = array_search($b, self::ALPHABET, true);

            // Znaki spoza alfabetu (cyfry itp.) lądują na końcu.
            if ($ia === false || $ib === false) {
                return ($ia === false) <=> ($ib === false) ?: $compare($a, $b);
            }

            return $ia <=> $ib;
        });

        $groups = [];
        foreach ($byLetter as $letter => $terms) {
            usort($terms, fn (array $a, array $b) => $compare($a['title'], $b['title']));

            $groups[] = [
                'letter' => (string) $letter,
                'id' => self::anchorId((string) $letter),
                'count' => self::countLabel(count($terms)),
                'open' => in_array(true, array_column($terms, 'current'), true),
                'terms' => $terms,
            ];
        }

        return $groups;
    }

    /**
     * Pasek alfabetu: stałe litery + ewentualne dodatkowe z haseł (np. cyfry).
     *
     * @return array<int, array{letter: string, id: string, active: bool}>
     */
    public static function letters(array $groups): array
    {
        $used = array_column($groups, 'letter');
        $all = array_merge(self::ALPHABET, array_diff($used, self::ALPHABET));

        return array_map(fn (string $letter) => [
            'letter' => $letter,
            'id' => self::anchorId($letter),
            'active' => in_array($letter, $used, true),
        ], $all);
    }

    /**
     * Kotwica litery. Polskie znaki mają własne nazwy, żeby Ł nie kolidowało z L, a Ź z Ż.
     */
    public static function anchorId(string $letter): string
    {
        $special = [
            '#' => 'inne',
            'Ą' => 'a-ogonek',
            'Ć' => 'c-kreska',
            'Ę' => 'e-ogonek',
            'Ł' => 'l-kreska',
            'Ń' => 'n-kreska',
            'Ó' => 'o-kreska',
            'Ś' => 's-kreska',
            'Ź' => 'z-kreska',
            'Ż' => 'z-kropka',
        ];

        $slug = $special[$letter] ?? (sanitize_title($letter) ?: md5($letter));

        return 'litera-' . $slug;
    }

    /**
     * Polska odmiana: 1 hasło, 2–4 hasła, 5+ haseł (12–14 haseł).
     */
    public static function countLabel(int $count): string
    {
        $mod10 = $count % 10;
        $mod100 = $count % 100;

        $word = match (true) {
            $count === 1 => 'hasło',
            $mod10 >= 2 && $mod10 <= 4 && ($mod100 < 12 || $mod100 > 14) => 'hasła',
            default => 'haseł',
        };

        return $count . ' ' . $word;
    }

    protected static function firstLetter(string $title): string
    {
        $letter = mb_strtoupper(mb_substr($title, 0, 1));

        return preg_match('/\p{L}/u', $letter) ? $letter : '#';
    }

    /**
     * Porównanie po polsku (intl), fallback bez ogonków.
     */
    protected static function comparator(): \Closure
    {
        $collator = class_exists(\Collator::class) ? new \Collator('pl_PL') : null;

        return fn (string $a, string $b) => $collator
            ? $collator->compare($a, $b)
            : strcasecmp(remove_accents($a), remove_accents($b));
    }
}
