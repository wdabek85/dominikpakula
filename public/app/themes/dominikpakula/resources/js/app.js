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

document.addEventListener('DOMContentLoaded', () => {
  mobileMenu();
  liteYoutube();
  testimonialVideo();
  dragScroll();
  sliderArrows();
});
