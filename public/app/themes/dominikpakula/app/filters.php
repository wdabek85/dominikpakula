<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Encje HTML w tytułach i zajawkach → zwykłe znaki.
 *
 * WordPress na `the_title` / `get_the_excerpt` puszcza wptexturize, który zamienia
 * dywiz na encję półpauzy (`-` → `&#8211;`), cudzysłowy na drukarskie itd. Blade
 * wypisuje zmienne przez `{{ }}`, czyli htmlspecialchars — a ten escape'uje `&`
 * w encji na `&amp;`, przez co na stronie widać dosłowne „&#8211;”.
 *
 * Dekodujemy encje z powrotem do znaków (`–`), a Blade escape'uje je poprawnie.
 * Priorytet 11 — po wptexturize (10). Działa też dla `&amp;` w tytułach typu
 * „Tom & Jerry”: dekodowanie daje `&`, Blade zwraca `&amp;`, czyli poprawny HTML.
 */
add_filter('the_title', __NAMESPACE__ . '\\decode_display_entities', 11);
add_filter('get_the_excerpt', __NAMESPACE__ . '\\decode_display_entities', 11);
add_filter('single_post_title', __NAMESPACE__ . '\\decode_display_entities', 11);

function decode_display_entities($text)
{
    if (! is_string($text) || $text === '') {
        return $text;
    }

    return html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}
