/**
 * Desktop Mega Menus
 *
 * Supports multiple mega-menu panels (services + knowledge base).
 * Each has its own trigger and panel, with hover open/close.
 */
export default function megaMenu() {
  initMegaPanel({
    triggerSelector: '[data-mega-trigger]',
    panelId: 'mega-menu-panel',
    chevronSelector: '[data-mega-chevron]',
    hasDetailSwitch: true,
  });

  initMegaPanel({
    triggerSelector: '[data-mega-trigger-kb]',
    panelId: 'mega-menu-kb-panel',
    chevronSelector: '[data-mega-chevron-kb]',
    hasDetailSwitch: false,
  });
}

function initMegaPanel({ triggerSelector, panelId, chevronSelector, hasDetailSwitch }) {
  const trigger = document.querySelector(triggerSelector);
  const panel = document.getElementById(panelId);
  const chevron = document.querySelector(chevronSelector);

  if (!trigger || !panel) return;

  let closeTimeout = null;

  const open = () => {
    clearTimeout(closeTimeout);
    // Close other mega panels
    document.querySelectorAll('[id^="mega-menu"][id$="-panel"]').forEach((other) => {
      if (other !== panel && other.classList.contains('opacity-100')) {
        other.classList.remove('max-h-[80vh]', 'opacity-100');
        other.classList.add('max-h-0', 'opacity-0');
      }
    });
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

  trigger.addEventListener('mouseenter', open);
  trigger.addEventListener('mouseleave', close);
  panel.addEventListener('mouseenter', () => clearTimeout(closeTimeout));
  panel.addEventListener('mouseleave', close);

  trigger.querySelector('button')?.addEventListener('click', () => {
    const isOpen = panel.classList.contains('opacity-100');
    if (isOpen) close();
    else open();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && panel.classList.contains('opacity-100')) {
      panel.classList.remove('max-h-[80vh]', 'opacity-100');
      panel.classList.add('max-h-0', 'opacity-0');
      trigger.querySelector('button')?.setAttribute('aria-expanded', 'false');
      if (chevron) chevron.classList.remove('rotate-180');
    }
  });

  // Detail switching (only for services mega-menu)
  if (hasDetailSwitch) {
    const items = panel.querySelectorAll('[data-mega-item]');
    const details = panel.querySelectorAll('[data-mega-detail]');

    if (!items.length || !details.length) return;

    items.forEach((item) => {
      item.addEventListener('mouseenter', () => {
        const index = item.getAttribute('data-mega-item');

        items.forEach((el) => {
          el.removeAttribute('data-active');
          const arrow = el.querySelector('[data-mega-arrow]');
          if (arrow) arrow.classList.add('opacity-0');
        });
        item.setAttribute('data-active', '');
        const arrow = item.querySelector('[data-mega-arrow]');
        if (arrow) arrow.classList.remove('opacity-0');

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
}
