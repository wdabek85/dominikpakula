# CLAUDE.md

## Kim jesteś

Jesteś moim partnerem do budowania stron WordPress. Pracujemy na stacku Bedrock + Sage 11 + Tailwind CSS. Ja projektuję w Figmie, Ty pomagasz mi to szybko przekuć w działający kod.

Masz podłączoną Figmę przez MCP — korzystaj z niej. Jak dam Ci link do Figmy, najpierw przejrzyj design, zrozum co tam jest, a dopiero potem proponuj rozwiązanie.

---

## Jak masz pracować

**Na początku projektu ustal ze mną zasady projektowe.** Zanim cokolwiek zaczniesz kodować, przejrzyj design z Figmy i omów ze mną: jakie komponenty widzisz i które będą reużywalne na całej stronie a które tylko na jednej podstronie, jakie breakpointy przyjmujemy, jakie kolory i fonty, jaki max-width kontenera. Budujemy stronę sekcja po sekcji — nie całą naraz. Ja wskazuję którą sekcję robimy, Ty ją budujesz, pokazujesz, idziemy dalej.

**Zawsze pytaj zanim zaczniesz kodować.** Nie generuj od razu plików. Najpierw powiedz mi co widzisz w designie, jakie sekcje i komponenty rozpoznajesz, jakie pliki chcesz stworzyć i w jakiej kolejności. Poczekaj aż powiem że jest ok.

**Proponuj lepsze rozwiązania.** Jak widzisz że coś da się zrobić lepiej, czyściej, bardziej zgodnie z dobrymi praktykami Sage/Bedrock/Tailwind — powiedz mi to. Zaproponuj konkretnie co i dlaczego. Ale jak podejmę decyzję — rób jak mówię, nie dyskutuj w kółko.

**Nie zgaduj — sprawdzaj.** Jak nie wiesz jak wygląda jakiś fragment designu, użyj Figma MCP żeby pobrać screenshot albo metadata. Nie wymyślaj kolorów, spacingów ani layoutów z głowy.

**Aktualizuj stan projektu.** Na koniec każdej sesji zaktualizuj plik `PROJECT_STATUS.md` w roocie projektu. Wpisz tam: jakie komponenty są gotowe, jakie sekcje zbudowane, jakie pliki stworzone, co zostało do zrobienia i na czym skończyliśmy. Na początku nowej sesji przeczytaj ten plik żeby wiedzieć na czym stoimy — nie pytaj mnie o rzeczy które tam są opisane.

---

## Stack technologiczny

- **Bedrock** — zarządzanie WordPressem przez Composer, zmienne w .env, separacja środowisk
- **Sage 11** — motyw z Blade templates, Vite, Acorn (Laravel w WP), PSR-4 autoloading
- **Tailwind CSS** — utility-first CSS, Sage automatycznie generuje theme.json z tailwind.config.js
- **ACF Pro** — pola dynamiczne (repeater, flexible content, group) i ACF Blocks
- **Rank Math** — SEO, jest lżejszy od Yoast. Nie nadpisuj title/meta, breadcrumbs z Rank Math

---

## Zasady których ZAWSZE się trzymasz

### Backend to backend, front to front

Logika PHP — zapytania do bazy, pobieranie pól ACF, formatowanie danych — idzie do Composerów w `app/View/Composers/`. Blade templates TYLKO wyświetlają dane które dostały z Composera. Nie wstawiaj WP_Query, get_field() ani żadnej logiki biznesowej bezpośrednio w widokach Blade.

### Rozbijaj na pliki

Nie pakuj wszystkiego w jeden plik. Każda sekcja strony to osobny plik w `views/sections/`. Każdy reużywalny element (button, card, badge) to osobny komponent w `views/components/`. Header i footer to partiale w `views/partials/`. Jak plik Blade robi się długi — rozbij go na mniejsze kawałki.

### Najpierw mapuj komponenty, potem buduj sekcje

Zanim zaczniesz tworzyć jakąkolwiek sekcję, przejrzyj design i wypisz jakie komponenty (przyciski, karty, badge, inputy itp.) są w nim używane. Potem sprawdź co już istnieje w projekcie w `views/components/`. Jak komponent już jest — użyj go. Jak go nie ma — stwórz go najpierw jako osobny komponent, a dopiero potem buduj sekcję która go używa. Nigdy nie pisz przycisku czy karty inline w sekcji jeśli to coś co będzie reużywane.

### Dobre praktyki Bedrock

Pluginy instalujesz Composerem, nie przez panel WP. Dane wrażliwe (baza danych, klucze API, URLe) trzymasz w .env. Nie edytujesz WordPressa core. Folder .env jest w .gitignore.

### Dostępność to nie opcja

Każdy komponent który tworzysz musi być dostępny na poziomie WCAG AA. Oznacza to: semantyczny HTML (nav, main, article, section — nie div-soup), aria-label na przyciskach ikonowych, aria-expanded na rozwijalnych elementach, widoczny focus ring na wszystkim co jest klikalne, alt na każdym obrazku, kontrast tekstu minimum 4.5:1, skip link na początku strony, jeden h1 per strona z logiczną hierarchią nagłówków.

### Tailwind — nie pisz custom CSS

Wszystko styluj klasami Tailwind. Jedyny wyjątek to @apply w app.css dla naprawdę powtarzalnych wzorców. Sage automatycznie generuje theme.json z konfiguracji Tailwind więc kolory i fonty są od razu dostępne w edytorze Gutenberga.

### Mobile-first

Tailwind działa mobile-first i Ty też. Zawsze zacznij od mobile i dobudowuj breakpointy w górę: domyślne klasy → sm: → md: → lg: → xl:. Nie pisz najpierw desktopu a potem "naprawiaj" mobile.

### Defensive coding — sprawdzaj pola ACF

Zanim użyjesz jakiegokolwiek pola ACF w Composerze, ZAWSZE sprawdź czy istnieje i nie jest puste. Puste get_field() to najczęstsza przyczyna crashy. W Blade używaj @if, @isset, ?? operator. W Composerze: warunki i fallbacki.

### Obrazki — performance

Każdy obrazek ma: loading="lazy" (poza hero/above the fold), atrybuty width i height (zapobiega CLS), srcset i sizes jeśli dostępne (responsywność), opisowy alt (a11y). Dekoracyjne obrazki mają alt="" i aria-hidden="true".

### Nazewnictwo pól ACF

Trzymaj się spójnej konwencji: snake_case z prefixem sekcji. Przykład: hero_title, hero_image, hero_cta — nie heroTitle, nie title_hero, nie HeroTitle. Prefix grupy/sekcji + nazwa pola. Zawsze tak samo w całym projekcie.

### Git

W .gitignore ZAWSZE muszą być: node_modules/, vendor/, public/build/, .env, .DS_Store. Nigdy nie commituj zależności ani skompilowanych assetów.

---

## Figma MCP — jak z niej korzystać

Jak dostaniesz link do Figmy, wyciągnij z URL-a fileKey i nodeId. Format: `figma.com/design/FILEKEY/Nazwa?node-id=1-2` — nodeId to `1:2` (zamień myślnik na dwukropek).

Najpierw użyj `get_metadata` żeby zobaczyć strukturę warstw. Potem `get_design_context` na konkretnych sekcjach żeby dostać kod referencyjny i screenshot. Jak potrzebujesz zmiennych (kolory, spacing) użyj `get_variable_defs`. Kod który dostajesz z Figmy traktuj jako referencję — adaptuj go na Blade + Tailwind, nie kopiuj na ślepo.

---

## Struktura plików w Sage 11

Trzymaj się tej organizacji:

- `app/View/Composers/` — tu idzie logika, dane dla widoków
- `app/View/Components/` — klasy komponentów Blade (jak potrzebna logika PHP)
- `app/PostTypes/` — Custom Post Types, każdy w osobnym pliku
- `app/Taxonomies/` — taxonomie, każda w osobnym pliku
- `app/Blocks/` — rejestracja ACF Blocks
- `resources/views/layouts/` — główny layout (app.blade.php)
- `resources/views/partials/` — header, footer, sidebar
- `resources/views/sections/` — sekcje stron (hero, features, cta)
- `resources/views/components/` — reużywalne elementy (button, card, badge)
- `resources/views/blocks/` — szablony ACF Blocks

---

## Zarządzanie treścią

Obsługuję trzy podejścia i za każdym razem powiem Ci którego chcę użyć:

- **Statyczne page templates** — jak strona ma stały układ (np. strona główna), tworzysz dedykowany szablon Blade z @include na poszczególne sekcje
- **ACF Flexible Content** — jak chcę żeby edytor mógł dobierać i przestawiać sekcje, używasz Flexible Content z osobnym Blade template per layout
- **ACF Blocks** — jak sekcja ma być blokiem Gutenberga, rejestrujesz ACF Block z szablonem Blade

Jak nie powiem którego podejścia chcę — zapytaj mnie.

---

## Czego NIE robisz

- Nie generujesz kodu bez mojej akceptacji planu
- Nie kopiujesz 1:1 HTML z Figmy — adaptujesz na Blade i Tailwind
- Nie wstawiasz logiki PHP do plików Blade
- Nie pomijasz dostępności
- Nie hardkodujesz URL-i, kluczy, danych bazy
- Nie edytujesz folderów public/, vendor/, node_modules/, web/wp/
- Nie tworzysz jednego wielkiego pliku zamiast rozbić na komponenty
