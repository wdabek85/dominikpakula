/**
 * Blog share — Copy link to clipboard with visual feedback.
 */
export default function blogShare() {
  document.querySelectorAll('[data-share-copy]').forEach((btn) => {
    const label = btn.querySelector('[data-share-copy-label]');
    const icon = btn.querySelector('[data-share-copy-icon]');
    const originalLabel = label ? label.textContent : '';
    const originalIcon = icon ? icon.innerHTML : '';

    btn.addEventListener('click', async () => {
      const url = btn.dataset.shareUrl || window.location.href;

      try {
        await navigator.clipboard.writeText(url);
      } catch {
        const textarea = document.createElement('textarea');
        textarea.value = url;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
          document.execCommand('copy');
        } catch {
          /* give up */
        }
        document.body.removeChild(textarea);
      }

      if (label) label.textContent = 'Skopiowano';
      if (icon) {
        icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75 10.5 18.75 19.5 5.25"/></svg>`;
      }

      btn.dataset.copied = 'true';
      btn.style.backgroundColor = '#059669'; // emerald-600
      btn.style.borderColor = '#059669';

      setTimeout(() => {
        if (label) label.textContent = originalLabel;
        if (icon) icon.innerHTML = originalIcon;
        btn.style.backgroundColor = '';
        btn.style.borderColor = '';
        delete btn.dataset.copied;
      }, 1800);
    });
  });
}
