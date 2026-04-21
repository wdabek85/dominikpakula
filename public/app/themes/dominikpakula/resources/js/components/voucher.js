/**
 * Voucher Modal — gift voucher order flow
 *
 * Steps: 1) Select service  2) Recipient data  3) Buyer data + GDPR  4) Confirmation
 * Trigger: any element with .voucher-trigger class
 */
import createModalA11y from '../lib/modal-a11y.js';

export default function voucher() {
  const modal = document.getElementById('voucher-modal');
  if (!modal || !window.bookingData) return;

  const { restUrl, nonce, services } = window.bookingData;
  const a11y = createModalA11y(modal);

  let currentStep = 1;
  let selectedService = null;
  const backBtn = document.getElementById('voucher-back');

  // --- Open / Close ---
  function open() {
    selectedService = null;
    goToStep(1);
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    a11y.activate();
  }

  function close() {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    a11y.deactivate();
  }

  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.voucher-trigger');
    if (trigger) {
      e.preventDefault();
      open();
    }
  });

  modal.querySelectorAll('[data-voucher-close]').forEach((el) => {
    el.addEventListener('click', close);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) close();
  });

  // --- Steps ---
  function goToStep(step) {
    currentStep = step;

    modal.querySelectorAll('[data-voucher-step]').forEach((el) => {
      el.classList.toggle('hidden', el.dataset.voucherStep !== String(step));
    });

    modal.querySelectorAll('[data-vstep-dot]').forEach((dot) => {
      const s = parseInt(dot.dataset.vstepDot);
      dot.classList.toggle('bg-primary', s <= step);
      dot.classList.toggle('text-white', s <= step);
      dot.classList.toggle('bg-gray-200', s > step);
      dot.classList.toggle('text-gray-400', s > step);
    });

    modal.querySelectorAll('[data-vstep-label]').forEach((label) => {
      const s = parseInt(label.dataset.vstepLabel);
      label.classList.toggle('text-black', s <= step);
      label.classList.toggle('text-gray-400', s > step);
    });

    if (backBtn) {
      backBtn.classList.toggle('hidden', step === 1 || step === 4);
    }

    if (step === 1) renderServices();
    if (step === 2) updateServiceBadge();
  }

  // Back
  if (backBtn) {
    backBtn.addEventListener('click', () => {
      if (currentStep > 1 && currentStep < 4) goToStep(currentStep - 1);
    });
  }

  // Change service
  const changeBtn = document.getElementById('voucher-change-service');
  if (changeBtn) {
    changeBtn.addEventListener('click', () => goToStep(1));
  }

  // --- Step 1: Services ---
  function renderServices() {
    const list = document.getElementById('voucher-services-list');
    list.innerHTML = '';

    services.forEach((s) => {
      const card = document.createElement('button');
      card.className = 'w-full text-left border border-gray-200 rounded-sm p-4 hover:border-primary hover:bg-primary/5 transition-colors flex items-center justify-between gap-4 cursor-pointer';
      card.innerHTML = `
        <div class="flex flex-col gap-1 min-w-0">
          <span class="font-poppins font-semibold text-sm text-black">${s.title}</span>
          ${s.excerpt ? `<span class="font-poppins text-xs text-gray-500 leading-relaxed">${s.excerpt}</span>` : ''}
        </div>
        <div class="flex flex-col items-end gap-1 shrink-0">
          ${s.price ? `<span class="font-poppins font-semibold text-base text-primary">${s.price}</span>` : ''}
          <a href="${s.url}" class="font-poppins text-[10px] text-primary underline" onclick="event.stopPropagation()">Dowiedz się więcej</a>
        </div>
      `;

      card.addEventListener('click', () => {
        selectedService = s.title;
        goToStep(2);
      });

      list.appendChild(card);
    });
  }

  function updateServiceBadge() {
    const badge = document.getElementById('voucher-selected-service');
    if (badge) badge.textContent = selectedService;
  }

  // --- Step 2 → Step 3 ---
  const toStep3Btn = document.getElementById('voucher-to-step3');
  if (toStep3Btn) {
    toStep3Btn.addEventListener('click', () => {
      const recipientFirst = document.getElementById('voucher-recipient-first').value.trim();
      if (!recipientFirst) {
        alert('Podaj przynajmniej imię obdarowanej osoby.');
        return;
      }
      goToStep(3);
    });
  }

  // --- Step 3: Form submit ---
  const form = document.getElementById('voucher-form');
  const formError = document.getElementById('voucher-form-error');

  if (form) {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const buyerFirst = document.getElementById('voucher-buyer-first').value.trim();
      const buyerLast = document.getElementById('voucher-buyer-last').value.trim();
      const buyerEmail = document.getElementById('voucher-buyer-email').value.trim();
      const buyerPhone = document.getElementById('voucher-buyer-phone').value.trim();
      const gdpr = document.getElementById('voucher-gdpr').checked;

      if (!buyerFirst || !buyerLast || !buyerEmail || !buyerPhone) {
        showError('Wypełnij wszystkie wymagane pola.');
        return;
      }

      if (!gdpr) {
        showError('Musisz zaakceptować politykę prywatności.');
        return;
      }

      const submitBtn = form.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.textContent = 'Wysyłam...';

      try {
        const res = await fetch(`${restUrl}voucher`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': nonce,
          },
          body: JSON.stringify({
            service: selectedService,
            recipient_first_name: document.getElementById('voucher-recipient-first').value.trim(),
            recipient_last_name: document.getElementById('voucher-recipient-last').value.trim(),
            recipient_email: document.getElementById('voucher-recipient-email').value.trim(),
            buyer_first_name: buyerFirst,
            buyer_last_name: buyerLast,
            buyer_email: buyerEmail,
            buyer_phone: buyerPhone,
            gdpr,
          }),
        });

        const result = await res.json();

        if (res.ok && result.success) {
          const msg = document.getElementById('voucher-success-message');
          if (msg) msg.textContent = result.message;
          goToStep(4);
        } else {
          showError(result.error || 'Wystąpił błąd.');
          submitBtn.disabled = false;
          submitBtn.textContent = 'Zamów voucher';
        }
      } catch {
        showError('Błąd połączenia.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Zamów voucher';
      }
    });
  }

  function showError(msg) {
    formError.textContent = msg;
    formError.classList.remove('hidden');
  }
}
