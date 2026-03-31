export default function faqAccordion() {
  document.querySelectorAll('[data-faq-trigger]').forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const item = trigger.closest('[data-faq-item]');
      const content = item.querySelector('[data-faq-content]');
      const icon = trigger.querySelector('svg');
      const isOpen = trigger.getAttribute('aria-expanded') === 'true';

      // Close all other items in the same accordion
      const accordion = item.closest('[data-faq-accordion]');
      accordion.querySelectorAll('[data-faq-item]').forEach((otherItem) => {
        if (otherItem !== item) {
          const otherTrigger = otherItem.querySelector('[data-faq-trigger]');
          const otherContent = otherItem.querySelector('[data-faq-content]');
          const otherIcon = otherTrigger.querySelector('svg');

          otherTrigger.setAttribute('aria-expanded', 'false');
          otherContent.style.maxHeight = null;
          otherIcon.classList.remove('rotate-180');
        }
      });

      // Toggle current item
      if (isOpen) {
        trigger.setAttribute('aria-expanded', 'false');
        content.style.maxHeight = null;
        icon.classList.remove('rotate-180');
      } else {
        trigger.setAttribute('aria-expanded', 'true');
        content.style.maxHeight = content.scrollHeight + 'px';
        icon.classList.add('rotate-180');
      }
    });
  });
}
