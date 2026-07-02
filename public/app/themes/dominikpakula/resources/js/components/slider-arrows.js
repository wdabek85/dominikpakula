/**
 * Slider Arrows
 *
 * Adds prev/next arrow navigation to sliders.
 * Elements: [data-slider] container with [data-slider-prev] and [data-slider-next] buttons.
 */
export default function sliderArrows() {
  const wrappers = document.querySelectorAll('[data-slider]');
  if (!wrappers.length) return;

  wrappers.forEach((slider) => {
    const section = slider.closest('section');
    if (!section) return;

    const prevBtn = section.querySelector('[data-slider-prev]');
    const nextBtn = section.querySelector('[data-slider-next]');
    if (!prevBtn || !nextBtn) return;

    const getScrollAmount = () => {
      const firstCard = slider.querySelector('[role="listitem"]');
      if (!firstCard) return 400;
      return firstCard.offsetWidth + parseFloat(getComputedStyle(slider).gap || 40);
    };

    const updateButtons = () => {
      prevBtn.disabled = slider.scrollLeft <= 5;
      nextBtn.disabled = slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5;
    };

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
