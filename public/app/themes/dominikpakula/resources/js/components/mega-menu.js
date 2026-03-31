/**
 * Desktop Mega Menu
 *
 * Full-width panel with service list (left) and detail preview (right).
 * Hover on list item switches the detail panel.
 */
export default function megaMenu() {
  const trigger = document.querySelector('[data-mega-trigger]');
  const panel = document.getElementById('mega-menu-panel');
  const chevron = document.querySelector('[data-mega-chevron]');

  if (!trigger || !panel) return;

  let closeTimeout = null;

  const open = () => {
    clearTimeout(closeTimeout);
    panel.classList.remove('max-h-0', 'opacity-0');
    panel.classList.add('max-h-[80vh]', 'opacity-100');
    trigger.querySelector('button')?.setAttribute('aria-expanded', 'true');
    if (chevron) chevron.classList.add('rotate-180');
  };

  const close = () => {
    closeTimeout = setTimeout(() => {
      panel.classList.remove('max-h-[80vh]', 'opacity-100');
      panel.classList.add('max-h-0', 'opacity-0');
      trigger.querySelector('button')?.setAttribute('aria-expanded', 'false');
      if (chevron) chevron.classList.remove('rotate-180');
    }, 150);
  };

  // Hover open/close
  trigger.addEventListener('mouseenter', open);
  trigger.addEventListener('mouseleave', close);
  panel.addEventListener('mouseenter', () => clearTimeout(closeTimeout));
  panel.addEventListener('mouseleave', close);

  // Click toggle
  trigger.querySelector('button')?.addEventListener('click', () => {
    const isOpen = panel.classList.contains('opacity-100');
    if (isOpen) close();
    else open();
  });

  // Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && panel.classList.contains('opacity-100')) {
      panel.classList.remove('max-h-[80vh]', 'opacity-100');
      panel.classList.add('max-h-0', 'opacity-0');
      trigger.querySelector('button')?.setAttribute('aria-expanded', 'false');
      if (chevron) chevron.classList.remove('rotate-180');
    }
  });

  // --- Detail switching on hover ---
  const items = panel.querySelectorAll('[data-mega-item]');
  const details = panel.querySelectorAll('[data-mega-detail]');

  if (!items.length || !details.length) return;

  items.forEach((item) => {
    item.addEventListener('mouseenter', () => {
      const index = item.getAttribute('data-mega-item');

      // Update active states on list items
      items.forEach((el) => {
        el.removeAttribute('data-active');
        const arrow = el.querySelector('[data-mega-arrow]');
        if (arrow) arrow.classList.add('opacity-0');
      });
      item.setAttribute('data-active', '');
      const arrow = item.querySelector('[data-mega-arrow]');
      if (arrow) arrow.classList.remove('opacity-0');

      // Show matching detail
      details.forEach((detail) => {
        if (detail.getAttribute('data-mega-detail') === index) {
          detail.classList.remove('hidden');
          detail.classList.add('!flex');
        } else {
          detail.classList.add('hidden');
          detail.classList.remove('!flex');
        }
      });
    });
  });
}
