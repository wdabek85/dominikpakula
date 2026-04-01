<?php

/**
 * Booking Admin Calendar — blocked dates management.
 */

namespace App\Booking;

// Add submenu page
add_action('admin_menu', function () {
    add_submenu_page(
        'edit.php?post_type=booking',
        'Zablokowane dni',
        'Zablokowane dni',
        'manage_options',
        'booking-calendar',
        __NAMESPACE__ . '\\render_calendar_page'
    );
});

function render_calendar_page(): void
{
    $blocked = get_option('booking_blocked_dates', []);
    if (! is_array($blocked)) {
        $blocked = [];
    }

    // Get all active bookings
    $bookings = \get_posts([
        'post_type' => 'booking',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ]);

    $bookedDates = [];
    foreach ($bookings as $booking) {
        $status = get_post_meta($booking->ID, '_booking_status', true);
        if ($status === 'cancelled') {
            continue;
        }
        $date = get_post_meta($booking->ID, '_booking_date', true);
        $name = get_post_meta($booking->ID, '_booking_first_name', true) . ' ' . get_post_meta($booking->ID, '_booking_last_name', true);
        if ($date) {
            $bookedDates[date('Y-m-d', strtotime($date))] = trim($name);
        }
    }

    ?>
    <div class="wrap">
        <h1>Kalendarz — zablokowane dni</h1>
        <p>Kliknij na dzień aby go zablokować/odblokować. <span style="color:#d63638">■</span> Zablokowany <span style="color:#2271b1">■</span> Zarezerwowany <span style="color:#ccc">■</span> Przeszły</p>

        <div id="booking-admin-calendar" style="max-width:600px;margin-top:20px;"
             data-blocked='<?php echo esc_attr(wp_json_encode($blocked)); ?>'
             data-booked='<?php echo esc_attr(wp_json_encode($bookedDates)); ?>'
             data-nonce='<?php echo esc_attr(wp_create_nonce('booking_toggle_date')); ?>'>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('booking-admin-calendar');
        if (!container) return;

        let blocked = JSON.parse(container.dataset.blocked || '[]');
        const booked = JSON.parse(container.dataset.booked || '{}');
        const nonce = container.dataset.nonce;
        let currentDate = new Date();

        function render() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const today = new Date();
            today.setHours(0,0,0,0);

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDay = firstDay.getDay() || 7;

            const monthNames = ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec','Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'];

            let html = '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">';
            html += '<button class="button" id="cal-prev">&larr;</button>';
            html += '<strong>' + monthNames[month] + ' ' + year + '</strong>';
            html += '<button class="button" id="cal-next">&rarr;</button>';
            html += '</div>';

            html += '<table class="wp-list-table widefat" style="text-align:center"><thead><tr>';
            ['Pn','Wt','Śr','Cz','Pt','Sb','Nd'].forEach(d => html += '<th style="text-align:center;padding:8px">' + d + '</th>');
            html += '</tr></thead><tbody><tr>';

            for (let i = 1; i < startDay; i++) html += '<td></td>';

            for (let day = 1; day <= lastDay.getDate(); day++) {
                const dateStr = year + '-' + String(month+1).padStart(2,'0') + '-' + String(day).padStart(2,'0');
                const cellDate = new Date(year, month, day);
                const isPast = cellDate < today;
                const isBlocked = blocked.includes(dateStr);
                const isBooked = booked.hasOwnProperty(dateStr);

                let style = 'padding:8px;cursor:pointer;border-radius:4px;';
                let title = '';

                if (isPast) {
                    style += 'background:#f0f0f0;color:#999;cursor:default;';
                } else if (isBooked) {
                    style += 'background:#2271b1;color:#fff;cursor:help;';
                    title = 'Zarezerwowane: ' + booked[dateStr];
                } else if (isBlocked) {
                    style += 'background:#d63638;color:#fff;';
                    title = 'Zablokowany — kliknij aby odblokować';
                } else {
                    style += 'background:#fff;';
                    title = 'Kliknij aby zablokować';
                }

                html += '<td style="' + style + '" data-date="' + dateStr + '" title="' + title + '">' + day + '</td>';

                if ((startDay - 1 + day) % 7 === 0) html += '</tr><tr>';
            }

            html += '</tr></tbody></table>';
            container.innerHTML = html;

            document.getElementById('cal-prev').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                render();
            });
            document.getElementById('cal-next').addEventListener('click', function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                render();
            });

            container.querySelectorAll('td[data-date]').forEach(function(td) {
                td.addEventListener('click', function() {
                    const date = td.dataset.date;
                    const cellDate = new Date(date);
                    const isPast = cellDate < today;
                    const isBooked = booked.hasOwnProperty(date);

                    if (isPast || isBooked) return;

                    fetch(ajaxurl, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        body: 'action=toggle_blocked_date&date=' + date + '&_wpnonce=' + nonce
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.success) {
                            blocked = data.data.blocked;
                            render();
                        }
                    });
                });
            });
        }

        render();
    });
    </script>
    <?php
}

// AJAX handler for toggling blocked dates
add_action('wp_ajax_toggle_blocked_date', function () {
    check_ajax_referer('booking_toggle_date');

    $date = sanitize_text_field($_POST['date'] ?? '');
    if (! $date) {
        wp_send_json_error();
    }

    $dateFormatted = date('Y-m-d', strtotime($date));
    $blocked = get_option('booking_blocked_dates', []);
    if (! is_array($blocked)) {
        $blocked = [];
    }

    if (in_array($dateFormatted, $blocked, true)) {
        $blocked = array_values(array_diff($blocked, [$dateFormatted]));
    } else {
        $blocked[] = $dateFormatted;
    }

    update_option('booking_blocked_dates', $blocked);

    wp_send_json_success(['blocked' => $blocked]);
});
