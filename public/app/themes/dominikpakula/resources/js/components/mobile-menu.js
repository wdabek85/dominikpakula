/**
 * Mobile Menu Toggle
 *
 * Handles open/close of the mobile navigation drawer.
 * Elements: #mobile-menu-toggle, #mobile-menu-close, #mobile-menu
 */
export default function mobileMenu() {
  const toggle = document.getElementById('mobile-menu-toggle');
  const close = document.getElementById('mobile-menu-close');
  const menu = document.getElementById('mobile-menu');

  if (!toggle || !menu) return;

  const open = () => {
    menu.classList.remove('translate-x-full');
    menu.classList.add('translate-x-0');
    toggle.setAttribute('aria-expanded', 'true');
    document.body.classList.add('overflow-hidden');
  };

  const shut = () => {
    menu.classList.remove('translate-x-0');
    menu.classList.add('translate-x-full');
    toggle.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
  };

  toggle.addEventListener('click', open);
  if (close) close.addEventListener('click', shut);

  // Close on backdrop click
  menu.addEventListener('click', (e) => {
    if (e.target === menu) shut();
  });

  // Close on Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !menu.classList.contains('translate-x-full')) {
      shut();
    }
  });
}
