import.meta.glob([
  '../images/**',
  '../fonts/**',
]);

// Components
import mobileMenu from './components/mobile-menu.js';
import liteYoutube from './components/lite-youtube.js';
import testimonialVideo from './components/testimonial-video.js';
import dragScroll from './components/drag-scroll.js';
import sliderArrows from './components/slider-arrows.js';
import faqAccordion from './components/faq-accordion.js';
import megaMenu from './components/mega-menu.js';
import stickyPriceBar from './components/sticky-price-bar.js';

document.addEventListener('DOMContentLoaded', () => {
  mobileMenu();
  liteYoutube();
  testimonialVideo();
  dragScroll();
  sliderArrows();
  faqAccordion();
  megaMenu();
  stickyPriceBar();
});
