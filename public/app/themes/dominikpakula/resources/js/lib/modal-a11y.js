/**
 * Modal accessibility helper — focus trap + focus return.
 *
 * Usage:
 *   const a11y = createModalA11y(modalEl);
 *   a11y.activate();   // when opening (saves activeElement, moves focus in, traps Tab)
 *   a11y.deactivate(); // when closing (restores focus to original trigger)
 */

const FOCUSABLE_SELECTOR = [
  'a[href]',
  'button:not([disabled])',
  'input:not([disabled]):not([type="hidden"])',
  'select:not([disabled])',
  'textarea:not([disabled])',
  '[tabindex]:not([tabindex="-1"])',
].join(',');

function getFocusable(container) {
  return Array.from(container.querySelectorAll(FOCUSABLE_SELECTOR)).filter((el) => {
    if (el.getAttribute('aria-hidden') === 'true') return false;
    // Skip elements inside a hidden ancestor — common for multi-step modals
    return el.offsetParent !== null || el === document.activeElement;
  });
}

export default function createModalA11y(modalEl) {
  let previousFocus = null;
  let handleKeydown = null;

  function activate() {
    previousFocus = document.activeElement;

    const focusables = getFocusable(modalEl);
    const target = focusables[0] || modalEl;
    if (target && typeof target.focus === 'function') {
      // Defer one frame so visibility transitions complete
      requestAnimationFrame(() => target.focus());
    }

    handleKeydown = (e) => {
      if (e.key !== 'Tab') return;

      const current = getFocusable(modalEl);
      if (!current.length) {
        e.preventDefault();
        return;
      }

      const first = current[0];
      const last = current[current.length - 1];

      if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
      } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
      }
    };

    modalEl.addEventListener('keydown', handleKeydown);
  }

  function deactivate() {
    if (handleKeydown) {
      modalEl.removeEventListener('keydown', handleKeydown);
      handleKeydown = null;
    }

    if (previousFocus && typeof previousFocus.focus === 'function') {
      // Restore focus to the trigger that opened the modal
      requestAnimationFrame(() => {
        try {
          previousFocus.focus();
        } catch {
          // trigger may have been removed from DOM
        }
      });
    }

    previousFocus = null;
  }

  return { activate, deactivate };
}
