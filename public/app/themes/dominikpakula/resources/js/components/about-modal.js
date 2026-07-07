/**
 * About Modal — globalny modal "Poznaj mnie".
 * Otwierany dowolnym elementem z klasą .about-trigger, zamykany przyciskiem
 * [data-about-close], klikiem w tło i klawiszem Escape.
 */
import createModalA11y from '../lib/modal-a11y.js';

export default function aboutModal() {
  const modal = document.getElementById('about-modal');
  if (!modal) return;

  const a11y = createModalA11y(modal);

  function open() {
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
    if (e.target.closest('.about-trigger')) {
      e.preventDefault();
      open();
    }
  });

  modal.querySelectorAll('[data-about-close]').forEach((el) => {
    el.addEventListener('click', close);
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
      close();
    }
  });
}
