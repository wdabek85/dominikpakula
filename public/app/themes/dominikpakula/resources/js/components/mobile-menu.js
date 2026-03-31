/**
 * Mobile Menu Toggle + Services Submenu Slide
 *
 * Handles open/close of the mobile navigation drawer
 * and sliding between main menu and services submenu.
 */
export default function mobileMenu() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const close = document.getElementById('mobile-menu-close');
  const menu = document.getElementById('mobile-menu');
  const panels = document.getElementById('mobile-panels');
  const servicesTrigger = document.getElementById('mobile-services-trigger');
  const servicesBack = document.getElementById('mobile-services-back');

  if (!toggle || !menu) return;

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
    // Reset to main panel
    if (panels) {
      panels.classList.remove('-translate-x-1/2');
    }
  };

  const showServices = () => {
    if (panels) {
      panels.classList.add('-translate-x-1/2');
    }
  };

  const hideServices = () => {
    if (panels) {
      panels.classList.remove('-translate-x-1/2');
    }
  };

  toggle.addEventListener('click', openMenu);
  if (close) close.addEventListener('click', closeMenu);

  if (servicesTrigger) {
    servicesTrigger.addEventListener('click', showServices);
  }

  if (servicesBack) {
    servicesBack.addEventListener('click', hideServices);
  }

  // Close on backdrop click
  menu.addEventListener('click', (e) => {
    if (e.target === menu) closeMenu();
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !menu.classList.contains('translate-x-full')) {
      closeMenu();
    }
  });
}
