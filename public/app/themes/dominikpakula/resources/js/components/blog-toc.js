/**
 * Blog TOC — auto-build list of H2/H3 anchors + scroll-spy active state.
 *
 * Reads id'ed H2/H3 from .post-content (ids injected by PHP filter),
 * renders <ul> into each [data-toc-target] (desktop + mobile),
 * highlights active entry via IntersectionObserver.
 * Hides the entire TOC if fewer than 2 headings.
 */
export default function blogToc() {
  const content = document.querySelector('.post-content');
  if (!content) return;

  const headings = Array.from(content.querySelectorAll('h2[id], h3[id]'));
  const targets = document.querySelectorAll('[data-toc-target]');
  if (!targets.length) return;

  // Fewer than 2 headings → keep TOC hidden (wrappers already have .hidden)
  if (headings.length < 2) return;

  // Build list into each target (desktop + mobile)
  targets.forEach((target) => {
    target.innerHTML = '';
    const ul = document.createElement('ul');
    ul.className = 'flex flex-col gap-1';

    headings.forEach((h) => {
      const li = document.createElement('li');
      const a = document.createElement('a');
      a.href = '#' + h.id;
      a.textContent = h.textContent;
      a.dataset.tocLink = h.id;

      const isH3 = h.tagName === 'H3';
      li.className = isH3 ? 'pl-4' : '';
      a.className = [
        'block font-poppins leading-snug py-1 pl-3 -ml-[2px]',
        'border-l-2 border-transparent',
        isH3 ? 'text-xs text-black/60' : 'text-sm text-black/70',
        'hover:text-primary transition-colors',
      ].join(' ');

      li.appendChild(a);
      ul.appendChild(li);
    });

    target.appendChild(ul);
  });

  // Reveal wrappers: zdejmij initial "hidden", desktop wrapper ma być flex, mobile <details> zostaje block
  document.querySelectorAll('#blog-toc-desktop-wrapper, #blog-toc-mobile-wrapper').forEach((el) => {
    el.classList.remove('hidden');
    if (el.tagName === 'DIV') {
      el.classList.add('flex');
    }
  });

  // Scroll-spy
  let currentId = null;

  const setActive = (id) => {
    if (id === currentId) return;
    currentId = id;
    document.querySelectorAll('[data-toc-link]').forEach((link) => {
      const active = link.dataset.tocLink === id;
      link.classList.toggle('text-primary', active);
      link.classList.toggle('font-semibold', active);
      link.classList.toggle('border-primary', active);
      link.classList.toggle('border-transparent', !active);
    });
  };

  const observer = new IntersectionObserver(
    (entries) => {
      // Pick top-most intersecting heading
      const visible = entries
        .filter((e) => e.isIntersecting)
        .sort((a, b) => a.boundingClientRect.top - b.boundingClientRect.top);
      if (visible.length) {
        setActive(visible[0].target.id);
      }
    },
    {
      rootMargin: '-20% 0% -70% 0%',
      threshold: 0,
    }
  );

  headings.forEach((h) => observer.observe(h));

  // Smooth scroll with header offset (nav is sticky at ~4rem → adjust)
  document.querySelectorAll('[data-toc-link]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const id = link.dataset.tocLink;
      const target = document.getElementById(id);
      if (!target) return;
      e.preventDefault();
      const y = target.getBoundingClientRect().top + window.scrollY - 24;
      window.scrollTo({ top: y, behavior: 'smooth' });
      // Update hash without causing jump
      history.replaceState(null, '', '#' + id);
    });
  });
}
