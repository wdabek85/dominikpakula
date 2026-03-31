/**
 * Mobile Menu — 3-panel slide navigation
 *
 * Panel 0: Main menu
 * Panel 1: Services list
 * Panel 2: Service detail (switched by data-service-index)
 */
export default function mobileMenu() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const close = document.getElementById('mobile-menu-close');
  const menu = document.getElementById('mobile-menu');
  const panels = document.getElementById('mobile-panels');

  if (!toggle || !menu || !panels) return;

  // Translate classes for 3 panels (each 1/3 of wrapper width)
  const panelPositions = {
    main: 'translate-x-0',
    services: '-translate-x-1/3',
    detail: '-translate-x-2/3',
  };

  let currentPanel = 'main';

  const goToPanel = (name) => {
    panels.classList.remove(
      panelPositions.main,
      panelPositions.services,
      panelPositions.detail
    );
    panels.classList.add(panelPositions[name]);
    currentPanel = name;
  };

  const openMenu = () => {
    menu.classList.remove('translate-x-full');
    menu.classList.add('translate-x-0');
    toggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('overflow-hidden');
  };

  const closeMenu = () => {
    menu.classList.remove('translate-x-0');
    menu.classList.add('translate-x-full');
    toggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
    // Reset to main panel after close animation
    setTimeout(() => goToPanel('main'), 300);
  };

  toggle.addEventListener('click', openMenu);
  if (close) close.addEventListener('click', closeMenu);

  // Close on backdrop
  menu.addEventListener('click', (e) => {
    if (e.target === menu) closeMenu();
  });

  // Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !menu.classList.contains('translate-x-full')) {
      closeMenu();
    }
  });

  // Navigation between panels
  document.querySelectorAll('[data-mobile-go]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-mobile-go');

      if (target === 'detail') {
        // Show specific service detail
        const index = btn.getAttribute('data-service-index');
        const details = document.querySelectorAll('[data-mobile-detail]');

        details.forEach((detail) => {
          if (detail.getAttribute('data-mobile-detail') === index) {
            detail.classList.remove('hidden');
            detail.classList.add('!flex');
          } else {
            detail.classList.add('hidden');
            detail.classList.remove('!flex');
          }
        });
      }

      goToPanel(target);
    });
  });

  // Back buttons
  document.querySelectorAll('[data-mobile-back]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-mobile-back');
      goToPanel(target);
    });
  });
}
