<?php
/**
 * Wspólne helpery migracji treści: budowanie bloków ACF w formacie zapisu edytora.
 * require_once z pliku migracji.
 */

if (! function_exists('mig_block')) {
    /**
     * Pola grupy przypiętej do bloku: name => field (z sub_fields dla repeaterów).
     */
    function mig_block_fields(string $block): array
    {
        $fields = [];
        foreach (acf_get_field_groups(['block' => $block]) as $group) {
            foreach (acf_get_fields($group) as $field) {
                $fields[$field['name']] = $field;
            }
        }
        if (! $fields) {
            WP_CLI::error("Brak pól ACF dla {$block}");
        }
        return $fields;
    }

    /**
     * Dane bloku ACF w formacie zapisu edytora: wartość + `_nazwa` => klucz pola.
     * Repeatery: lista wierszy [sub_name => value].
     */
    function mig_block(string $name, array $values): string
    {
        $fields = mig_block_fields("acf/{$name}");
        $data = [];

        foreach ($values as $key => $value) {
            if (! isset($fields[$key])) {
                WP_CLI::error("Blok {$name}: nieznane pole {$key}");
            }
            $field = $fields[$key];

            if ($field['type'] === 'repeater') {
                $subs = array_column($field['sub_fields'], 'key', 'name');
                foreach (array_values($value) as $i => $row) {
                    foreach ($row as $sub => $subValue) {
                        if (! isset($subs[$sub])) {
                            WP_CLI::error("Blok {$name}: nieznane pod-pole {$key}.{$sub}");
                        }
                        $data["{$key}_{$i}_{$sub}"] = $subValue;
                        $data["_{$key}_{$i}_{$sub}"] = $subs[$sub];
                    }
                }
                $data[$key] = count($value);
            } else {
                $data[$key] = $value;
            }
            $data["_{$key}"] = $field['key'];
        }

        $attrs = ['name' => "acf/{$name}", 'data' => $data, 'mode' => 'preview'];

        return '<!-- wp:acf/' . $name . ' ' . serialize_block_attributes($attrs) . ' /-->';
    }
}
