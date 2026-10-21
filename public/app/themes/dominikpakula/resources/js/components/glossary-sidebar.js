/**
 * Glossary Sidebar — single hasła słowniczka.
 *
 * [data-glossary-sidebar]
 *   [data-glossary-search]  — filtr na żywo (bez wielkości liter i polskich znaków)
 *   [data-glossary-group]   — litera; [data-glossary-toggle] (aria-expanded) + [data-glossary-panel]
 *   [data-glossary-term]    — hasło (wartość = tytuł)
 *   [data-glossary-empty]   — komunikat „brak wyników”
 *
 * Podczas wyszukiwania rozwija litery z wynikami; po wyczyszczeniu wraca do stanu początkowego.
 */
const normalize = (text) =>
  text
    .toLowerCase()
    .replace(/ł/g, 'l')
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .trim();

const setOpen = (group, open) => {
  const toggle = group.querySelector('[data-glossary-toggle]');
  const panel = group.querySelector('[data-glossary-panel]');
  const icon = toggle.querySelector('svg');

  toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  panel.hidden = !open;
  icon?.classList.toggle('rotate-180', open);
};

export default function glossarySidebar() {
  document.querySelectorAll('[data-glossary-sidebar]').forEach((sidebar) => {
    const groups = Array.from(sidebar.querySelectorAll('[data-glossary-group]'));
    const search = sidebar.querySelector('[data-glossary-search]');
    const empty = sidebar.querySelector('[data-glossary-empty]');

    groups.forEach((group) => {
      group.querySelector('[data-glossary-toggle]').addEventListener('click', () => {
        const isOpen = group.querySelector('[data-glossary-toggle]').getAttribute('aria-expanded') === 'true';
        setOpen(group, !isOpen);
      });
    });

    // Bieżące hasło widoczne w przewijanej liście
    const current = sidebar.querySelector('[aria-current="page"]');
    const list = sidebar.querySelector('[data-glossary-list]');
    if (current && list) {
      list.scrollTop = current.closest('[data-glossary-group]').offsetTop;
    }

    if (!search) return;

    search.addEventListener('input', () => {
      const query = normalize(search.value);
      let matches = 0;

      groups.forEach((group) => {
        const terms = group.querySelectorAll('[data-glossary-term]');
        let groupMatches = 0;

        terms.forEach((term) => {
          const hit = !query || normalize(term.dataset.glossaryTerm).includes(query);
          term.hidden = !hit;
          if (hit) groupMatches++;
        });

        group.hidden = groupMatches === 0;
        matches += groupMatches;
        setOpen(group, query ? groupMatches > 0 : group.dataset.initialOpen === 'true');
      });

      if (empty) empty.hidden = matches > 0;
    });
  });
}
