/**
 * Mobile Menu — 4-panel slide navigation
 *
 * Panel 0: Main menu
 * Panel 1: Services list
 * Panel 2: Service detail
 * Panel 3: Knowledge base (Blog + Guides)
 */
export default function mobileMenu() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const close = document.getElementById('mobile-menu-close');
  const menu = document.getElementById('mobile-menu');
  const panels = document.getElementById('mobile-panels');

  if (!toggle || !menu || !panels) return;

  // Translate classes for 4 panels (each 1/4 of wrapper width)
  const panelPositions = {
    main: 'translate-x-0',
    services: '-translate-x-1/4',
    detail: '-translate-x-2/4',
    knowledge: '-translate-x-3/4',
  };

  let currentPanel = 'main';

  const goToPanel = (name) => {
    Object.values(panelPositions).forEach((cls) => panels.classList.remove(cls));
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
    setTimeout(() => goToPanel('main'), 300);
  };

  toggle.addEventListener('click', openMenu);
  if (close) close.addEventListener('click', closeMenu);

  menu.addEventListener('click', (e) => {
    if (e.target === menu) closeMenu();
  });

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
