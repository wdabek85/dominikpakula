/**
 * Slider Arrows
 *
 * Adds prev/next arrow navigation to sliders.
 * Elements: [data-slider] container with [data-slider-prev] and [data-slider-next] buttons.
 * Buttons are looked up in the closest [data-slider-root] (fallback: closest <section>).
 * Optional:
 *   data-slider-step="page" — scroll by ~80% of the visible width instead of one card
 *   [data-slider-arrows]    — hidden when the content fits without scrolling
 */
export default function sliderArrows() {
  const wrappers = document.querySelectorAll('[data-slider]');
  if (!wrappers.length) return;

  wrappers.forEach((slider) => {
    const section = slider.closest('[data-slider-root]') || slider.closest('section');
    if (!section) return;

    const prevBtn = section.querySelector('[data-slider-prev]');
    const nextBtn = section.querySelector('[data-slider-next]');
    if (!prevBtn || !nextBtn) return;

    const arrows = section.querySelectorAll('[data-slider-arrows]');

    const getScrollAmount = () => {
      if (slider.dataset.sliderStep === 'page') {
        return Math.max(slider.clientWidth * 0.8, 80);
      }

      const firstCard = slider.querySelector('[role="listitem"]');
      if (!firstCard) return 400;
      return firstCard.offsetWidth + parseFloat(getComputedStyle(slider).gap || 40);
    };

    const updateButtons = () => {
      prevBtn.disabled = slider.scrollLeft <= 5;
      nextBtn.disabled = slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5;

      const fits = slider.scrollWidth <= slider.clientWidth + 1;
      arrows.forEach((el) => el.classList.toggle('hidden', fits));
    };

    window.addEventListener('resize', updateButtons, { passive: true });

    prevBtn.addEventListener('click', () => {
      slider.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
      slider.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
    });

    slider.addEventListener('scroll', updateButtons, { passive: true });
    updateButtons();
  });
}
