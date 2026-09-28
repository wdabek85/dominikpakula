<?php
/**
 * Rank Math: frazy „Przegląd szafy + zakupy” bez fraz innych usług (kanibalizacja).
 * Było: m.in. „przegląd szafy męskiej” (fraza strony Przegląd szafy) oraz „zakupy ze stylistą męskim”,
 * „stylista męski zakupy” (frazy strony Zakupy ze stylistą). Zostają tylko frazy pakietu.
 * Idempotentny.
 *
 * Uruchom: wp eval-file migrations/2026-09-28-seo-przeglad-zakupy.php
 */

$post = get_page_by_path('przeglad-szafy-zakupy', OBJECT, 'service');
if (! $post) {
    WP_CLI::error('Brak usługi przeglad-szafy-zakupy.');
}

$keywords = 'przegląd szafy i zakupy ze stylistą,przegląd szafy z zakupami,przegląd szafy i zakupy,pakiet przegląd szafy i zakupy';
$before = get_post_meta($post->ID, 'rank_math_focus_keyword', true);

if ($before === $keywords) {
    WP_CLI::success('Frazy już ustawione — bez zmian.');
    return;
}

update_post_meta($post->ID, 'rank_math_focus_keyword', $keywords);
WP_CLI::log("Było:  {$before}");
WP_CLI::success("Jest:  {$keywords}");
