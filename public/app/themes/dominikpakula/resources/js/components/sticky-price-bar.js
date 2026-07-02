/**
 * Sticky Price Bar
 *
 * Shows a fixed bottom bar with service name, price and CTA
 * when the sidebar price section scrolls out of viewport.
 */
export default function stickyPriceBar() {
  const priceSection = document.querySelector('[data-price-section]');
  const bar = document.getElementById('sticky-price-bar');

  if (!priceSection || !bar) return;

  const observer = new IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting) {
        // Price section visible — hide bar
        bar.classList.add('translate-y-full');
        bar.classList.remove('translate-y-0');
      } else {
        // Price section out of view — show bar
        bar.classList.remove('translate-y-full');
        bar.classList.add('translate-y-0');
      }
    },
    { threshold: 0 }
  );

  observer.observe(priceSection);
}
