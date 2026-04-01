/**
 * Booking Modal — Booksy-style popup
 *
 * Steps: 1) Select service  2) Calendar  3) Form + GDPR  4) Confirmation
 * Triggers: any element with .booking-trigger class
 * data-service="Name" on trigger skips step 1
 */
export default function booking() {
  const modal = document.getElementById('booking-modal');
  if (!modal || !window.bookingData) return;

  const { restUrl, nonce, services } = window.bookingData;

  let currentStep = 1;
  let selectedService = null;
  let selectedDate = null;
  let calendarDate = new Date();
  let availabilityCache = {};

  // DOM
  const content = document.getElementById('booking-content');
  const servicesList = document.getElementById('booking-services-list');
  const calendar = document.getElementById('booking-calendar');
  const form = document.getElementById('booking-form');
  const formError = document.getElementById('booking-form-error');
  const backBtn = document.getElementById('booking-back');
  let skippedStep1 = false;

  // --- Open / Close ---
  function open(preselectedService = null) {
    availabilityCache = {};
    selectedService = preselectedService;
    selectedDate = null;
    calendarDate = new Date();

    if (selectedService) {
      skippedStep1 = true;
      goToStep(2);
    } else {
      skippedStep1 = false;
      goToStep(1);
    }

    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
  }

  function close() {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
  }

  // Triggers
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.booking-trigger');
    if (trigger) {
      e.preventDefault();
      const service = trigger.dataset.service || null;
      open(service);
    }
  });

  modal.querySelectorAll('[data-booking-close]').forEach((el) => {
    el.addEventListener('click', close);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
  });

  // --- Steps ---
  function goToStep(step) {
    currentStep = step;

    modal.querySelectorAll('[data-booking-step]').forEach((el) => {
      el.classList.toggle('hidden', el.dataset.bookingStep !== String(step));
    });

    // Update step indicators
    modal.querySelectorAll('[data-step-dot]').forEach((dot) => {
      const dotStep = parseInt(dot.dataset.stepDot);
      const isActive = dotStep <= step;
      dot.classList.toggle('bg-primary', isActive);
      dot.classList.toggle('text-white', isActive);
      dot.classList.toggle('bg-gray-200', !isActive);
      dot.classList.toggle('text-gray-400', !isActive);
    });

    modal.querySelectorAll('[data-step-label]').forEach((label) => {
      const labelStep = parseInt(label.dataset.stepLabel);
      label.classList.toggle('text-black', labelStep <= step);
      label.classList.toggle('text-gray-400', labelStep > step);
    });

    // Show/hide back button
    if (backBtn) {
      const showBack = step === 2 || step === 3;
      backBtn.classList.toggle('hidden', !showBack);
    }

    if (step === 1) renderServices();
    if (step === 2) renderCalendar();
    if (step === 3) renderFormBadges();
  }

  // Back button
  if (backBtn) {
    backBtn.addEventListener('click', () => {
      if (currentStep === 3) goToStep(2);
      else if (currentStep === 2) goToStep(1);
    });
  }

  // Change service button (on calendar step)
  const changeServiceBtn = document.getElementById('booking-change-service');
  if (changeServiceBtn) {
    changeServiceBtn.addEventListener('click', () => {
      skippedStep1 = false;
      goToStep(1);
    });
  }

  // --- Step 1: Services ---
  function renderServices() {
    servicesList.innerHTML = '';

    services.forEach((s) => {
      const card = document.createElement('button');
      card.className = 'w-full text-left border border-gray-200 rounded-sm p-4 hover:border-primary hover:bg-gray-50 transition-colors flex items-center justify-between gap-4';
      card.innerHTML = `
        <div class="flex flex-col gap-1 min-w-0">
          <span class="font-poppins font-semibold text-sm text-black">${s.title}</span>
          ${s.excerpt ? `<span class="font-poppins text-xs text-gray-500 leading-relaxed">${s.excerpt}</span>` : ''}
        </div>
        <div class="flex flex-col items-end gap-1 shrink-0">
          ${s.price ? `<span class="font-poppins font-semibold text-base text-primary">${s.price}</span>` : ''}
          <a href="${s.url}" target="_blank" class="font-poppins text-[10px] text-primary underline" onclick="event.stopPropagation()">Dowiedz się więcej</a>
        </div>
      `;

      card.addEventListener('click', () => {
        selectedService = s.title;
        goToStep(2);
      });

      servicesList.appendChild(card);
    });
  }

  // --- Step 2: Calendar ---
  async function renderCalendar() {
    const badge = document.getElementById('booking-selected-service');
    if (badge) badge.textContent = selectedService;

    const year = calendarDate.getFullYear();
    const month = calendarDate.getMonth() + 1;

    // Fetch availability
    const cacheKey = `${year}-${month}`;
    if (!availabilityCache[cacheKey]) {
      calendar.innerHTML = '<p class="font-poppins text-sm text-gray-400 text-center py-8">Ładowanie...</p>';

      try {
        const res = await fetch(`${restUrl}available?month=${month}&year=${year}`, {
          headers: { 'X-WP-Nonce': nonce },
        });
        availabilityCache[cacheKey] = await res.json();
      } catch {
        calendar.innerHTML = '<p class="font-poppins text-sm text-red-500 text-center py-8">Błąd ładowania kalendarza</p>';
        return;
      }
    }

    const data = availabilityCache[cacheKey];
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    const startDay = firstDay.getDay() || 7; // Monday = 1

    const monthNames = ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'];
    const dayNames = ['Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'Sb', 'Nd'];

    let html = '';

    // Navigation
    html += `<div class="flex items-center justify-between mb-4">
      <button type="button" data-cal-prev class="size-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
        <svg class="size-4 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
      </button>
      <span class="font-poppins font-medium text-sm text-black">${monthNames[month - 1]} ${year}</span>
      <button type="button" data-cal-next class="size-8 flex items-center justify-center rounded-full hover:bg-gray-100 transition-colors">
        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
      </button>
    </div>`;

    // Day names
    html += '<div class="grid grid-cols-7 gap-1 mb-1">';
    dayNames.forEach((d) => {
      html += `<div class="text-center font-poppins text-[10px] text-gray-400 py-1">${d}</div>`;
    });
    html += '</div>';

    // Days grid
    html += '<div class="grid grid-cols-7 gap-1">';

    // Empty cells before first day
    for (let i = 1; i < startDay; i++) {
      html += '<div></div>';
    }

    for (let day = 1; day <= lastDay.getDate(); day++) {
      const dateStr = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
      const cellDate = new Date(year, month - 1, day);
      const isPast = cellDate < today;
      const isBlocked = data.blocked.includes(dateStr);
      const isBooked = data.booked.includes(dateStr);
      const isToday = cellDate.getTime() === today.getTime();
      const isAvailable = !isPast && !isBlocked && !isBooked;

      let classes = 'size-10 flex items-center justify-center rounded-full font-poppins text-sm transition-colors ';

      if (isPast) {
        classes += 'text-gray-300 cursor-default';
      } else if (isBooked) {
        classes += 'bg-red-50 text-red-400 cursor-default';
      } else if (isBlocked) {
        classes += 'bg-gray-100 text-gray-400 line-through cursor-default';
      } else if (isToday) {
        classes += 'ring-2 ring-primary text-black cursor-pointer hover:bg-primary hover:text-white';
      } else {
        classes += 'text-black cursor-pointer hover:bg-primary hover:text-white';
      }

      html += `<button type="button" class="${classes}" ${isAvailable ? `data-cal-date="${dateStr}"` : 'disabled'}>${day}</button>`;
    }

    html += '</div>';
    calendar.innerHTML = html;

    // Event listeners
    calendar.querySelector('[data-cal-prev]')?.addEventListener('click', () => {
      calendarDate.setMonth(calendarDate.getMonth() - 1);
      renderCalendar();
    });

    calendar.querySelector('[data-cal-next]')?.addEventListener('click', () => {
      calendarDate.setMonth(calendarDate.getMonth() + 1);
      renderCalendar();
    });

    calendar.querySelectorAll('[data-cal-date]').forEach((btn) => {
      btn.addEventListener('click', () => {
        selectedDate = btn.dataset.calDate;
        goToStep(3);
      });
    });
  }

  // --- Step 3: Form badges ---
  function renderFormBadges() {
    const serviceBadge = document.getElementById('booking-confirm-service');
    const dateBadge = document.getElementById('booking-confirm-date');

    if (serviceBadge) serviceBadge.textContent = selectedService;
    if (dateBadge) {
      const d = new Date(selectedDate);
      const months = ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'];
      dateBadge.textContent = `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

    formError.classList.add('hidden');

    // Reset form
    form.reset();
  }

  // --- Form submit ---
  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const firstName = document.getElementById('booking-first-name').value.trim();
      const lastName = document.getElementById('booking-last-name').value.trim();
      const phone = document.getElementById('booking-phone').value.trim();
      const email = document.getElementById('booking-email').value.trim();
      const gdpr = document.getElementById('booking-gdpr').checked;

      if (!firstName || !lastName || !phone || !email) {
        showError('Wypełnij wszystkie pola.');
        return;
      }

      if (!gdpr) {
        showError('Musisz zaakceptować politykę prywatności.');
        return;
      }

      // Disable button
      const submitBtn = form.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Rezerwuję...';

      try {
        const res = await fetch(`${restUrl}reserve`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': nonce,
          },
          body: JSON.stringify({
            date: selectedDate,
            service: selectedService,
            first_name: firstName,
            last_name: lastName,
            email,
            phone,
            gdpr,
          }),
        });

        const result = await res.json();

        if (res.ok && result.success) {
          const msg = document.getElementById('booking-success-message');
          if (msg) msg.textContent = result.message;
          goToStep(4);
        } else {
          showError(result.error || 'Wystąpił błąd. Spróbuj ponownie.');
          submitBtn.disabled = false;
          submitBtn.textContent = 'Zarezerwuj wizytę';
        }
      } catch {
        showError('Błąd połączenia. Sprawdź internet i spróbuj ponownie.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Zarezerwuj wizytę';
      }
    });
  }

  function showError(msg) {
    formError.textContent = msg;
    formError.classList.remove('hidden');
  }
}
