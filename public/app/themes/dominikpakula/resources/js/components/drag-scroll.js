/**
 * Drag to Scroll
 *
 * Enables mouse drag scrolling on horizontal scroll containers.
 * Keyboard users get arrow-key scrolling + Home/End for ends.
 * Elements: [data-drag-scroll]
 */
export default function dragScroll() {
  const sliders = document.querySelectorAll('[data-drag-scroll]');
  if (!sliders.length) return;

  sliders.forEach((slider) => {
    let isDown = false;
    let startX;
    let scrollLeft;

    slider.addEventListener('mousedown', (e) => {
      isDown = true;
      slider.classList.add('cursor-grabbing');
      slider.classList.remove('cursor-grab');
      startX = e.pageX - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
      isDown = false;
      slider.classList.remove('cursor-grabbing');
      slider.classList.add('cursor-grab');
    });

    slider.addEventListener('mouseup', () => {
      isDown = false;
      slider.classList.remove('cursor-grabbing');
      slider.classList.add('cursor-grab');
    });

    slider.addEventListener('mousemove', (e) => {
      if (!isDown) return;
      e.preventDefault();
      const x = e.pageX - slider.offsetLeft;
      const walk = (x - startX) * 1.5;
      slider.scrollLeft = scrollLeft - walk;
    });

    // Keyboard support — make the container focusable and handle arrows
    if (!slider.hasAttribute('tabindex')) {
      slider.setAttribute('tabindex', '0');
    }
    if (!slider.hasAttribute('role')) {
      slider.setAttribute('role', 'region');
    }
    if (!slider.hasAttribute('aria-label')) {
      slider.setAttribute('aria-label', 'Przewijalna lista — użyj strzałek lewo/prawo');
    }

    slider.addEventListener('keydown', (e) => {
      const step = Math.max(200, Math.round(slider.clientWidth * 0.8));

      switch (e.key) {
        case 'ArrowLeft':
          e.preventDefault();
          slider.scrollBy({ left: -step, behavior: 'smooth' });
          break;
        case 'ArrowRight':
          e.preventDefault();
          slider.scrollBy({ left: step, behavior: 'smooth' });
          break;
        case 'Home':
          e.preventDefault();
          slider.scrollTo({ left: 0, behavior: 'smooth' });
          break;
        case 'End':
          e.preventDefault();
          slider.scrollTo({ left: slider.scrollWidth, behavior: 'smooth' });
          break;
      }
    });

    // Set initial cursor
    slider.classList.add('cursor-grab');
  });
}
