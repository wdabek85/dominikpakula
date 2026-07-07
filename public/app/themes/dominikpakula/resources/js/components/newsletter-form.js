/**
 * Newsletter forms — email validation + POST to /booking/v1/newsletter with feedback.
 *
 * Binds EVERY newsletter widget on the page. A widget is any element with the
 * `data-newsletter` attribute wrapping a <form>. Fields and message elements are
 * queried relative to that wrapper, so multiple forms (homepage block, blog
 * subscribe section, …) work independently and without ID collisions.
 *
 * Expected inside each [data-newsletter] wrapper:
 *   - a <form> with an email input and a submit button
 *   - optional honeypot: <input name="website">
 *   - optional [data-newsletter-error], [data-newsletter-success], [data-newsletter-disclaimer]
 */
export default function newsletterForm() {
  if (!window.bookingData) return;

  const { restUrl, nonce } = window.bookingData;
  const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  document.querySelectorAll('[data-newsletter]').forEach((root) => {
    const form = root.querySelector('form');
    const emailInput = root.querySelector('input[type="email"]');
    if (!form || !emailInput) return;

    const submitBtn = form.querySelector('button[type="submit"]');
    const honeypot = root.querySelector('input[name="website"]');
    const errorEl = root.querySelector('[data-newsletter-error]');
    const successEl = root.querySelector('[data-newsletter-success]');
    const disclaimer = root.querySelector('[data-newsletter-disclaimer]');
    const originalBtnText = submitBtn ? submitBtn.textContent : 'Zapisz się';

    function showError(msg) {
      if (errorEl) {
        errorEl.textContent = msg;
        errorEl.classList.remove('hidden');
      }
      successEl?.classList.add('hidden');
    }

    function showSuccess(msg) {
      if (successEl) {
        successEl.textContent = msg;
        successEl.classList.remove('hidden');
      }
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
      const website = honeypot?.value || '';

      if (!EMAIL_RE.test(email)) {
        showError('Nieprawidłowy adres e-mail.');
        return;
      }

      errorEl?.classList.add('hidden');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Zapisuję...';
      }

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
          if (submitBtn) submitBtn.textContent = 'Zapisano ✓';
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
  });
}
