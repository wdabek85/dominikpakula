<?php
/**
 * Dane strukturalne (16.11.2026): nazwa strony i Knowledge Graph w Rank Math
 * „dominikpakula” → „Dominik Pakuła – stylista męski” (WebSite.name i nazwa firmy w #business).
 * Poprzednie wartości zapisuje w opcji `_mig_20261116_schema_backup` (bez autoload).
 * Idempotentny. Wymaga kodu z app/Schema (motyw).
 *
 * Uruchom: wp eval-file migrations/2026-11-16-schema.php [dry]
 */

$dry = ($args[0] ?? '') === 'dry';
$name = 'Dominik Pakuła – stylista męski';
$keys = ['website_name', 'knowledgegraph_name'];

$titles = get_option('rank-math-options-titles', []);
$changes = [];

foreach ($keys as $key) {
    $old = (string) ($titles[$key] ?? '');
    if ($old === $name) {
        WP_CLI::log("{$key}: już „{$name}” — pomijam");
        continue;
    }
    $changes[$key] = $old;
    WP_CLI::log(($dry ? '[dry] ' : '') . "{$key}: „{$old}” → „{$name}”");
}

if ($changes && ! $dry) {
    if (get_option('_mig_20261116_schema_backup') === false) {
        add_option('_mig_20261116_schema_backup', $changes, '', false);
    }
    foreach (array_keys($changes) as $key) {
        $titles[$key] = $name;
    }
    update_option('rank-math-options-titles', $titles);
}

WP_CLI::success($dry ? 'Podgląd zakończony — nic nie zapisano.' : 'Schema: ustawienia Rank Math gotowe.');
