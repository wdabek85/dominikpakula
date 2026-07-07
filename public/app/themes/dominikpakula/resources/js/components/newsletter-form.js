/**
 * Newsletter form — email validation + POST to /booking/v1/newsletter with feedback.
 */
export default function newsletterForm() {
  const form = document.getElementById('newsletter-form');
  if (!form || !window.bookingData) return;

  const { restUrl, nonce } = window.bookingData;

  const submitBtn = document.getElementById('newsletter-submit');
  const emailInput = document.getElementById('newsletter-email');
  const errorEl = document.getElementById('newsletter-error');
  const successEl = document.getElementById('newsletter-success');
  const disclaimer = document.getElementById('newsletter-disclaimer');
  const originalBtnText = submitBtn ? submitBtn.textContent : 'Zapisz się';

  const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function showError(msg) {
    if (!errorEl) return;
    errorEl.textContent = msg;
    errorEl.classList.remove('hidden');
    successEl?.classList.add('hidden');
  }

  function showSuccess(msg) {
    if (!successEl) return;
    successEl.textContent = msg;
    successEl.classList.remove('hidden');
    errorEl?.classList.add('hidden');
    disclaimer?.classList.add('hidden');
  }

  function resetButton() {
    if (!submitBtn) return;
    submitBtn.disabled = false;
    submitBtn.textContent = originalBtnText;
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const email = emailInput.value.trim();
    const website = document.getElementById('newsletter-website')?.value || '';

    if (!EMAIL_RE.test(email)) {
      showError('Nieprawidłowy adres e-mail.');
      return;
    }

    errorEl?.classList.add('hidden');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Zapisuję...';

    try {
      const res = await fetch(`${restUrl}newsletter`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': nonce,
        },
        body: JSON.stringify({ email, website }),
      });

      const result = await res.json();

      if (res.ok && result.success) {
        submitBtn.textContent = 'Zapisano ✓';
        showSuccess(result.message || 'Dzięki! Jesteś zapisany na newsletter.');
        emailInput.value = '';
      } else {
        showError(result.error || 'Wystąpił błąd. Spróbuj ponownie.');
        resetButton();
      }
    } catch {
      showError('Błąd połączenia. Sprawdź internet i spróbuj ponownie.');
      resetButton();
    }
  });
}
