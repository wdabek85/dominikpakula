/**
 * Admin booking calendar — toggle blocked dates via AJAX.
 *
 * Data on container:
 *   data-blocked  JSON array of blocked YYYY-MM-DD
 *   data-booked   JSON object { "YYYY-MM-DD": "Client Name" }
 *   data-nonce    nonce for wp_ajax_toggle_blocked_date
 *   data-ajaxurl  admin-ajax.php URL
 */

document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById('booking-admin-calendar');
  if (!container) return;

  let blocked = JSON.parse(container.dataset.blocked || '[]');
  const booked = JSON.parse(container.dataset.booked || '{}');
  const nonce = container.dataset.nonce;
  const ajaxurl = container.dataset.ajaxurl;
  let currentDate = new Date();

  const today = new Date();
  today.setHours(0, 0, 0, 0);

  function parseLocalDate(str) {
    const [y, m, d] = str.split('-').map(Number);
    return new Date(y, m - 1, d);
  }

  function render() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = firstDay.getDay() || 7;

    const monthNames = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];

    let html = '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">';
    html += '<button type="button" class="button" id="cal-prev">&larr;</button>';
    html += '<strong>' + monthNames[month] + ' ' + year + '</strong>';
    html += '<button type="button" class="button" id="cal-next">&rarr;</button>';
    html += '</div>';

    html += '<table class="wp-list-table widefat" style="text-align:center"><thead><tr>';
    ['Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb', 'Nd'].forEach((d) => {
      html += '<th style="text-align:center;padding:8px">' + d + '</th>';
    });
    html += '</tr></thead><tbody><tr>';

    for (let i = 1; i < startDay; i++) html += '<td></td>';

    for (let day = 1; day <= lastDay.getDate(); day++) {
      const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
      const cellDate = new Date(year, month, day);
      const isPast = cellDate < today;
      const isBlocked = blocked.includes(dateStr);
      const isBooked = Object.prototype.hasOwnProperty.call(booked, dateStr);

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

    document.getElementById('cal-prev').addEventListener('click', function () {
      currentDate.setMonth(currentDate.getMonth() - 1);
      render();
    });
    document.getElementById('cal-next').addEventListener('click', function () {
      currentDate.setMonth(currentDate.getMonth() + 1);
      render();
    });

    container.querySelectorAll('td[data-date]').forEach(function (td) {
      td.addEventListener('click', function () {
        const date = td.dataset.date;
        const cellDate = parseLocalDate(date);
        const isPast = cellDate < today;
        const isBooked = Object.prototype.hasOwnProperty.call(booked, date);

        if (isPast || isBooked) return;

        fetch(ajaxurl, {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'action=toggle_blocked_date&date=' + encodeURIComponent(date) + '&_wpnonce=' + encodeURIComponent(nonce),
        })
          .then((r) => r.json())
          .then((data) => {
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
