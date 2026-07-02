/**
 * Testimonial Video Player
 *
 * Opens a fullscreen modal with YouTube video when play button is clicked.
 * Elements: [data-testimonial-video] with YouTube video ID as value.
 */
export default function testimonialVideo() {
  const buttons = document.querySelectorAll('[data-testimonial-video]');
  if (!buttons.length) return;

  let modal = null;

  function createModal() {
    modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/80 opacity-0 transition-opacity duration-300';
    modal.style.pointerEvents = 'none';
    modal.setAttribute('role', 'dialog');
    modal.setAttribute('aria-modal', 'true');
    modal.setAttribute('aria-label', 'Wideo opinia');

    modal.innerHTML = `
      <button
        class="absolute top-4 right-4 size-10 flex items-center justify-center text-white hover:text-white/80 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white rounded-full"
        aria-label="Zamknij wideo"
        data-close-modal
      >
        <svg class="size-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <div class="w-full max-w-4xl aspect-video mx-4">
        <iframe
          class="size-full rounded"
          src=""
          frameborder="0"
          allow="autoplay; encrypted-media"
          allowfullscreen
        ></iframe>
      </div>
    `;

    document.body.appendChild(modal);

    modal.addEventListener('click', (e) => {
      if (e.target === modal || e.target.closest('[data-close-modal]')) {
        closeModal();
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && modal.style.pointerEvents === 'auto') {
        closeModal();
      }
    });
  }

  function openModal(videoId) {
    if (!modal) createModal();

    const iframe = modal.querySelector('iframe');
    iframe.src = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;

    requestAnimationFrame(() => {
      modal.style.opacity = '1';
      modal.style.pointerEvents = 'auto';
    });
  }

  function closeModal() {
    const iframe = modal.querySelector('iframe');
    iframe.src = '';
    modal.style.opacity = '0';
    modal.style.pointerEvents = 'none';
  }

  buttons.forEach((btn) => {
    btn.addEventListener('click', () => {
      const videoId = btn.dataset.testimonialVideo;
      if (videoId) openModal(videoId);
    });
  });
}
