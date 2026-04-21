/**
 * Contact Form — submits to /booking/v1/contact with GDPR + honeypot.
 */
export default function contactForm() {
  const form = document.getElementById('contact-form');
  if (!form || !window.bookingData) return;

  const { restUrl, nonce } = window.bookingData;

  const errorEl = document.getElementById('contact-form-error');
  const successEl = document.getElementById('contact-form-success');
  const submitBtn = document.getElementById('contact-form-submit');
  const originalBtnText = submitBtn ? submitBtn.textContent : 'Wyślij';

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
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const name = document.getElementById('contact-name').value.trim();
    const email = document.getElementById('contact-email').value.trim();
    const message = document.getElementById('contact-message').value.trim();
    const gdpr = document.getElementById('contact-gdpr').checked;
    const website = document.getElementById('contact-website')?.value || '';

    if (!name || !email || !message) {
      showError('Wypełnij wszystkie pola.');
      return;
    }

    if (!gdpr) {
      showError('Musisz zaakceptować politykę prywatności.');
      return;
    }

    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Wysyłam...';
    }

    try {
      const res = await fetch(`${restUrl}contact`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': nonce,
        },
        body: JSON.stringify({ name, email, message, gdpr, website }),
      });

      const result = await res.json();

      if (res.ok && result.success) {
        showSuccess(result.message);
        form.reset();
      } else {
        showError(result.error || 'Wystąpił błąd. Spróbuj ponownie.');
      }
    } catch {
      showError('Błąd połączenia. Sprawdź internet i spróbuj ponownie.');
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
      }
    }
  });
}
