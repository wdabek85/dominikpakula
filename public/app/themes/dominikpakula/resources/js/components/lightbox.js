/**
 * Lightbox — uniwersalny dla galerii oznaczonych `data-lightbox-gallery`.
 * Każdy klikalny item w środku ma `data-lightbox-trigger` + atrybuty:
 *   data-lightbox-src       (full image URL)
 *   data-lightbox-alt       (opcjonalnie)
 *   data-lightbox-caption   (opcjonalnie)
 *
 * Modal markup: `partials/lightbox.blade.php` w layoucie app.blade.php.
 * Klawisze: Esc = close, ← / → = prev/next.
 */
export default function lightbox() {
  const galleries = document.querySelectorAll('[data-lightbox-gallery]');
  if (!galleries.length) return;

  const modal = document.querySelector('[data-lightbox-modal]');
  if (!modal) return;

  const imageEl = modal.querySelector('[data-lightbox-image]');
  const captionEl = modal.querySelector('[data-lightbox-caption]');
  const counterEl = modal.querySelector('[data-lightbox-counter]');
  const prevBtn = modal.querySelector('[data-lightbox-prev]');
  const nextBtn = modal.querySelector('[data-lightbox-next]');
  const closeEls = modal.querySelectorAll('[data-lightbox-close]');

  let currentItems = [];
  let currentIndex = 0;
  let lastFocused = null;

  galleries.forEach((gallery) => {
    const triggers = gallery.querySelectorAll('[data-lightbox-trigger]');
    const items = [...triggers].map((t) => ({
      src: t.dataset.lightboxSrc || t.getAttribute('href') || '',
      alt: t.dataset.lightboxAlt || '',
      caption: t.dataset.lightboxCaption || '',
    }));

    triggers.forEach((trigger, i) => {
      trigger.addEventListener('click', (e) => {
        e.preventDefault();
        currentItems = items;
        currentIndex = i;
        lastFocused = trigger;
        showImage();
        openModal();
      });
    });
  });

  function showImage() {
    if (!currentItems[currentIndex]) return;
    const item = currentItems[currentIndex];

    imageEl.src = item.src;
    imageEl.alt = item.alt;

    if (item.caption) {
      captionEl.textContent = item.caption;
      captionEl.classList.remove('hidden');
    } else {
      captionEl.textContent = '';
      captionEl.classList.add('hidden');
    }

    counterEl.textContent = `${currentIndex + 1} / ${currentItems.length}`;
    counterEl.classList.toggle('hidden', currentItems.length <= 1);

    prevBtn.disabled = currentIndex === 0;
    nextBtn.disabled = currentIndex === currentItems.length - 1;
    prevBtn.classList.toggle('hidden', currentItems.length <= 1);
    nextBtn.classList.toggle('hidden', currentItems.length <= 1);
  }

  function openModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
    document.addEventListener('keydown', onKeydown);

    // Focus close button (a11y)
    const closeBtn = modal.querySelector('button[data-lightbox-close]');
    if (closeBtn) closeBtn.focus();
  }

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
    document.removeEventListener('keydown', onKeydown);
    imageEl.src = '';

    // Return focus to triggering element
    if (lastFocused) lastFocused.focus();
  }

  function next() {
    if (currentIndex < currentItems.length - 1) {
      currentIndex++;
      showImage();
    }
  }

  function prev() {
    if (currentIndex > 0) {
      currentIndex--;
      showImage();
    }
  }

  function onKeydown(e) {
    if (e.key === 'Escape') {
      closeModal();
    } else if (e.key === 'ArrowLeft') {
      prev();
    } else if (e.key === 'ArrowRight') {
      next();
    }
  }

  closeEls.forEach((el) => el.addEventListener('click', closeModal));
  prevBtn.addEventListener('click', prev);
  nextBtn.addEventListener('click', next);
}
