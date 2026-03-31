/**
 * Drag to Scroll
 *
 * Enables mouse drag scrolling on horizontal scroll containers.
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

    // Set initial cursor
    slider.classList.add('cursor-grab');
  });
}
