<?php
/**
 * Migracja treści po audycie 28.09.2026 — idempotentna, do odpalenia na local / staging / prod
 * PO wdrożeniu kodu (acf-json z grupami musi już być na serwerze).
 *
 *   wp eval-file migrations/2026-09-28-audyt.php            # wykonaj
 *   wp eval-file migrations/2026-09-28-audyt.php dry        # tylko raport
 *
 * Kroki:
 *  2. Ustawienia strony: wpisz aktualne dane kontaktowe do pól (żeby były widoczne w panelu).
 *  3. Usługi: kolejność, nazwy, „Karta usługi” (z dotychczasowych bloków), literówki.
 *  4. Bloki: services / offer / local-seo przełączone na dane z CPT; pole offer_button_url_ → offer_button_url.
 *  5. Grupy pól ACF: usuń kopie z bazy, które są już w acf-json (po sprawdzeniu kluczy pól)
 *     + grupy usuniętych bloków bloga.
 */

$dry = in_array('dry', $args ?? [], true);
$log = fn (string $m) => WP_CLI::log(($dry ? '[dry] ' : '') . $m);

// Backup zmienianych treści stron → <bedrock>/sql/backup (katalog sql/ jest w .gitignore).
$backupDir = dirname(ABSPATH, 2) . '/sql/backup';
if (! $dry) {
    wp_mkdir_p($backupDir);
}

$jsonDir = get_stylesheet_directory() . '/acf-json/';

/* ------------------------------------------------------- 2. Ustawienia strony */

$settings = [
    'contact_email' => 'kontakt@meskistylista.pl',
    'contact_phone' => '+48 577 190 949',
    'contact_phone_link' => '+48577190949',
    'contact_address_line1' => 'Kraków',
    'social_instagram_url' => 'https://www.instagram.com/dpakula_stylist/',
    'social_instagram_handle' => 'dpakula_stylist',
];
foreach ($settings as $name => $value) {
    if (get_field($name, 'option')) {
        continue; // już wpisane w panelu — nie nadpisujemy
    }
    $log("Ustawienia: {$name} = {$value}");
    $dry || update_field($name, $value, 'option');
}

/* ------------------------------------------------------------------ 3. Usługi */

$byPath = fn (string $path) => get_page_by_path($path, OBJECT, 'service');
$ids = [];
foreach (['przeglad-szafy', 'zakupy-ze-stylista', 'zakupy-online', 'stylizacja-okazjonalna', 'przeglad-szafy-zakupy'] as $slug) {
    $post = $byPath($slug);
    if (! $post) {
        WP_CLI::error("Brak usługi {$slug}");
    }
    $ids[$slug] = $post->ID;
}

// Teksty kart przenosimy z bloków, w których dziś są wpisane ręcznie (strona główna + Oferta).
$blockData = function (int $pageId, string $blockName): array {
    foreach (parse_blocks(get_post_field('post_content', $pageId)) as $block) {
        if ($block['blockName'] === $blockName) {
            return $block['attrs']['data'] ?? [];
        }
    }
    return [];
};
$clean = fn ($text) => trim(preg_replace('/\s+/u', ' ', (string) $text));
$home = (int) get_option('page_on_front');
$offerPage = get_page_by_path('uslugi');
$homeOffer = $blockData($home, 'acf/offer');
$homeServices = $blockData($home, 'acf/services');
$fullOffer = $offerPage ? $blockData($offerPage->ID, 'acf/offer') : [];

// Kolejność kart w dotychczasowych blokach (indeks repeatera) → usługa
$offerIndex = ['przeglad-szafy' => 0, 'zakupy-ze-stylista' => 1, 'zakupy-online' => 2, 'stylizacja-okazjonalna' => 3];
$problemIndex = ['przeglad-szafy' => 0, 'zakupy-ze-stylista' => 1, 'stylizacja-okazjonalna' => 2];

$services = [
    'przeglad-szafy' => ['order' => 10, 'title' => 'Przegląd szafy', 'card_title' => '', 'icon' => 'przeglad-szafy.png'],
    'zakupy-ze-stylista' => ['order' => 20, 'title' => 'Zakupy ze stylistą', 'card_title' => '', 'icon' => 'torba-zakupy-problem.png', 'sidebar_title' => 'Zakupy ze stylistą'],
    'zakupy-online' => ['order' => 30, 'title' => 'Zakupy online ze stylistą', 'card_title' => 'Zakupy online', 'icon' => 'zakupy-online.png', 'sidebar_title' => 'Zakupy online ze stylistą'],
    'stylizacja-okazjonalna' => ['order' => 40, 'title' => 'Stylizacja okazjonalna', 'card_title' => '', 'icon' => 'stylizacja-okazjonalna.png', 'sidebar_title' => 'Stylizacja okazjonalna'],
    'przeglad-szafy-zakupy' => [
        'order' => 50, 'title' => 'Przegląd szafy + zakupy', 'card_title' => '', 'icon' => 'ikona-szafa-stylizacja.png',
        // Nie było tej usługi w żadnym bloku — krótki opis z jej opisu w sidebarze
        'excerpt' => 'Przegląd szafy i wspólne zakupy w jednym — porządek w tym, co masz, i tylko brakujące elementy.',
    ],
];

$iconId = function (string $file): int {
    global $wpdb;
    return (int) $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s ORDER BY post_id LIMIT 1",
        '%/' . $wpdb->esc_like($file)
    ));
};

foreach ($services as $slug => $cfg) {
    $id = $ids[$slug];

    $update = ['ID' => $id];
    if ((int) get_post_field('menu_order', $id) !== $cfg['order']) {
        $update['menu_order'] = $cfg['order'];
    }
    if (get_the_title($id) !== $cfg['title']) {
        $update['post_title'] = $cfg['title'];
    }
    if (count($update) > 1) {
        $log("Usługa {$slug}: " . json_encode(array_diff_key($update, ['ID' => 1]), JSON_UNESCAPED_UNICODE));
        $dry || wp_update_post(wp_slash($update));
    }

    if (! empty($cfg['sidebar_title']) && get_field('service_sidebar_title', $id) !== $cfg['sidebar_title']) {
        $log("Usługa {$slug}: tytuł w sidebarze → {$cfg['sidebar_title']}");
        $dry || update_field('service_sidebar_title', $cfg['sidebar_title'], $id);
    }

    // Karta usługi — tylko puste pola (nie nadpisujemy tego, co ktoś już wpisał w panelu)
    $i = $offerIndex[$slug] ?? null;
    $p = $problemIndex[$slug] ?? null;
    $card = [
        'service_card_title' => $cfg['card_title'],
        'service_card_problem' => $p !== null ? $clean($homeServices["services_cards_{$p}_services_card_problem"] ?? '') : '',
        'service_card_excerpt' => $cfg['excerpt'] ?? ($i !== null ? $clean($homeOffer["offer_cards_{$i}_offer_card_description"] ?? '') : ''),
        'service_card_description' => $i !== null ? $clean($fullOffer["offer_cards_{$i}_offer_card_description"] ?? '') : $clean(get_field('service_sidebar_description', $id)),
        'service_card_icon' => $iconId($cfg['icon']),
    ];
    foreach ($card as $name => $value) {
        if (! $value || get_field($name, $id)) {
            continue;
        }
        $log("Usługa {$slug}: {$name} = " . mb_substr((string) $value, 0, 70));
        $dry || update_field($name, $value, $id);
    }
}

// Podstrony miast: kolejność, literówka w Krakowie, jeden format ceny
$cities = [
    'zakupy-ze-stylista/krakow' => ['order' => 10, 'title' => 'Zakupy ze stylistą Kraków', 'sidebar_title' => 'Zakupy ze stylistą w Krakowie'],
    'zakupy-ze-stylista/warszawa' => ['order' => 20, 'price' => '1800 zł'],
];
foreach ($cities as $path => $cfg) {
    $post = $byPath($path);
    if (! $post) {
        WP_CLI::warning("Brak podstrony {$path}");
        continue;
    }
    $update = ['ID' => $post->ID];
    if ((int) $post->menu_order !== $cfg['order']) {
        $update['menu_order'] = $cfg['order'];
    }
    if (! empty($cfg['title']) && $post->post_title !== $cfg['title']) {
        $update['post_title'] = $cfg['title'];
    }
    if (count($update) > 1) {
        $log("{$path}: " . json_encode(array_diff_key($update, ['ID' => 1]), JSON_UNESCAPED_UNICODE));
        $dry || wp_update_post(wp_slash($update));
    }
    if (! empty($cfg['sidebar_title']) && get_field('service_sidebar_title', $post->ID) !== $cfg['sidebar_title']) {
        $log("{$path}: tytuł w sidebarze → {$cfg['sidebar_title']}");
        $dry || update_field('service_sidebar_title', $cfg['sidebar_title'], $post->ID);
    }
    if (! empty($cfg['price']) && get_field('service_price', $post->ID) !== $cfg['price']) {
        $log("{$path}: cena → {$cfg['price']}");
        $dry || update_field('service_price', $cfg['price'], $post->ID);
    }
}

/* ------------------------------------------------------------------ 4. Bloki */

// Klucze pól prosto z acf-json — po usunięciu kopii grup z bazy (krok 1) cache ACF
// w tym samym procesie nie widzi jeszcze grup z plików.
$fieldKey = function (string $block, string $name) use ($jsonDir): string {
    foreach (glob($jsonDir . '*.json') as $file) {
        $group = json_decode(file_get_contents($file), true);
        $isBlock = false;
        foreach ($group['location'] ?? [] as $rules) {
            foreach ($rules as $rule) {
                $isBlock = $isBlock || (($rule['param'] ?? '') === 'block' && ($rule['value'] ?? '') === $block);
            }
        }
        if (! $isBlock) {
            continue;
        }
        foreach ($group['fields'] ?? [] as $field) {
            if ($field['name'] === $name) {
                return $field['key'];
            }
        }
    }
    WP_CLI::error("Brak pola {$name} dla {$block} — czy acf-json jest wdrożony?");
};

$core = [$ids['przeglad-szafy'], $ids['zakupy-ze-stylista'], $ids['stylizacja-okazjonalna']];
$fourOffer = [$ids['przeglad-szafy'], $ids['zakupy-ze-stylista'], $ids['zakupy-online'], $ids['stylizacja-okazjonalna']];

// strona => blok => [pole => wartość]
$plan = [
    $home => [
        'acf/services' => ['services_source' => 'pick', 'services_items' => $core],
        'acf/offer' => ['offer_source' => 'pick', 'offer_services' => $fourOffer, 'offer_button_url' => home_url('/uslugi/')],
    ],
];
if ($offerPage) {
    $plan[$offerPage->ID] = [
        'acf/services' => ['services_source' => 'pick', 'services_items' => $core],
        'acf/offer' => ['offer_source' => 'all'],
    ];
}
if ($voucherPage = get_page_by_path('voucher')) {
    $plan[$voucherPage->ID] = ['acf/offer' => ['offer_source' => 'all']];
}
$plan[$ids['zakupy-ze-stylista']] = ['acf/local-seo' => ['local_source' => 'children']];

// Wszystkie bloki offer: przenieś wartość z pola z literówką
foreach (get_posts(['post_type' => 'any', 'post_status' => 'any', 'posts_per_page' => -1, 's' => 'offer_button_url_']) as $post) {
    $plan[$post->ID]['acf/offer'] = $plan[$post->ID]['acf/offer'] ?? [];
}

foreach ($plan as $postId => $blocks) {
    $content = get_post_field('post_content', $postId);
    $parsed = parse_blocks($content);
    $changed = [];

    foreach ($parsed as &$block) {
        if (! isset($blocks[$block['blockName']])) {
            continue;
        }
        $data = &$block['attrs']['data'];

        if (array_key_exists('offer_button_url_', $data)) {
            $data['offer_button_url'] = $data['offer_button_url'] ?? $data['offer_button_url_'];
            $data['_offer_button_url'] = $data['_offer_button_url_'] ?? '';
            unset($data['offer_button_url_'], $data['_offer_button_url_']);
            $changed[] = 'offer_button_url_ → offer_button_url';
        }

        foreach ($blocks[$block['blockName']] as $name => $value) {
            $value = is_array($value) ? array_map('strval', $value) : $value;
            if (($data[$name] ?? null) === $value) {
                continue;
            }
            $data[$name] = $value;
            $data["_{$name}"] = $fieldKey($block['blockName'], $name);
            $changed[] = "{$block['blockName']}.{$name}";
        }
        unset($data);
    }
    unset($block);

    if (! $changed) {
        continue;
    }

    $log(get_the_title($postId) . " ({$postId}): " . implode(', ', array_unique($changed)));
    if (! $dry) {
        file_put_contents("{$backupDir}/post-{$postId}-" . date('Ymd-His') . '.html', $content);
        wp_update_post(wp_slash(['ID' => $postId, 'post_content' => serialize_blocks($parsed)]));
    }
}

/* ------------------------------------------------------------------ 5. ACF (na końcu: wcześniejsze kroki potrzebują pełnych definicji pól w tym procesie) */

$removedBlocks = ['group_69f1bcd804e87', 'group_69f1bd1ecdd86', 'group_69f1bd9b368f1']; // pullquote, callout, personal-quote

// UWAGA: nie używać acf_delete_field_group() — przy włączonym local JSON ACF kasuje też plik
// z acf-json/. Usuwamy tylko wiersze z bazy (grupa + jej pola, rekurencyjnie).
$deleteDbGroup = function (int $groupId): void {
    global $wpdb;
    $ids = [$groupId];
    $parents = [$groupId];
    while ($parents) {
        $in = implode(',', array_map('intval', $parents));
        $parents = $wpdb->get_col("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'acf-field' AND post_parent IN ({$in})");
        $ids = array_merge($ids, $parents);
    }
    $in = implode(',', array_map('intval', $ids));
    $wpdb->query("DELETE FROM {$wpdb->postmeta} WHERE post_id IN ({$in})");
    $wpdb->query("DELETE FROM {$wpdb->posts} WHERE ID IN ({$in}) AND post_type IN ('acf-field-group', 'acf-field')");
    array_map('clean_post_cache', $ids);
};

$collectKeys = function (array $fields) use (&$collectKeys): array {
    $keys = [];
    foreach ($fields as $field) {
        $keys[] = $field['key'];
        if (! empty($field['sub_fields'])) {
            $keys = array_merge($keys, $collectKeys($field['sub_fields']));
        }
    }
    return $keys;
};

foreach (get_posts(['post_type' => 'acf-field-group', 'post_status' => ['publish', 'acf-disabled'], 'posts_per_page' => -1]) as $groupPost) {
    $key = $groupPost->post_name;

    if (in_array($key, $removedBlocks, true)) {
        $log("ACF: usuwam grupę usuniętego bloku {$key} ({$groupPost->post_title})");
        $dry || $deleteDbGroup($groupPost->ID);
        continue;
    }

    $file = $jsonDir . $key . '.json';
    if (! file_exists($file)) {
        WP_CLI::warning("ACF: {$key} ({$groupPost->post_title}) nie ma pliku JSON — zostawiam w bazie");
        continue;
    }

    $json = json_decode(file_get_contents($file), true);
    $dbKeys = $collectKeys(acf_get_fields($groupPost->ID) ?: []);
    $missing = array_diff($dbKeys, $collectKeys($json['fields'] ?? []));

    if ($missing) {
        WP_CLI::warning("ACF: {$key} — w bazie są pola, których nie ma w JSON (" . implode(', ', $missing) . ") — zostawiam");
        continue;
    }

    $log("ACF: {$key} ({$groupPost->post_title}) → tylko acf-json, usuwam kopię z bazy");
    $dry || $deleteDbGroup($groupPost->ID);
}

WP_CLI::success($dry ? 'Dry run — nic nie zapisano.' : "Gotowe. Backup treści: {$backupDir}");
