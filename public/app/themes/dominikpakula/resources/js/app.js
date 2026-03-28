import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Components
import mobileMenu from './components/mobile-menu.js';
import liteYoutube from './components/lite-youtube.js';

document.addEventListener('DOMContentLoaded', () => {
  mobileMenu();
  liteYoutube();
});
