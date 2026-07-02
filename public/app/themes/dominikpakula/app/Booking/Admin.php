<?php

/**
 * Booking Admin UI — columns, meta box, quick actions.
 */

namespace App\Booking;

// Custom columns
add_filter('manage_booking_posts_columns', function ($columns) {
    unset($columns['date']);

    return array_merge($columns, [
        'booking_date' => 'Data wizyty',
        'booking_service' => 'Usługa',
        'booking_name' => 'Klient',
        'booking_email' => 'E-mail',
        'booking_phone' => 'Telefon',
        'booking_status' => 'Status',
    ]);
});

add_action('manage_booking_posts_custom_column', function ($column, $postId) {
    switch ($column) {
        case 'booking_date':
            $date = get_post_meta($postId, '_booking_date', true);
            echo $date ? date_i18n('j F Y', strtotime($date)) : '—';
            break;
        case 'booking_service':
            echo esc_html(get_post_meta($postId, '_booking_service', true) ?: '—');
            break;
        case 'booking_name':
            $first = get_post_meta($postId, '_booking_first_name', true);
            $last = get_post_meta($postId, '_booking_last_name', true);
            echo esc_html(trim($first . ' ' . $last) ?: '—');
            break;
        case 'booking_email':
            echo esc_html(get_post_meta($postId, '_booking_email', true) ?: '—');
            break;
        case 'booking_phone':
            echo esc_html(get_post_meta($postId, '_booking_phone', true) ?: '—');
            break;
        case 'booking_status':
            $status = get_post_meta($postId, '_booking_status', true) ?: 'pending';
            $labels = [
                'pending' => '🟡 Oczekuje',
                'confirmed' => '🟢 Potwierdzona',
                'cancelled' => '🔴 Anulowana',
            ];
            echo $labels[$status] ?? $status;
            break;
    }
}, 10, 2);

// Row actions — cancel / restore
add_filter('post_row_actions', function ($actions, $post) {
    if ($post->post_type !== 'booking') {
        return $actions;
    }

    $status = get_post_meta($post->ID, '_booking_status', true);
    $nonce = wp_create_nonce('booking_toggle_' . $post->ID);

    if ($status !== 'cancelled') {
        $url = admin_url('admin-post.php?action=booking_cancel&id=' . $post->ID . '&_wpnonce=' . $nonce);
        $actions['cancel_booking'] = '<a href="' . esc_url($url) . '" style="color:#d63638">Anuluj rezerwację</a>';
    } else {
        $url = admin_url('admin-post.php?action=booking_restore&id=' . $post->ID . '&_wpnonce=' . $nonce);
        $actions['restore_booking'] = '<a href="' . esc_url($url) . '" style="color:#00a32a">Przywróć rezerwację</a>';
    }

    return $actions;
}, 10, 2);

// Handle cancel
add_action('admin_post_booking_cancel', function () {
    $id = (int) ($_GET['id'] ?? 0);
    check_admin_referer('booking_toggle_' . $id);
    update_post_meta($id, '_booking_status', 'cancelled');
    wp_redirect(admin_url('edit.php?post_type=booking'));
    exit;
});

// Handle restore
add_action('admin_post_booking_restore', function () {
    $id = (int) ($_GET['id'] ?? 0);
    check_admin_referer('booking_toggle_' . $id);
    update_post_meta($id, '_booking_status', 'confirmed');
    wp_redirect(admin_url('edit.php?post_type=booking'));
    exit;
});

// Meta box on edit screen
add_action('add_meta_boxes', function () {
    add_meta_box(
        'booking_details',
        'Szczegóły rezerwacji',
        __NAMESPACE__ . '\\render_meta_box',
        'booking',
        'normal',
        'high'
    );
});

function render_meta_box($post): void
{
    $fields = [
        '_booking_date' => ['label' => 'Data wizyty', 'type' => 'date'],
        '_booking_service' => ['label' => 'Usługa', 'type' => 'service_select'],
        '_booking_first_name' => ['label' => 'Imię', 'type' => 'text'],
        '_booking_last_name' => ['label' => 'Nazwisko', 'type' => 'text'],
        '_booking_email' => ['label' => 'E-mail', 'type' => 'email'],
        '_booking_phone' => ['label' => 'Telefon', 'type' => 'text'],
        '_booking_status' => ['label' => 'Status', 'type' => 'status_select'],
    ];

    wp_nonce_field('booking_meta_save', '_booking_meta_nonce');

    echo '<table class="form-table"><tbody>';

    foreach ($fields as $key => $field) {
        $value = get_post_meta($post->ID, $key, true);
        echo '<tr><th><label for="' . esc_attr($key) . '">' . esc_html($field['label']) . '</label></th><td>';

        if ($field['type'] === 'service_select') {
            $services = get_booking_services();
            echo '<select name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" class="regular-text">';
            echo '<option value="">— Wybierz usługę —</option>';
            foreach ($services as $s) {
                $selected = selected($value, $s['title'], false);
                echo '<option value="' . esc_attr($s['title']) . '" ' . $selected . '>' . esc_html($s['title']) . '</option>';
            }
            echo '</select>';
        } elseif ($field['type'] === 'status_select') {
            $statuses = ['pending' => 'Oczekuje', 'confirmed' => 'Potwierdzona', 'cancelled' => 'Anulowana'];
            echo '<select name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" class="regular-text">';
            foreach ($statuses as $k => $label) {
                $selected = selected($value, $k, false);
                echo '<option value="' . esc_attr($k) . '" ' . $selected . '>' . esc_html($label) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<input type="' . esc_attr($field['type']) . '" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . esc_attr($value) . '" class="regular-text">';
        }

        echo '</td></tr>';
    }

    echo '</tbody></table>';
}

// Save meta box
add_action('save_post_booking', function ($postId) {
    if (! isset($_POST['_booking_meta_nonce']) || ! wp_verify_nonce($_POST['_booking_meta_nonce'], 'booking_meta_save')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    $keys = ['_booking_date', '_booking_service', '_booking_first_name', '_booking_last_name', '_booking_email', '_booking_phone', '_booking_status'];

    foreach ($keys as $key) {
        if (isset($_POST[$key])) {
            update_post_meta($postId, $key, sanitize_text_field($_POST[$key]));
        }
    }
});
