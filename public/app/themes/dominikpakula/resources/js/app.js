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
import booking from './components/booking.js';
import voucher from './components/voucher.js';
import contactForm from './components/contact-form.js';
import blogToc from './components/blog-toc.js';
import blogShare from './components/blog-share.js';
import newsletterForm from './components/newsletter-form.js';
import lightbox from './components/lightbox.js';
import aboutModal from './components/about-modal.js';

document.addEventListener('DOMContentLoaded', () => {
  mobileMenu();
  liteYoutube();
  testimonialVideo();
  dragScroll();
  sliderArrows();
  faqAccordion();
  megaMenu();
  stickyPriceBar();
  booking();
  voucher();
  contactForm();
  blogToc();
  blogShare();
  newsletterForm();
  lightbox();
  aboutModal();
});
