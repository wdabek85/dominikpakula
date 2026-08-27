# Project Status — dominikpakula

## Stack
- Bedrock 1.30.0 (web root zmieniony na `public/` dla Local by Flywheel)
- Sage 11.0.3 (motyw: `dominikpakula`)
- Acorn v5.1.0 (tylko w Sage)
- WordPress 6.9.4
- PHP 8.5 (Local) / 8.4 (staging na dhosting przez `/usr/bin/php84`)
- Node 24+ lokalnie / 20+ na stagingu (z NVM)
- **Tailwind CSS v4** (konfiguracja przez `@theme` w `app.css`, BEZ `tailwind.config.js`)
- Tailwind Typography (`@tailwindcss/typography`) — klasy `prose` do WYSIWYG
- ACF Pro (aktywny)
- Rank Math (zainstalowany)

## Design tokens
- Max-width: 1440px
- Primary color: `#282435`
- Surface (karty, subtelne tła): `#f1f1f1` (zmienione z `#f9f9f9` w sezonie 2 dla lepszego kontrastu)
- Tekst akcent: `#19121e`
- Fonty: Inter (sans), Poppins (poppins), PT Serif (serif), Metrophobic (metro), Oswald (oswald), Work Sans (work)
- Desktop padding: 80px lewo/prawo, 48px góra/dół
- Mobile padding: 16px lewo/prawo, 32px góra/dół

## Git — 3 branche
- `develop` — lokalny development
- `staging` — serwer stagingowy (dominikpakula.wdb-creative.pl)
- `main` — produkcja

## Architektura — ACF Blocks
Wszystkie sekcje są rejestrowane jako ACF Blocks w `app/blocks.php`. Klient układa sekcje w Gutenbergu — pełna edytowalność.

Rejestracja bloków: `app/blocks.php` (załadowany w functions.php)
Kategoria bloków: "Motyw" (slug: `theme`)

## Struktura motywu
```
resources/views/
├── layouts/
│   └── app.blade.php
├── blocks/                                  ← ACF Blocks
│   ├── hero.blade.php
│   ├── video.blade.php
│   ├── blog.blade.php
│   ├── blog-archive.blade.php               ← Archiwum z filtrami + paginacja (sezon 2)
│   ├── contact.blade.php
│   ├── newsletter.blade.php                 ← SVG illustration z resources/images/
│   ├── subscribe.blade.php                  ← Wrapper @include('partials.blog.subscribe') (sezon 2)
│   ├── voucher.blade.php
│   ├── features.blade.php
│   ├── knowledge-base.blade.php             ← Najnowszy blog + lista poradników
│   ├── page-header.blade.php                ← Breadcrumb + tytuł + opis
│   ├── service-desc.blade.php               ← Opis Usługi / Dla Kogo
│   ├── service-what.blade.php               ← Opis Usługi / Co Dostaniesz
│   ├── service-why.blade.php                ← Opis Usługi / Dlaczego Warto
│   ├── service-process.blade.php            ← Opis Usługi / Proces Współpracy
│   ├── service-faq.blade.php                ← Opis Usługi / FAQ (accordion)
│   ├── subpage-hero.blade.php               ← Hero Podstrona (2 zdjęcia + tytuł)
│   ├── services/
│   │   ├── index.blade.php                  ← Highlight card + 3 service cards
│   │   └── highlight-card.blade.php         ← Auto-height stretch + zoom obrazu
│   ├── offer/
│   │   └── index.blade.php
│   ├── process/
│   │   ├── index.blade.php
│   │   └── step-card.blade.php
│   ├── testimonials/
│   │   └── index.blade.php
│   └── portfolio/
│       └── index.blade.php
├── sections/
│   ├── header.blade.php
│   ├── header/
│   │   ├── nav-desktop.blade.php            ← Mega-menu (Usługi + Baza Wiedzy z zajawkami)
│   │   └── nav-mobile.blade.php             ← 4-panelowe slide menu
│   ├── footer.blade.php                     ← 4-5 col, dynamic services + WP menu (sezon 2)
│   ├── sidebar.blade.php
│   └── service/
│       ├── breadcrumbs.blade.php
│       ├── header.blade.php
│       ├── sidebar.blade.php
│       └── testimonials.blade.php
├── components/
│   ├── alert.blade.php
│   ├── badge.blade.php
│   ├── blog-card.blade.php                  ← Rozszerzony: category, authorAvatar, authorRole, withShadow
│   ├── button.blade.php
│   ├── eyebrow.blade.php
│   ├── gift-banner.blade.php
│   ├── portfolio-card.blade.php
│   ├── section.blade.php
│   ├── service-card.blade.php               ← 3 warianty + hover lift/shadow + ikona aspect-fit
│   ├── testimonial-card.blade.php
│   ├── video-section.blade.php
│   └── icons/                               ← 20 ikon
│       ├── arrow-left.blade.php
│       ├── arrow-long-right.blade.php
│       ├── arrow-right.blade.php
│       ├── arrow-up-right.blade.php
│       ├── check.blade.php
│       ├── chevron-down.blade.php
│       ├── chevron-right.blade.php
│       ├── document.blade.php               ← (sezon 2) NIP/REGON w stopce
│       ├── envelope.blade.php
│       ├── facebook.blade.php
│       ├── hanger.blade.php                 ← (sezon 2) Lucide hanger, lista usług w stopce
│       ├── instagram.blade.php
│       ├── link.blade.php
│       ├── location.blade.php               ← (sezon 2) adres w stopce
│       ├── menu-icon.blade.php
│       ├── messenger.blade.php
│       ├── phone.blade.php
│       ├── play-circle.blade.php
│       ├── tiktok.blade.php
│       ├── whatsapp.blade.php
│       └── x-mark.blade.php
├── partials/
│   ├── booking-modal.blade.php
│   ├── voucher-modal.blade.php
│   ├── comments.blade.php
│   ├── content.blade.php
│   ├── content-page.blade.php
│   ├── content-search.blade.php
│   ├── content-single.blade.php
│   ├── entry-meta.blade.php
│   ├── page-header.blade.php
│   └── blog/                                ← 13 partiali blogowych
│       ├── author-bio.blade.php
│       ├── body.blade.php
│       ├── booking-cta.blade.php
│       ├── breadcrumbs.blade.php
│       ├── browse-full.blade.php
│       ├── hero.blade.php
│       ├── prev-next.blade.php
│       ├── related-posts.blade.php
│       ├── related-teaser.blade.php
│       ├── share.blade.php
│       ├── sidebar.blade.php
│       ├── subscribe.blade.php              ← Newsletter+Instagram (też w blocks/subscribe)
│       └── toc.blade.php
├── forms/
│   └── search.blade.php
├── 404.blade.php
├── index.blade.php
├── page.blade.php
├── search.blade.php
├── single.blade.php
├── single-post.blade.php                    ← Szablon pojedynczego wpisu blogowego
├── single-service.blade.php                 ← Szablon usługi (7fr/3fr grid + sticky sidebar)
├── template-blocks.blade.php                ← "Strona z blokami" (Voucher, Baza Wiedzy, Blog)
├── template-custom.blade.php
└── template-front-page.blade.php

app/
├── blocks.php                               ← Rejestracja ACF Blocks (20 bloków)
├── setup.php                                ← Theme support + 2 menu locations (primary, footer)
├── filters.php
├── site-settings.php                        ← ACF Options Page registration
├── booking.php
├── blog.php
├── PostTypes/
│   ├── Guide.php                            ← CPT "Poradniki" (/poradniki/)
│   ├── Portfolio.php                        ← CPT "Realizacje" (/realizacje/)
│   ├── Service.php                          ← CPT "Usługi" (/uslugi/)
│   └── Testimonial.php                      ← CPT "Opinie" (non-public)
├── Taxonomies/
│   └── Season.php                           ← (sezon 2) Custom taxonomy "Sezony" (/sezon/)
├── Booking/                                 ← System rezerwacji (REST API + Mail + Calendar)
│   ├── Admin.php
│   ├── Api.php
│   ├── Calendar.php
│   ├── ContactApi.php
│   ├── EmailTemplates.php
│   ├── Mail.php
│   ├── NewsletterApi.php
│   ├── PostTypes.php
│   └── VoucherApi.php
├── Blog/
│   ├── Filters.php
│   └── Helpers.php
├── Providers/
│   └── ThemeServiceProvider.php
└── View/Composers/
    ├── App.php
    ├── BlogArchiveBlockComposer.php         ← (sezon 2) Filtry + paginacja blog-archive
    ├── BlogBlockComposer.php
    ├── Comments.php
    ├── FeaturesBlockComposer.php
    ├── HeroComposer.php
    ├── KnowledgeBaseBlockComposer.php
    ├── NavigationComposer.php               ← Mega-menu + footer + footer_navigation menu
    ├── OfferBlockComposer.php
    ├── PageHeaderBlockComposer.php
    ├── PortfolioBlockComposer.php
    ├── Post.php
    ├── ProcessBlockComposer.php
    ├── ServiceComposer.php
    ├── ServiceDescBlockComposer.php
    ├── ServiceFaqBlockComposer.php
    ├── ServiceProcessBlockComposer.php
    ├── ServicesBlockComposer.php
    ├── ServiceTestimonialsComposer.php
    ├── ServiceWhatBlockComposer.php
    ├── ServiceWhyBlockComposer.php
    ├── SinglePostComposer.php
    ├── SiteSettings.php                     ← Globalne $contact + $social
    ├── SubpageHeroBlockComposer.php
    ├── TestimonialsBlockComposer.php
    ├── VideoBlockComposer.php
    └── VoucherBlockComposer.php

resources/js/
├── app.js                                   ← import.meta.glob('../images/**') + komponenty
├── editor.js
├── admin/
│   └── booking-calendar.js
├── lib/
│   └── modal-a11y.js                        ← Focus trap helper
└── components/
    ├── blog-share.js
    ├── blog-toc.js
    ├── booking.js
    ├── contact-form.js
    ├── drag-scroll.js
    ├── faq-accordion.js
    ├── lite-youtube.js
    ├── mega-menu.js
    ├── mobile-menu.js
    ├── newsletter-form.js
    ├── slider-arrows.js
    ├── sticky-price-bar.js
    ├── testimonial-video.js
    └── voucher.js

resources/css/
├── app.css                                  ← Tailwind v4 + @theme + typography plugin
└── editor.css

resources/images/
├── newsletter.svg                           ← (sezon 2) ilustracja w bloku newsletter
└── video-bg.jpg
```

## ACF Blocks — zarejestrowane (20 bloków)
| Blok | Widok | Composer | Status |
|------|-------|----------|--------|
| Hero | blocks.hero | HeroComposer | Gotowy |
| Video | blocks.video | VideoBlockComposer | Gotowy |
| Usługi | blocks.services.index | ServicesBlockComposer | Gotowy |
| Pełna Oferta | blocks.offer.index | OfferBlockComposer | Gotowy (wariant compact/detailed) |
| Proces Współpracy | blocks.process.index | ProcessBlockComposer | Gotowy |
| Opinie | blocks.testimonials.index | TestimonialsBlockComposer | Gotowy |
| Portfolio | blocks.portfolio.index | PortfolioBlockComposer | Gotowy |
| Voucher | blocks.voucher | VoucherBlockComposer | Gotowy |
| Blog | blocks.blog | BlogBlockComposer | Gotowy (3 najnowsze) |
| **Blog – Archiwum z filtrami** | blocks.blog-archive | **BlogArchiveBlockComposer** | **Gotowy (sezon 2)** |
| **Poradniki – Archiwum** | blocks.guides-archive | **GuidesArchiveBlockComposer** | **Gotowy — grid guide + paginacja + pusty stan z CTA newsletter** |
| **Konsultacja / Jak to działa** | blocks.consultation-process | **ConsultationProcessBlockComposer** | **Gotowy — schodkowe 4 kroki + CTA .booking-trigger (podstrona /konsultacje/)** |
| Newsletter | blocks.newsletter | — | Gotowy (z SVG illustration) |
| **Newsletter + Instagram** | blocks.subscribe | — | **Gotowy (sezon 2)** |
| Kontakt | blocks.contact | — | Gotowy |
| Baza Wiedzy | blocks.knowledge-base | KnowledgeBaseBlockComposer | Gotowy (z zajawką pod tytułem) |
| Nagłówek Podstrony | blocks.page-header | PageHeaderBlockComposer | Gotowy |
| Dlaczego Warto / Voucher | blocks.features | FeaturesBlockComposer | Gotowy |
| Hero Podstrona | blocks.subpage-hero | SubpageHeroBlockComposer | Gotowy |
| Opis Usługi / Dla Kogo | blocks.service-desc | ServiceDescBlockComposer | Gotowy |
| Opis Usługi / Co Dostaniesz | blocks.service-what | ServiceWhatBlockComposer | Gotowy |
| Opis Usługi / Dlaczego Warto | blocks.service-why | ServiceWhyBlockComposer | Gotowy |
| Opis Usługi / Proces Współpracy | blocks.service-process | ServiceProcessBlockComposer | Gotowy |
| Opis Usługi / FAQ | blocks.service-faq | ServiceFaqBlockComposer | Gotowy |

## Custom Post Types (4)
| CPT | Slug | Plik | Opis |
|-----|------|------|------|
| Opinie | testimonial | PostTypes/Testimonial.php | Opinie klientów (non-public) |
| Realizacje | portfolio | PostTypes/Portfolio.php | Portfolio prac (public, /realizacje/) |
| Usługi | service | PostTypes/Service.php | Usługi (public, /uslugi/, editor+thumbnail) |
| Poradniki | guide | PostTypes/Guide.php | Poradniki (public, /poradniki/) |

## Custom Taxonomies (2)
| Taxonomia | Slug | Powiązana z | Plik | Opis |
|-----------|------|-------------|------|------|
| Sezony | season | post (blog) | Taxonomies/Season.php | Hierarchiczna, /sezon/, dla filtra blog-archive |
| Kategorie poradników | guide_category | guide (poradniki) | Taxonomies/GuideCategory.php | Hierarchiczna, /temat-poradnika/, dla filtra guides-archive |

## Szablony stron
| Szablon | Plik | Opis |
|---------|------|------|
| Front Page | template-front-page.blade.php | Strona główna (the_content z blokami) |
| Strona z blokami | template-blocks.blade.php | Podstrony bez tytułu (Usługi, Voucher, Baza Wiedzy, Blog) |
| Single Service | single-service.blade.php | Pojedyncza usługa (grid 7fr/3fr + sticky sidebar) |
| Single Post | single-post.blade.php | Pojedynczy wpis blogowy (z TOC, share, prev/next, autor, related) |
| Single Guide | single-guide.blade.php | Pojedynczy poradnik (hero + TOC + share + chipsy guide_category + related guides + newsletter + powrót) |

## Szablon usługi (single-service)
- **Layout:** grid `7fr_3fr` z `gap-10` na desktop, kolumna na mobile
- **Breadcrumbs:** szary pasek full-width, schema.org markup, scroll na mobile
- **Lewa kolumna:** social proof + zdjęcie + `the_content()` (bloki Gutenberga)
- **Prawa kolumna:** sticky sidebar (Trustpilot, tytuł ACF, opis ACF, CTA hardcode, cena ACF, tagi ACF)
- **Pod gridem:** testimonials (3 ostatnie) + blog (3 najnowsze)
- **ACF pola na CPT service:** service_sidebar_title, service_sidebar_description, service_price, service_tags (repeater)

## Mega-menu (nawigacja)
### Desktop
- Full-width panel pod headerem, biały, shadow-xl
- Lewa kolumna (280px): lista usług z hover highlight
- Prawa kolumna: podgląd aktywnej usługi (duże zdjęcie + tytuł + opis + link)
- Panel "Baza Wiedzy" — Blog + Poradniki w 2 kolumnach z zajawkami pod tytułami
- Dane z NavigationComposer (CPT service + post + guide)

### Mobile
- 4-panelowe slide menu:
  1. Menu główne → klik "Usługi" / "Baza Wiedzy"
  2. Lista usług → klik na usługę
  3. Szczegóły usługi (zdjęcie + opis + CTA) + "← Wstecz"
  4. Baza Wiedzy: Blog + Poradniki z zajawkami

## Strona Blog — zbiorcza (sezon 2)
- Slug: `/blog/` (page ID 256 lokalnie, 258 na staging)
- Szablon: `template-blocks.blade.php`
- 4 bloki w content (kolejność): page-header → blog-archive → subscribe → contact
- **blog-archive**:
  - Pasek filtrów: chipsy kategorii (z "Pokaż wszystkie") + dropdown sezonu (`<details>` z `w-max`)
  - Filtry przez query string: `?category=moda&season=lato`
  - 3-kolumnowy grid (1/2/3 responsive), 9 wpisów/strona (hardcoded)
  - `paginate_links()` + custom Tailwind classes na ul/li/a
  - Karty: `<x-blog-card>` z propsami category, authorAvatar (`get_avatar_url`), authorRole (z ACF user `author_role`)
  - Empty states różne dla "brak wpisów" vs "brak po filtrowaniu"

## Footer (sezon 2)
- 4 kolumny na desktop (5 gdy menu WP jest przypisane):
  1. Logo (z `has_custom_logo()` jak w headerze, fallback `$siteName`) + slogan
  2. Dane formalne: adres + NIP + REGON (z `$contact` lub italicized placeholdery)
  3. Dane kontaktowe: telefon + email + Instagram (z `$contact` / `$social` + fallbacki)
  4. **Nawigacja** (kondycyjna): WP menu z lokalizacji `footer_navigation` przez `NavigationComposer::menuForLocation()`
  5. Moje usługi: dynamicznie z CPT service przez `$navServices` (NavigationComposer też dla `sections.footer`)
- Tło: `bg-[#f1f1f1]` (jak karty usług)
- Dolny pasek (`bg-white`): copyright + Polityka prywatności + Regulamin
- Ikony: hanger (Lucide), document, location (Heroicons)

## WP Menu Locations (2)
| Lokalizacja | Plik rejestrujący | Użycie |
|-------------|-------------------|--------|
| primary_navigation | app/setup.php | Zarejestrowana (na wypadek standardowego nav, ale faktycznie używamy mega-menu z CPT) |
| footer_navigation | app/setup.php | Wyświetlana w stopce (kolumna "Nawigacja"); dynamiczna z `Wygląd → Menu` |

## Komponenty Blade (13)
| Komponent | Plik | Opis |
|-----------|------|------|
| Alert | components/alert.blade.php | Komponent alertu |
| Badge | components/badge.blade.php | Reużywalny badge z border |
| Block Placeholder | components/block-placeholder.blade.php | Podgląd pustego bloku w edytorze (tytuł + hint + slot na szkielet layoutu). Tylko edytor, nigdy front. |
| Blog Card | components/blog-card.blade.php | + propsy: category, authorAvatar, authorRole, withShadow, hover zoom obrazu |
| Button | components/button.blade.php | Primary/secondary, lg/sm, z ikoną |
| Eyebrow | components/eyebrow.blade.php | Mały label nad tytułami |
| Gift Banner | components/gift-banner.blade.php | Banner "Pomysł na prezent" |
| Portfolio Card | components/portfolio-card.blade.php | Karta realizacji |
| Section | components/section.blade.php | Wrapper sekcji z paddingami |
| Service Card | components/service-card.blade.php | 3 warianty + hover lift/shadow + ikona aspect-fit (h-20 w-auto self-start) |
| Testimonial Card | components/testimonial-card.blade.php | Karta opinii (text-only, duży serif cudzysłów + hanging quote, sezon 5) |
| Video Section | components/video-section.blade.php | YouTube lazy embed |

## Ikony (20)
arrow-left, arrow-long-right, arrow-right, arrow-up-right, check, chevron-down, chevron-right, **document**, envelope, facebook, **hanger**, instagram, link, **location**, menu-icon, messenger, phone, play-circle, tiktok, whatsapp, x-mark

## JS Moduły (14)
| Moduł | Plik | Opis |
|-------|------|------|
| Mobile Menu | mobile-menu.js | 4-panelowe slide menu |
| Mega Menu | mega-menu.js | Desktop mega-menu hover + detail switch |
| FAQ Accordion | faq-accordion.js | Toggle accordion (one open at a time) |
| Lite YouTube | lite-youtube.js | Lazy load YouTube iframe |
| Testimonial Video | testimonial-video.js | Modal z wideo dla opinii |
| Drag Scroll | drag-scroll.js | Horizontal drag scroll dla sliderów |
| Slider Arrows | slider-arrows.js | Prev/next nawigacja strzałkami |
| Booking | booking.js | Modal rezerwacji + kalendarz |
| Voucher | voucher.js | Modal voucheru |
| Contact Form | contact-form.js | Handler formularza kontaktowego |
| Newsletter Form | newsletter-form.js | Handler newslettera |
| Sticky Price Bar | sticky-price-bar.js | Pływający pasek z ceną na single-service |
| Blog TOC | blog-toc.js | Spis treści w single-post |
| Blog Share | blog-share.js | Buttony share w single-post |
| Booking Calendar (admin) | admin/booking-calendar.js | Admin kalendarz rezerwacji |

## Co zostało do zrobienia
- [x] Stworzyć pola ACF w panelu WP dla WSZYSTKICH bloków
- [x] CPT Service + szablon single-service
- [x] Mega-menu desktop + mobile
- [x] Hero Podstrona + szablon "Strona z blokami"
- [x] Staging deployment pipeline
- [x] Code review — wszystkie 20 issues naprawione (2026-04-21)
- [x] **Footer rewrite** — 4-5 col, dynamic services + WP menu (2026-04-22)
- [x] **Strona Blog zbiorcza** — page-header + blog-archive + subscribe + contact (2026-04-22)
- [x] **Custom taxonomy Season** — filtry w blog-archive (2026-04-22)
- [x] **Pole ACF user `author_role`** — utworzone lokalnie + na staging (2026-04-22)
- [ ] **Utworzyć ręcznie pola ACF na Options Page "Ustawienia strony"** (patrz sekcja niżej)
- [ ] **Pola ACF dla bloków na stronie Kontakt** (patrz sekcja "Strona Kontakt" niżej) — `acf/personal-intro` (intro_image, intro_heading, intro_text, intro_badge) + `acf/contact-channels` (channels_heading, channels_subtitle) + `acf/next-steps` (steps_heading, steps_subtitle). Bez nich bloki działają z fallbacków w Composerach
- [x] **Pola ACF dla bloków blogowych** ✅ (2026-04-29) — `acf/lookbook-section`, `acf/blog-pullquote`, `acf/blog-callout`, `acf/blog-personal-quote` utworzone w panelu lokalnie
- [x] **Pola ACF service-desc — refactor 3 sekcji** ✅ (2026-04-29) — desc_label, desc_heading, desc_positive_eyebrow/title, desc_highlight_eyebrow/title, desc_negative_eyebrow/title; usunięte stare desc_content (WYSIWYG)
- [x] **Pola ACF service-desc — repeatery items per usługa** ✅ (2026-05-21) — desc_positive_items / desc_highlight_items (Textarea, sub-field `item_text`) + desc_negative_items (WYSIWYG Basic, Visual Only, media off — żeby edytor wstawiał linki do innych usług). Composer odczytuje z fallbackiem do hardcoded list w `ServiceDescBlockComposer`.
- [x] **Pola ACF service — W cenie znajdziesz** ✅ (2026-04-29 → 2026-05-21 fix) — service_included_heading + service_included_items. Pierwotnie pole było utworzone jako Text (jednolinijka), mimo planu repeatera. 2026-05-21 zmienione na **Repeater (Powielacz)** z sub-fieldem `service_included_item` (Textarea); zsynchronizowane do `acf-json/group_69f246a2f3a88.json`. Composer `ServiceComposer::includedItems()` od początku oczekiwał tej struktury z fallbackiem hardcoded.
- [ ] **Pola ACF Single Portfolio** — `portfolio_intro` (Textarea), `portfolio_gallery` (Gallery, Array), `portfolio_category` (sprawdzić istnienie). Lokalizacja: Post Type → Realizacja
- [x] **Pełna strona Kontakt** ✅ — wszystkie bloki (page-header, contact-bar, personal-intro, contact-channels, next-steps, contact form, testimonials, subscribe) wstawione na stronie ID 270 (sezon 3, 2026-04-23/04-28)
- [x] **service-desc rebuild** ✅ — editorial layout 3 sekcje stackowane na szarym tle (sezon 3)
- [x] **Sidebar single-service wzbogacony** ✅ — W cenie znajdziesz + Opinia klienta + Sprawdź też inne usługi (sezon 3)
- [ ] **Refaktor hardcodów na ACF** — patrz sekcja "Hardcode w blokach (do przepisania na dynamiczne ACF)" niżej. Priorytet: Options Page → service_included_items → personal-intro (~~service-desc repeatery~~ ✅ 2026-05-21)
- [ ] **Utworzyć WP menu i przypisać do "Footer Navigation"** (Wygląd → Menu) — bez tego kolumna "Nawigacja" w stopce się ukrywa
- [ ] **Polityka prywatności** + **Regulamin** — strony prawne (footer linki obecnie w 404)
- [ ] Podstrony "O mnie", "Kontakt"
- [x] **Eksport pól ACF do JSON** ✅ (2026-05-20) — zastąpione przez auto-sync `acf-json/` folder w temacie. Każda zmiana field group w panelu lokalnie auto-zapisuje JSON. Na stagingu ACF auto-wczytuje z `local=json`. Stara metoda ręcznego eksportu/importu jest niepotrzebna.
- [ ] **Ujednolicić wizualnie blok "Opis Usługi / Dla Kogo"** (`blocks.service-desc`) z blokiem "Opis Usługi / Dlaczego Warto" (`blocks.service-why`) — pierwsza sekcja pod zdjęciem na stronie usługi ma używać tego samego wzorca karty co "Dlaczego Warto" na dole strony

## Pola ACF — pełna checklista do utworzenia w panelu WP

> Wszystkie bloki działają z hardcodowanych fallbacków w Composerach dopóki pola w panelu nie powstaną. Po dodaniu pól wartości z ACF nadpiszą fallbacki automatycznie. Lista grupowana po lokalizacjach.

### Grupa: **Ustawienia strony** (lokalizacja: `Options Page → Ustawienia strony`)

**Kontakt**
- [ ] `contact_email` (Email)
- [ ] `contact_phone` (Text, format wyświetlania: `+48 884 826 068`)
- [ ] `contact_phone_link` (Text, format `tel:`: `+48884826068`)
- [ ] `contact_address_line1` (Text)
- [ ] `contact_address_line2` (Text)
- [ ] `contact_sidebar_phone` (Text, telefon w sidebarze usługi)
- [ ] `contact_sidebar_phone_link` (Text, format `tel:`)

**Social media**
- [ ] `social_facebook_url` (URL)
- [ ] `social_instagram_url` (URL)
- [ ] `social_instagram_handle` (Text, np. `dpakula_stylist` — bez `@`)
- [ ] `social_whatsapp_url` (URL, opcjonalne — domyślnie wyliczane z `contact_phone_link`)
- [ ] `social_tiktok_url` (URL)
- [ ] `social_twitter_url` (URL)

### Grupa: **Profil autora** (lokalizacja: `User Form is equal to All`)
- [x] `author_role` (Text, np. "Osobisty Stylista od 2020") — utworzone lokalnie 2026-04-22, **na staging do zrobienia**

### Grupa: **Personal Intro** (lokalizacja: `Block is equal to acf/personal-intro`)
Blok na stronie Kontakt, sekcja humanizująca z avatarem Dominika.
- [ ] `intro_image` (Image, return Array) — duże zdjęcie autora (~220×220, kółko)
- [ ] `intro_heading` (Text, fallback: "Cześć, jestem Dominik")
- [ ] `intro_text` (Textarea, fallback: "Pisz do mnie bez krępacji…")
- [ ] `intro_badge` (Text, fallback: "Odpowiadam w 24h" — pusta=ukryje badge)

### Grupa: **Kanały kontaktu** (lokalizacja: `Block is equal to acf/contact-channels`)
Blok na stronie Kontakt, 4 kafelki instant-CTA.
- [ ] `channels_heading` (Text, fallback: "Wybierz wygodny kanał")
- [ ] `channels_subtitle` (Text, fallback: "Każda wiadomość trafia bezpośrednio do mnie…")

### Grupa: **Co dalej? (3 kroki)** (lokalizacja: `Block is equal to acf/next-steps`)
Blok na stronie Kontakt, 3-stopniowy timeline.
- [ ] `steps_heading` (Text, fallback: "Co dalej? Tak wygląda nasza pierwsza wymiana")
- [ ] `steps_subtitle` (Text, fallback: "Bez tajemnic — wiesz dokładnie co Cię czeka.")
- *(opcjonalnie później jeśli chcesz pełną kontrolę nad krokami: repeater `steps_items` z polami `step_number`, `step_title`, `step_text` — obecnie 3 kroki hardcoded w `NextStepsBlockComposer.php`)*

### Grupa: **Opis Usługi / Dla Kogo** (lokalizacja: `Block is equal to acf/service-desc`)
Po przebudowie sezon 3 — editorial layout, 3 sekcje stackowane (TAK / POLECAM / RACZEJ NIE) z hardcodem w composerze. **Field group `group_69cbafc509318` w `acf-json/` — wersjonowana w git, na stagingu auto-wczytywana z JSON (local=json).**
- [x] `desc_label` (Text, fallback "Dla kogo")
- [x] `desc_heading` (Text, fallback "Czy ta usługa jest dla Ciebie?")
- [x] `desc_positive_eyebrow` / `desc_positive_title` (Text — eyebrow i title sekcji "Tak")
- [x] `desc_highlight_eyebrow` / `desc_highlight_title` (Text — sekcji "Polecam")
- [x] `desc_negative_eyebrow` / `desc_negative_title` (Text — sekcji "Raczej nie")
- [x] **Repeatery items** ✅ (2026-05-21) — `desc_positive_items` (Textarea), `desc_highlight_items` (Textarea), `desc_negative_items` (WYSIWYG Basic/Visual Only/media off). Każdy ma sub-field `item_text`. Hardcoded fallback w composerze zachowany — usługi z pustym repeaterem dalej działają.

### Grupa: **Usługa** (lokalizacja: `Post Type is equal to service`) — rozszerzona w sezonie 3
Pola dodatkowe do tych co już istnieją (service_sidebar_title/description/price/tags):
- [x] `service_included_heading` (Text, fallback "W cenie znajdziesz") ✅ (2026-05-21) — field group "Usługa Obejmuje" w `acf-json/group_69f246a2f3a88.json`
- [x] `service_included_items` (Repeater z sub-fieldem `service_included_item` Textarea) ✅ (2026-05-21) — pierwotnie pole było błędnie utworzone jako Text, naprawione na Repeater. Composer `ServiceComposer::includedItems()` ma fallback hardcoded (4 punkty) dla usług bez wpisanych pozycji. **✅ WYPEŁNIONE 2026-08-06** — wszystkie 6 usług na produkcji i stagingu + jedyna usługa istniejąca lokalnie (138), po 4 pozycje, z notatki usera (patrz sesja 2026-08-06). Fallback od tej pory nieaktywny dla tych usług.

### Sprawdzić czy istnieje (prawdopodobnie tak, bo używany na podstronach usług):
**Grupa: Blok Opinie** (lokalizacja: `Block is equal to acf/testimonials`)
- [ ] `testimonials_title` (Text)
- [ ] `testimonials_subtitle` (Text)
- [ ] `testimonials_items` (Relationship → testimonial, 0+ = puste, weź 3 najnowsze auto)

### Bloki BEZ pól ACF (działają hardcoded — żadnej akcji w panelu nie potrzeba):
- `acf/contact-bar` — używa globalnego `$contact` z Options Page
- `acf/subscribe` (Newsletter+Instagram) — czysty HTML w `partials/blog/subscribe.blade.php`
- `acf/contact` (formularz) — używa globalnego `$contact` + REST endpoint

### Po stronie staging (oprócz powyższych):
- [ ] WP Menu "Stopka" przypisany do lokalizacji "Footer Navigation" (Wygląd → Menu)
- [ ] Logo w Wygląd → Konfigurator → Tożsamość witryny → Logo
- [x] **Eksport ACF JSON na staging** ✅ (2026-05-20) — niepotrzebny dzięki auto-sync `acf-json/`. ACF na stagingu wczytuje field groups bezpośrednio z plików JSON po `git pull`.

## Code review — naprawione 2026-04-21
Wszystkie 20 issues z `project_code_review` (2026-04-01) zostało naprawione.

### Krytyczne
- **#1 Rate limiting** — `app/Booking/Api.php` funkcje `get_client_ip()`, `check_rate_limit()`. Booking 5/10min, voucher 5/10min, kontakt 3/10min per IP.
- **#2 GDPR timestamp** — `update_post_meta($id, '_booking_gdpr_accepted_at', ...)` + `_booking_gdpr_ip` zapisywane przy każdej rezerwacji.
- **#3 XSS** — `wp_kses_post()` dodane w OfferBlockComposer, ProcessBlockComposer, ServiceWhyBlockComposer, ServicesBlockComposer.
- **#4 Formularz kontaktowy** — nowy endpoint `/booking/v1/contact` (`app/Booking/ContactApi.php`) + JS `resources/js/components/contact-form.js` + honeypot + GDPR checkbox.
- **#5 Hardcoded dane kontaktowe** — przeniesione do ACF Options Page "Ustawienia strony" (`app/site-settings.php`) + Composer `SiteSettings` ($contact, $social globalnie).

### Wysoki priorytet
- **#6 N+1 queries** — `update_post_thumbnail_cache()` + `update_meta_cache()` w NavigationComposer, TestimonialsBlockComposer, KnowledgeBaseBlockComposer.
- **#7 Focus trap** — nowy helper `resources/js/lib/modal-a11y.js` + integracja w booking.js, voucher.js.
- **#8 Email From: header** — wspólny helper `booking_mail_headers()` z From + Reply-To, stosowany w Mail.php, VoucherApi.php, ContactApi.php.

### Średni priorytet
- **#9 Booking status** — domyślnie `pending`; UI "Rezerwacja przyjęta".
- **#10 FAQ focus-visible** — już było (service-faq.blade.php).
- **#11 Timezone JS** — `parseLocalDate()` (split + new Date(y, m-1, d)).
- **#12 Podwójne get_post_thumbnail_id** — ServiceComposer cache'uje `$thumbId`.
- **#13 Modal focus return** — `modal-a11y.js` przywraca focus na trigger po close.
- **#14 Empty states** — blog block renderuje tylko gdy są posty.
- **#15 Hardcoded kolory** — `#282435` w voucher.js → klasy Tailwind `bg-primary`/`text-primary`/`border-primary`.

### Niski priorytet
- **#16 Email template HTML** — booking_wrap_html ma html lang, meta charset, viewport, x-apple-disable-message-reformatting, tytuł, email CSS reset.
- **#17 Voucher recipient email** — walidowane `is_email()` jeśli podane, 400 gdy niepoprawne.
- **#18 Drag scroll keyboard** — arrow left/right, Home/End + role region, aria-label, tabindex.
- **#19 Service card icon fallback** — aria-hidden dla placeholderów w features, knowledge-base, nav-desktop, nav-mobile.
- **#20 Admin calendar inline JS** — `resources/js/admin/booking-calendar.js`, enqueue przez Vite + cap check `manage_options` w AJAX.

## Sezon 2 (2026-04-22) — co się zmieniło

### Nowe pliki
- `app/Taxonomies/Season.php` — custom taxonomy "Sezony"
- `app/View/Composers/BlogArchiveBlockComposer.php` — filtry + paginacja
- `resources/views/blocks/blog-archive.blade.php` — pasek filtrów + grid + paginacja
- `resources/views/blocks/subscribe.blade.php` — wrapper @include partials/blog/subscribe
- `resources/views/components/icons/{hanger,document,location}.blade.php` — 3 nowe ikony
- `resources/images/newsletter.svg` — ilustracja w bloku newsletter

### Zmienione
- `sections/footer.blade.php` — pełna przebudowa z domyślnego Sage stuba na 4-5 kolumnowy footer
- `app/setup.php` — rejestracja `footer_navigation` menu location
- `app/View/Composers/NavigationComposer.php` — bind `sections.footer`, metoda `menuForLocation()`, zwraca `$footerMenu`
- `app/blocks.php` — rejestracja bloków `blog-archive` i `subscribe`
- `app/View/Composers/KnowledgeBaseBlockComposer.php` — dodane pole `excerpt` dla poradników
- `resources/views/sections/header/nav-desktop.blade.php` — zajawki pod tytułami w panelu Baza Wiedzy
- `resources/views/sections/header/nav-mobile.blade.php` — zajawki w panelu mobile Baza Wiedzy
- `resources/views/components/blog-card.blade.php` — nowe propsy: category, authorAvatar, authorRole, withShadow + hover zoom
- `resources/views/components/service-card.blade.php` — hover anim group (lift, shadow, icon opacity, arrow translate) + ikony aspect-fit (h-20 w-auto self-start) + bg #f1f1f1
- `resources/views/blocks/services/highlight-card.blade.php` — auto-height stretch w flex (`lg:h-auto lg:min-h-[436px]`) + zoom obrazu na hover
- `resources/views/blocks/knowledge-base.blade.php` — zajawka pod tytułem poradnika
- `resources/views/blocks/newsletter.blade.php` — placeholder zastąpiony SVG illustration z `Vite::asset()`
- `resources/views/blocks/hero.blade.php` — CTA mobile: whitespace-nowrap + mniejszy text/padding
- Tło wszystkich subtle-gray surfaces: `#f9f9f9` → `#f1f1f1` (service-card, step-card, comments, blog/subscribe, blog/prev-next; ostatni z dopasowaniem hover #efefef → #e7e7e7)

### W panelu (do zrobienia ręcznie po deployu)
- Lokalnie: ✅ ACF user field `author_role`, kategorie (Moda), sezony (Lato), strona Blog, przypisania
- Staging: ✅ przez wp-cli — termy Moda + Lato, strona Blog (ID 258), `author_role` na admin
- Staging: ✅ ACF field groups auto-wczytywane z `acf-json/` (od 2026-05-20) — ręczny eksport/import zbędny
- Staging: ⏳ WP Menu "Stopka" przypisany do "Footer Navigation"
- Oba: ⏳ Logo w Wygląd → Konfigurator → Tożsamość witryny

## Sesja 2026-05-11 — drobne UI poprawki

### Blog — sidebar "Czytaj też"
- `partials/blog/related-teaser.blade.php` — usunięty obrazek 16:9 z teasera (konkurował z głównym kontentem). Sidebar pokazuje teraz samo typo: label "CZYTAJ TEŻ" + tytuł serif + czas czytania.

### Service-why block — białe ikony
- `blocks/service-why.blade.php` — klasa ikon w czarnych kółkach: `size-6 invert` → `size-6 brightness-0 invert`. Niezawodnie wymusza biel niezależnie od oryginalnego koloru pliku uploadowanego przez ACF (PNG/SVG).

### Testimonials — przebudowa karty
**Slider → grid + text-only.** Karta opinii (`components/testimonial-card.blade.php`) zrefaktoryzowana z full-rewrite:
- Usunięta sekcja media (obrazek 240/320px + przycisk wideo)
- Usunięte fixed widths `w-[85vw] sm:w-[380px] lg:w-[600px]` — karta wypełnia komórkę gridu
- Duży serif cudzysłów `&ldquo;` na górze: `text-7xl lg:text-8xl text-primary`, `leading-[0.8]`, `-mb-6 lg:-mb-8` (kompensata typograficznego whitespace pod glyphem)
- Cytat: `text-base lg:text-lg leading-relaxed`, `pl-6 lg:pl-8` (hanging-quote indent)
- Autor: `— Imię` (czerń) + `service` (text-black/60), `pl-6 lg:pl-8`
- `h-full` + `flex-1` na cytacie → wyrównuje wysokości kart w rzędzie, autor zawsze na dole

**Layout:** w `blocks/testimonials/index.blade.php` i `sections/service/testimonials.blade.php` slider `flex + drag-scroll + snap-x` zamieniony na `grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12`. Wywalone propsy `mediaType/image/videoUrl` z wywołań `<x-testimonial-card>`.

**Composer nietknięty** — `TestimonialsBlockComposer` dalej zwraca `media_type/image/video_url`, ale karta ich nie używa. Dane ACF (zdjęcia, wideo opinii) zostają w bazie na wypadek powrotu do poprzedniego designu.

### Portfolio — mniejsze karty
- `components/portfolio-card.blade.php` — wymiary zredukowane (~20%): mobile `280×480` → `240×380`, desktop `h-600px` → `h-460px` (aspect-[3/4] zachowany).
- Typografia i padding przeskalowane proporcjonalnie: padding `p-8` → `p-6`, tytuł `text-[30/32]` → `text-xl lg:text-2xl`, kategoria `text-base` → `text-sm`, strzałka `size-10/icon-6` → `size-9/icon-5`, `gap-6` → `gap-4`.
- Dodane `min-w-0` na bloku tekstu — zapobiega rozpychaniu długimi tytułami w węższej karcie.

## Sesja 2026-05-20 / 2026-05-21 — service-what icons, deploy auto, service-desc repeatery, ACF JSON sync, sidebar opinia, unifikacja paddingów

### Service-what — większe ikony, bez rozjazdów
- `blocks/service-what.blade.php` — ikony "Co dostajesz" powiększone z 24×24 do 48×48 (`size-6` → `size-12`) + `object-contain`. Wcześniej różne aspect ratio uploadowanych SVG-ów się rozciągały w sztywnym kwadracie, teraz każda ikona dopasowuje się zachowując proporcje.

### Deploy — automatyzacja SSH
- `ssh-copy-id` z `~/.ssh/id_ed25519.pub` na `wiktor1249@wiktor1249.ssh.dhosting.pl` — od teraz krok 4 deploya (SSH pull + `npm run build`) jest wykonywany autonomicznie z poziomu agenta (key auth, BatchMode=yes). Wcześniej każdy deploy wymagał ręcznego SSH z hasłem.
- `CLAUDE.md` — dodana sekcja `## Deploy — checklist (develop → staging)` z 5-krokową procedurą i listami "kiedy ostrzegasz" / "czego nie robisz przy deployu". Wcześniej krok SSH+build siedział tylko w PROJECT_STATUS:586 i łatwo go pominąć.
- Reset hasła WP admin przez wp-cli na SSH (`user update admin --user_pass=...`) — admin user ma placeholder email `dev-email@wpengine.local`, reset emailowy by nie zadziałał. **Do zrobienia:** podmienić email na prawdziwy.

### Service-desc — 3 listy "Dla kogo" jako repeatery ACF + WYSIWYG dla "Raczej nie"
- ACF: 3 repeatery (`desc_positive_items` / `desc_highlight_items` / `desc_negative_items`), każdy z sub-fieldem `item_text`. Positive/highlight = Textarea (krótkie buletny). Negative = WYSIWYG (toolbar **Basic**, tabs **Visual Only**, media upload **off**) — żeby edytor mógł wstawiać linki do innych usług bez ryzyka rozwalenia layoutu obrazkami.
- `ServiceDescBlockComposer.php` — `itemsFromRepeater($field, $allowHtml = false)`:
  - Positive/highlight zwracają plain text (trim).
  - Negative przepuszczone przez `wp_kses_post`, ze stripowanym `<p>` (wpautop wrapper) i z doklejaną " →" wewnątrz każdego `<a>` (regex `<a[^>]*>...</a>` → `<a...>$content →</a>`). Strzałka jest częścią linku — klikalna, nie odrywa się przy zawijaniu.
  - Hardcoded fallbacki zachowane — usługi z pustym repeaterem dalej działają.
- `service-desc.blade.php` — render warunkowy: `{!! $item !!}` dla sekcji z `allow_html=true`, `{{ $item }}` dla pozostałych. Każda sekcja w `$sections` ma flagę `allow_html`. Stylowanie linku przez Tailwind arbitrary variant w wrapping `<span>`:
  ```
  [&_a]:font-semibold [&_a]:underline [&_a]:underline-offset-2
  [&_a]:whitespace-nowrap [&_a]:hover:text-black/70 [&_a]:transition-colors
  ```

### ACF JSON sync — setup jednorazowy
- Utworzony folder `public/app/themes/dominikpakula/acf-json/` — ACF Pro auto-zapisuje field groupy do tego folderu przy każdym save i auto-wczytuje przy braku w DB (`local=json`).
- Pierwsza zsynchronizowana grupa: `group_69cbafc509318.json` ("Opis Usługi/Dla kogo") — 11 pól (3 repeatery + 8 text/heading).
- Druga i trzecia grupa zsynchronizowane później w sesji: `group_69cbab9dbca4e.json` ("Usługa" — 3 pola: sidebar_title/description/price) i `group_69f246a2f3a88.json` ("Usługa Obejmuje" — 2 pola: heading + repeater items).
- Na stagingu ACF dynamicznie ładuje JSON bez ręcznego "Sync" w panelu — `acf_get_field_group()` zwraca grupę z `local=json`, łącznie **3 grupy resolved**.
- **Implikacja na przyszłość:** każda zmiana field group lokalnie → JSON się zapisuje automatycznie → commit → na stagingu od razu działa po `git pull` (zero eksportów/importów przez panel ACF). Stara metoda eksportu JSON ręcznie przez ACF Tools jest niepotrzebna.

### Naprawa typu pola `service_included_items` (text → repeater)
- Pole było utworzone 2026-04-29 jako Text (jednolinijka), mimo że composer `ServiceComposer::includedItems()` od początku oczekiwał repeatera z sub-fieldem `service_included_item`. PROJECT_STATUS:394 ten stan błędnie raportował jako "repeater".
- Naprawione przez panel ACF: zmiana typu pola na **Repeater (Powielacz)** + dodanie sub-field `service_included_item` (Textarea). Layout repeatera: `table`, button label: "Dodaj wiersz".
- Composer już dawno obsługiwał ten case z fallbackiem hardcoded (4 punkty stylistyczne) — teraz panel dostarcza prawidłową strukturę.
- Field group zsynchronizowana do `acf-json/group_69f246a2f3a88.json`.

### Sidebar opinia klienta — redesign (bez zdjęcia, podpis w stylu home)
- `sections/service/sidebar.blade.php` — sekcja "Opinia klienta":
  - **Usunięte** zdjęcie autora (`<img>` 36px round) i szare kółko-placeholder, bo wiele opinii nie ma zdjęcia → wyglądało dziwnie.
  - **Podpis przeorganizowany** z poziomego layoutu (avatar + autor + service obok) na pionowy stack: `— Imię` (czerń, font-light) + service (60% black) pod spodem. Spójnie z `components/testimonial-card.blade.php` (testimonials na home).
  - **Zachowane:** eyebrow "Opinia klienta" (font-metro, small caps), italic cytat z polskimi cudzysłowami „...", `line-clamp-5`, `bg-[#f1f1f1] rounded p-4`.
- **Uwaga z sesji:** próba pełnego portu stylu home (duży serif `&ldquo;`, usunięcie eyebrow) była przesadzona — user explicite poprosił o cofnięcie. Zapisane do memory `feedback-minimal-scope`: zmieniać tylko to o co user prosi, nie "ulepszać przy okazji" sąsiednich elementów.

### Ujednolicenie pionowego paddingu sekcji (`py-10 lg:py-14`)
- Cel: spójny rytm pionowy na całej stronie wzorowany na stronie Kontakt (która miała `py-10 lg:py-16`). Standardowy 8pt grid, mobile 40px → desktop 56px.
- **13 plików** sprowadzonych do `py-10 lg:py-14` (TYLKO `padding-y`, boczne `px-*` nietknięte):
  - **Service bloki (najpierw):** `blocks/service-desc.blade.php`, `blocks/service-what.blade.php`, `blocks/service-why.blade.php` — z `py-4` / `py-6` (16-24px) → `py-10 lg:py-14`. Plus badge → treść sekcji ujednolicone: niespójne `mb-3 / mb-5 / mb-6` → wszędzie `mb-6 lg:mb-8`.
  - **Content bloki (drugi batch):** `blocks/blog.blade.php`, `blog-archive.blade.php`, `contact.blade.php`, `features.blade.php`, `lookbook-section.blade.php`, `newsletter.blade.php`, `service-faq.blade.php`, `service-process.blade.php`.
  - **Bloki w podfolderach (trzeci batch, pierwszy audit pominął):** `blocks/offer/index.blade.php`, `process/index.blade.php`, `portfolio/index.blade.php` (zachowane `overflow-hidden`), `services/index.blade.php`, `testimonials/index.blade.php` (zachowane `overflow-hidden`).
- **Pominięte (świadomie):**
  - `hero`, `subpage-hero`, `page-header` — własna logika hero/header.
  - `blocks/contact-bar`, `contact-channels`, `subscribe`, `voucher`, `video` — bez outer `py-*` (mają wewnętrzne paddingi w kartach).
  - `blocks/blog-callout`, `blog-personal-quote`, `blog-pullquote` — inline w treści posta, nie sekcje (pullquote ma `py-8 lg:py-10` na karcie cytatu, świadome).
  - `blocks/knowledge-base` — `py-8 lg:pt-0 lg:pb-12` (świadome — sąsiaduje z czymś co już ma padding).
  - `blocks/personal-intro` — `py-10 lg:py-16` (świadomie większe niż standard, intro hero kontaktu).
  - `blocks/next-steps` — `py-10 lg:py-14` (już zgodne).
- **Weryfikacja przez curl:** wszystkie 8 sekcji na home używają teraz `py-10 lg:py-14`, brak mieszanki ze starymi wartościami.

### Pliki zmienione / dodane
- `public/app/themes/dominikpakula/resources/views/blocks/service-what.blade.php` (rozmiar ikon → 48px)
- `public/app/themes/dominikpakula/resources/views/blocks/service-desc.blade.php` (warunkowy `{!! !!}`, link styling)
- `public/app/themes/dominikpakula/resources/views/blocks/service-why.blade.php` (padding)
- `public/app/themes/dominikpakula/app/View/Composers/ServiceDescBlockComposer.php` (repeatery + WYSIWYG handling)
- `public/app/themes/dominikpakula/resources/views/sections/service/sidebar.blade.php` (opinia: bez zdjęcia, byline w stylu home)
- `public/app/themes/dominikpakula/resources/views/blocks/` × **13 plików** outer `py-*` → `py-10 lg:py-14`
- `public/app/themes/dominikpakula/acf-json/group_69cbafc509318.json` (Opis Usługi/Dla kogo, auto-generated)
- `public/app/themes/dominikpakula/acf-json/group_69cbab9dbca4e.json` (Usługa, auto-generated)
- `public/app/themes/dominikpakula/acf-json/group_69f246a2f3a88.json` (Usługa Obejmuje, auto-generated, repeater naprawiony)
- `CLAUDE.md` (sekcja Deploy)

### Commits
- `af63c17` Service-what: enlarge icons to 48px + object-contain
- `1f8a85b` CLAUDE.md: dodaj sekcję Deploy z checklistą develop→staging
- `4f6b091` Service-desc: 3 listy "Dla kogo" jako repeatery ACF + WYSIWYG dla "Raczej nie"
- `8493e5d` PROJECT_STATUS: sesja 2026-05-20/21 + zaznacz service-desc repeatery jako done
- `cac842c` Sidebar opinia: usuń zdjęcie, podpis w stylu home + ACF JSON sync: dwie nowe grupy
- `b05070d` Service blocks: większe odstępy sekcji + spójny badge gap (8pt grid)
- `f020441` Ujednolicenie pionowego paddingu sekcji: wszystkie content bloki → py-10 lg:py-14

### Otwarte do zrobienia (data per usługa)
- Wypełnić listy `desc_*_items` per usługa **na stagingu** (dane nie kopiują się z lokala — siedzą w postmeta, nie w field group). Bez wypełnienia staging dalej pokazuje hardcoded fallback.
- Wypełnić listy `desc_*_items` per usługa **na lokalu** — analogicznie.
- Wypełnić listy `service_included_items` per usługa **na lokalu i na stagingu** — analogicznie (postmeta, nie kopiuje się przez JSON).
- Podmienić email admina (na stagingu) z `dev-email@wpengine.local` na prawdziwy, żeby reset hasła emailem działał w przyszłości.
- Rotacja hasła SSH dhosting (było w plain text w czacie tej sesji) — SSH działa już bez hasła (klucze id_ed25519 wgrane), więc rotacja nic nie zepsuje, tylko zabezpieczy konto.

## Sesja 2026-05-21 (cd.) — service-what halo+check, badge spacing, sidebar readability, service-why icon fix, 2 nowe bloki (trust, video)

### Service-what — ikony zastąpione krążkiem halo z białym ptaszkiem
- `blocks/service-what.blade.php` — wgrywane ikony 48×48 zamienione na "halo" style: outer `size-12 rounded-full bg-primary/10` (lekkie lawendowe halo) + inner `size-9 rounded-full bg-primary` (solidny krążek) + `<x-icons.check class="size-5 text-white">`. Semantycznie pasuje lepiej do "co dostaniesz" niż wgrywane ikony różnej jakości; ACF pole `service_what_item_icon` zostawione w schemacie (nie renderowane).
- `aria-hidden="true"` na halo — czytniki nie odczytają symbolu jako informacji, tytuł elementu pozostaje pierwszą sensowną treścią.

### Badge spacing — ujednolicony rytm pionowy we wszystkich 5 sekcjach service-*
- Sekcje `dla kogo` i `dlaczego warto` miały już `mb-6 lg:mb-8` (24/32px) jako wzorzec. Trzy pozostałe odstawały:
  - `service-process` i `service-faq`: badge wrapper `mb-4` (16px) → `mb-6 lg:mb-8`.
  - `service-what`: badge dzielił flex container z `<h3>` przez `gap-2` (8px, najgorzej). Wyrwany z flexa, dostaje własny wrapper `mb-6 lg:mb-8`, h3 też z `mb-6 lg:mb-8` do items.
- Po zmianie wszystkie 5 sekcji ma identyczny odstęp pod badge.

### Sidebar single-service — czytelność short opisu nad ceną
- `sections/service/sidebar.blade.php`, paragraf z `$sidebarDescription` (cienki opis usługi nad price boxem):
  - `font-metro` → `font-poppins`: Metrophobic to font dekoracyjny (monoline), przy `text-xs` na wielowierszowym body jest praktycznie nieczytelny. Poppins to standard body w reszcie projektu.
  - `leading-none` → `leading-relaxed`: line-height 1 powodowało zlewanie się wierszy.
- Zapisane do memory `feedback-fonts`: Metrophobic tylko do single-line labelów/eyebrows, nigdy do multi-line body.

### Service-why — `object-contain` na ikonie benefitu
- `blocks/service-why.blade.php`, ikona w `<img class="size-6 brightness-0 invert">` — brak `object-contain` powodował rozciąganie ikon o niekwadratowych proporcjach do kwadratu 24×24. Reszta projektu (service-what, service-process) konsekwentnie używa object-contain.
- Filtr `brightness-0 invert` zostaje — design intent to biała ikona na czarnym kółku, wymaga monochromatycznego czarnego SVG (user świadomie zostawił to ograniczenie zamiast przepisywać na Heroicons select).

### Nowy blok `service-trust` — 2 karty side-by-side (zaufanie + doświadczenie)
- Implementacja Figma node `897:831` ("Zadowolenie") jako blok do wgrania w opisie usługi.
- Layout: `grid grid-cols-1 lg:grid-cols-[240px_1fr]` BEZ gapa (Figma `content-stretch flex items-start`), karty stykają się flush. Mobile stack, rounded corners responsywnie (`rounded-t-sm lg:rounded-t-none lg:rounded-l-sm` po lewej / analog po prawej).
- **Lewa karta** (240px): `bg-[#f2f2f2]` + obraz uploadu (`object-cover absolute inset-0`) + tekst w lewym dolnym rogu (Poppins text-xs, czarny).
- **Prawa karta** (1fr): obraz uploadu pełny bleed + ciemny overlay `bg-black/20` + tekst biały w lewym dolnym rogu (Poppins text-sm).
- Plus icon był w pierwotnej propozycji jako osobny element — usunięty (user: ma być częścią grafiki tła, nie osobnym elementem). `components/icons/plus.blade.php` utworzony i od razu skasowany jako nieużywany.
- Pola ACF (utworzone w panelu, zsynchronizowane do `acf-json/group_6a0f41ba5be68.json`): `trust_left_image`, `trust_left_text`, `trust_right_image`, `trust_right_text` (text fields, nie textarea — user wybrał krótkie pojedyncze linie).
- Composer `ServiceTrustBlockComposer.php` z helperem `normalizeImage()` zwracającym `{url, alt, width, height}`. `nl2br(e($text))` w blade na wypadek wielowierszowych textów.

### Nowy blok `service-video` — compact wariant `<x-video-section>` dla opisu usługi
- User chciał "taki sam blok jak na home tylko żeby się zmieścił w opisie" — kolumna w `single-service` ma `~868px` (grid `7fr_3fr` z `gap-x-10` w `max-w-[1440px]`), homepage video używa `1280px`.
- **`components/video-section.blade.php`** rozszerzony o prop `variant` z wartościami:
  - `hero` (default) — homepage style, bez zmian dla istniejącego bloku `video`.
  - `contained` — compact: heading 26/34px (vs 30/50), description text-sm (vs base), play button size-10 (vs 12), height 480/420 (vs 680/600), własny `rounded-sm overflow-hidden` bez `max-w-[1440px] mx-auto` wrappera (już jest w kolumnie).
- **Layout dla contained przestrukturyzowany**: heading u góry, w dolnym rzędzie `flex items-center justify-between` z play button po lewej i CTA button po prawej (zamiast hero-style "heading + description + button w jednym rzędzie, play poniżej"). Button nie ma `w-full` na mobile (żeby nie wypychał play do nowej linii).
- **Description renderowany warunkowo** (`@if ($description)`) — bezpieczne dla pustych opisów (`description=""` w service-video).
- **`blocks/service-video.blade.php`** — hardcoded, **bez ACF na razie** (świadoma decyzja user, "potem się poprawi"):
  - Image: `Vite::asset('resources/images/video-bg.jpg')` — fallback z theme bundlowany przez Vite, działa identycznie lokalnie i na stagingu.
  - YouTube ID: `ZieW_OSkuiQ` — wyciągnięte z homepage ACF na stagingu przez wp-cli (`wp post get 6 --field=post_content`), żeby było spójne.
  - Heading/description/button text — defaults z `<x-video-section>` (matchują homepage).
  - Button URL: `home_url('/o-mnie/')` (placeholder, user "potem się poprawi").

### Deploy — w pełni autonomiczny end-to-end
- Wszystkie commits powyżej zostały sprowadzone na staging tym samym pipelinem: commit develop → push → checkout staging → merge --no-ff → push → SSH pull + `npm run build` na serwerze.
- Pierwsza próba (`puscmy` przy service-what halo+check) zakończyła się tym, że pominąłem krok SSH+build na serwerze i user zobaczył nic na stagingu. Zapisane do memory `feedback-deploy-ssh`: przy "puśćmy na staging" zawsze lecę pełnym pipelinem bez pytania o SSH (klucz skonfigurowany, BatchMode=yes przechodzi).

### Booking flow pivot — "Zarezerwuj rozmowę" + ukrycie ceny w modalu (commit `6e8597d`)
- **Tag `booking-v1-direct-reservation` na commit `a7baa03`** — snapshot przed pivotem. Stara wersja = bezpośrednia rezerwacja konkretnej usługi (`data-service` z kontekstu strony). Powrót: `git checkout booking-v1-direct-reservation`.
- **12 stringów copy zmienionych w 4 plikach** — "rezerwacja/wizyta" → "rozmowa". Pivot interpretacyjny: usługa nie jest bezpośrednio kupowana, a omawiana podczas rozmowy konsultacyjnej.
  - `partials/booking-modal.blade.php` (8 zmian): tytuł, aria-label modala, subtytuł kroku 1 ("Wybierz usługę, którą chcesz omówić"), subtytuł kroku 3 ("Potrzebujemy ich żeby potwierdzić termin rozmowy"), submit button ("Zarezerwuj rozmowę"), krok 4 heading ("Rozmowa zaplanowana!"), krok 4 message ("Do usłyszenia!"), floating CTA + aria-label
  - `single-service.blade.php`: sticky bar CTA → "Zarezerwuj rozmowę"
  - `sections/service/sidebar.blade.php`: primary CTA → "Zarezerwuj rozmowę" (telefoniczny CTA "Zarezerwuj Termin Telefonicznie" zostaje — inny kanał)
  - `partials/blog/booking-cta.blade.php`: "Zarezerwuj konsultację" → "Zarezerwuj rozmowę"
- **Ukrycie ceny w karcie usługi w kroku 1 modala** — `resources/js/components/booking.js`: usunięta linia `${s.price ? <span>${s.price}</span> : ''}` z template literal renderującego karty selektora. Pozostałe miejsca z ceną (sticky bar, sidebar box, service-cards na home/listingach) **zachowują cenę** — pivot dotyczy tylko booking flow, nie listingu.
- Komentarz revertu w `booking.js` (poza template literal — JS comment, nie HTML) z opisem co dopisać żeby przywrócić.

### Pliki zmienione / dodane
- `resources/views/blocks/service-what.blade.php` — halo+check, badge wyrwany z flex
- `resources/views/blocks/service-process.blade.php` — badge spacing
- `resources/views/blocks/service-faq.blade.php` — badge spacing
- `resources/views/blocks/service-why.blade.php` — `object-contain` na ikonie
- `resources/views/sections/service/sidebar.blade.php` — font + leading w sidebarDescription
- `resources/views/blocks/service-trust.blade.php` (nowy)
- `resources/views/blocks/service-video.blade.php` (nowy)
- `resources/views/components/video-section.blade.php` — prop `variant`, conditional rendering hero/contained
- `app/View/Composers/ServiceTrustBlockComposer.php` (nowy)
- `app/blocks.php` — rejestracja `service-trust` i `service-video`
- `acf-json/group_6a0f41ba5be68.json` (nowy, auto-sync z panelu ACF)

### Commits
- `eb872bb` Service blocks: halo+check w "Co dostaniesz" + ujednolicony odstep pod badge
- `2545f90` Sidebar usługi: czytelność short opisu nad ceną
- `b1ebda3` service-why: object-contain na ikonie benefitu
- `1d27bce` Nowy blok service-trust: 2 karty (zaufanie + doswiadczenie)
- `fa50612` Nowy blok service-video: compact wariant video-section dla opisu uslugi

### Otwarte do zrobienia
- **Dodać blok "Opis Usługi / Zaufanie i Doświadczenie" na stronach usług** na stagingu i lokalnie — content (block + 2 zdjęcia + 2 teksty) siedzi w postmeta, nie kopiuje się przez git.
- **Dodać blok "Opis Usługi / Video CTA" na stronach usług** na stagingu i lokalnie — analogicznie postmeta.
- **`service-video` przepisać na ACF** kiedy user będzie chciał edytowalne pola (image / youtube_id / heading / button URL). Na razie hardcoded.
- **Button URL `/o-mnie/`** w service-video — sprawdzić czy taka strona istnieje, jeśli nie to stworzyć albo zmienić URL.
- **Pole `service_what_item_icon` w ACF** — można usunąć (już nie renderujemy ikony, wystarczy halo+check). Zostawione na razie żeby nie tracić ewentualnych już wgranych ikon.

## Zasady pracy
- ACF pola tworzone ręcznie w panelu WP, ale **auto-syncowane do `acf-json/`** — od teraz każda zmiana jest wersjonowana w git automatycznie (nie kodem PHP, nie ręcznym eksportem)
- Ikony z Heroicons + Lucide (hanger), w `views/components/icons/`
- JS dzielony na osobne pliki w `resources/js/components/`, app.js tylko importuje
- W Composerach `\get_field()` z backslashem (namespace)
- Wszystkie sekcje jako ACF Blocks (nie @include w template)
- Badge jako komponent `<x-badge>` (nie inline)
- Stałe gray surfaces: `#f1f1f1` (NIE `#f9f9f9`)
- Tailwind v4: konfiguracja w `app.css` przez `@theme`, NIE `tailwind.config.js`

## Uwagi
- Bedrock webroot: `public/` (nie domyślne `web/`)
- Local by Flywheel: katalog projektu `~/Local Sites/dominikpakula/app/`, MySQL przez socket `~/Library/Application Support/Local/run/7UbGGQsjo/mysql/mysqld.sock` (lub port 10084)
- Staging: `dominikpakula.wdb-creative.pl` na dhosting (CageFS, PHP CLI 5.4 default — używaj `/usr/bin/php84` dla wp-cli i composera)
- SSH staging: `wiktor1249@wiktor1249.ssh.dhosting.pl`, ścieżka `/home/klient.dhosting.pl/wiktor1249/dominikpakula.wdb-creative.pl/app`
- wp-cli na stagingu: pobierz `/tmp/wp-cli.phar` od scratch (stary `~/wp-cli.phar` jest uszkodzony), uruchamiaj przez `/usr/bin/php84 /tmp/wp-cli.phar --path=public/wp ...`
- Deploy: `git push develop` → merge `develop` → `staging` (--no-ff) → `git push staging` → SSH pull + `npm run build` w katalogu motywu (Node 20+ z NVM: `export NVM_DIR=$HOME/.nvm && . $NVM_DIR/nvm.sh`)
- DB sync między środowiskami: NIE pełny dump (overwrite content); tylko targetowane operacje przez wp-cli (terms, posty, meta) lub ACF eksport JSON dla field groups

## Sezon 3 (2026-04-23 / 2026-04-28) — strona Kontakt + service-desc rebuild + sidebar enrichment

### Strona Kontakt — pełen build
Slug `/kontakt/` (page ID 270 lokalnie), szablon `template-blocks.blade.php`. Bloki w content (kolejność):
1. `acf/page-header` — breadcrumb + "Kontakt" + opis
2. `acf/contact-bar` (NOWY) — 3-kolumnowy pasek pod headerem: adres + NIP + telefon + email
3. `acf/personal-intro` (NOWY) — duży avatar + slogan od Dominika + badge "Odpowiadam w 24h" (pulsujący dot)
4. `acf/contact-channels` (NOWY) — 4 kafelki instant-CTA (Zadzwoń / WhatsApp / Instagram DM / Email) z hover lift+shadow
5. `acf/next-steps` (NOWY) — 3 numerowane kroki "Co dalej" (Piszesz → Odpowiadam → Spotykamy się)
6. `acf/contact` (istniejący) — formularz kontaktowy (Imię + Email + Wiadomość + GDPR)
7. `acf/testimonials` (rozszerzony) — 3 najnowsze opinie auto-pulled (composer fallback gdy `testimonials_items` puste)
8. `acf/subscribe` (istniejący) — Newsletter + Instagram

### Nowe bloki ACF (sezon 3)
| Slug | Composer | Widok |
|------|----------|-------|
| `acf/contact-bar` | — (używa `$contact` global) | `blocks/contact-bar.blade.php` |
| `acf/personal-intro` | `PersonalIntroBlockComposer` | `blocks/personal-intro.blade.php` |
| `acf/contact-channels` | `ContactChannelsBlockComposer` | `blocks/contact-channels.blade.php` |
| `acf/next-steps` | `NextStepsBlockComposer` | `blocks/next-steps.blade.php` |

### service-desc — przebudowa wizualna (editorial layout)
Z dotychczasowego "badge + WYSIWYG content + gift-banner" na 3-sekcyjny editorial layout (sezon 3):
- `bg-[#f1f1f1]` panel (badge + gift-banner zostają poza panelem na białym)
- Heading h2 "Czy ta usługa jest dla Ciebie?" (24px / 30px)
- 3 sekcje stackowane z separatorami: każda ma `lg:grid-cols-[140px_1fr]`
- Lewa kolumna: duży dekoracyjny numer (48px / 64px, `text-black/15`) + Metrophobic eyebrow + linia
- Prawa kolumna: tytuł sekcji + lista z em-dash markerami (`—` w `text-black/40`)
- Eyebrows: "Tak" (01) / "Polecam" (02) / "Raczej nie" (03)
- Composer ma 3 hardcoded listy fallback (positiveItems / highlightItems / negativeItems) — patrz "Hardcode do przepisania" niżej
- Brak kart, brak Tailwind colored variants (zielony/żółty/czerwony) — pełen monochrom zgodny z brand

### Sidebar single-service — wzbogacenie (sezon 3)
Nowa kolejność (top-down):
1. Trustpilot rating (hardcode)
2. Tytuł + opis (ACF: service_sidebar_title / service_sidebar_description)
3. CTA banners (hardcode)
4. Price box (ACF: service_price)
5. **W cenie znajdziesz** (NOWE) — checklista 4-6 punktów z `text-primary` checkmarkami, `bg-[#f1f1f1] rounded p-4`
6. Linki "Kup dla kogoś / Regulamin" (hardcode, przeniesione tu z dolnej pozycji)
7. **Opinia klienta** (NOWE) — auto-pulled najnowsza opinia z CPT testimonial: cytat italic 5 linii + foto 36px + imię + usługa
8. **Sprawdź też inne usługi** (NOWE) — auto-pulled 3 inne usługi z CPT (exclude bieżąca, po menu_order). Hardcoded fallback dla MVP (Przegląd szafy / Zakupy / Stylizacja na okazję) gdy CPT zwraca pustą listę
9. Tagi powiązane (ACF: service_tags)

### Single-service template — drobne poprawki
- `<article>` padding: `lg:py-12` → `lg:pt-4 lg:pb-12` (mniej oddechu nad zdjęciem)
- Grid gap: `lg:gap-10` → `lg:gap-x-10 lg:gap-y-4` (40px między kolumnami zostaje, 16px wertykalnie)
- `sections/service/header.blade.php` — social proof "511 zadowolonych klientów" przeniesione spod tytułu **pod zdjęcie**, wycentrowane (`justify-center`)

### Nowe pliki (sezon 3)
- `app/View/Composers/PersonalIntroBlockComposer.php`
- `app/View/Composers/ContactChannelsBlockComposer.php`
- `app/View/Composers/NextStepsBlockComposer.php`
- `resources/views/blocks/contact-bar.blade.php`
- `resources/views/blocks/personal-intro.blade.php`
- `resources/views/blocks/contact-channels.blade.php`
- `resources/views/blocks/next-steps.blade.php`

### Zmienione (sezon 3)
- `app/blocks.php` — rejestracja 4 nowych bloków (contact-bar, personal-intro, contact-channels, next-steps)
- `app/View/Composers/SiteSettings.php` — dorzucony `social.whatsapp` (auto-derive z `phone_link` jeśli brak osobnego URL)
- `app/View/Composers/ServiceComposer.php` — dorzucone `$includedHeading`, `$includedItems`, `$sidebarTestimonial`, `$relatedServices`
- `app/View/Composers/ServiceDescBlockComposer.php` — refactor na 3-sekcyjny model (`$sections` zamiast `$content`)
- `app/View/Composers/TestimonialsBlockComposer.php` — fallback "3 najnowsze opinie z CPT" gdy `testimonials_items` puste
- `resources/views/sections/service/header.blade.php` — social proof pod zdjęciem
- `resources/views/sections/service/sidebar.blade.php` — 3 nowe sekcje (W cenie / Opinia / Related), reorder linków
- `resources/views/blocks/service-desc.blade.php` — pełna przebudowa na editorial layout
- `resources/views/single-service.blade.php` — paddingi i gap

## Hardcode w blokach (do przepisania na dynamiczne ACF)

> Wszystko poniżej zostało wpisane "na sztywno" w PHP/Blade jako MVP, żeby nie blokować developmentu na klikaniu w panelu ACF. **Każda pozycja powinna ostatecznie trafić do ACF** żeby klient mógł edytować bez tykania kodu.

### Composery — fallbacki tekstów/list

**`PersonalIntroBlockComposer.php`**
- `intro_heading` → "Cześć, jestem Dominik"
- `intro_text` → "Pisz do mnie bez krępacji — żadnych głupich pytań nie ma. Każdą wiadomość czytam osobiście i zwykle odpowiadam w ciągu 24 godzin."
- `intro_badge` → "Odpowiadam w 24h"
- `intro_image` → null (placeholder "DP" w kółku)

**`ContactChannelsBlockComposer.php`**
- `channels_heading` → "Wybierz wygodny kanał"
- `channels_subtitle` → "Każda wiadomość trafia bezpośrednio do mnie. Wybierz to, co dla Ciebie najwygodniejsze."

**`NextStepsBlockComposer.php`** — całe 3 kroki hardcoded (`steps_heading`/`steps_subtitle` mają opcjonalne ACF override):
- 01 "Piszesz" → "Wypełnij formularz albo napisz na wybranym kanale…"
- 02 "Odpowiadam w 24h" → "Odpiszę osobiście, doprecyzujemy Twoje potrzeby…"
- 03 "Spotykamy się" → "Krótka rozmowa video albo spotkanie na żywo…"
→ Do przepisania jako repeater `steps_items` z polami `step_number` / `step_title` / `step_text`.

**`ServiceDescBlockComposer.php`** — całe listy 3 sekcji hardcoded:
- `positiveItems` (5 punktów "Dla Ciebie jeśli jesteś facetem i…")
- `highlightItems` (3 punkty "Sprawdza się szczególnie…")
- `negativeItems` (1 punkt "To nie ta usługa jeśli…")
→ Do przepisania jako 3 osobne ACF repeatery (różne per CPT service) lub jeden flexible content.

**`ServiceComposer.php`**
- `includedItems` fallback: "Konsultacja 1-1 (60 min)", "Plan stylizacji…", "Konkretne propozycje zakupowe", "Wsparcie e-mailowe przez 14 dni"
- `relatedServices` MVP fallback: 3 hardcoded usługi (Przegląd szafy / Zakupy / Stylizacja na okazję) gdy CPT zwraca pustą listę
- `sidebarTestimonial` — auto-pulled z CPT (nie hardcoded ale brak konfiguracji "która opinia") → opcjonalnie dorzucić ACF `service_featured_testimonial` (Relationship → testimonial) per usługa

**`SiteSettings.php`**
- `social.instagram` fallback → `https://www.instagram.com/dpakula_stylist/`
- `social.instagram_handle` fallback → `dpakula_stylist`
- `social.whatsapp` derive z `contact_phone_link` (działa OK ale można nadpisać przez `social_whatsapp_url`)

### Blade widoki — hardcoded teksty/elementy

**`sections/service/sidebar.blade.php`**
- Trustpilot rating "Excellent 4.8 out of 5 Trustpilot" — całość hardcoded
- CTA banner 1 "Umów się na konsultacje - Jak to działa?" — link `href="#"` placeholder
- CTA banner 2 "Zarezerwuj Termin Telefonicznie" — etykieta hardcoded
- Price box top bar: "30-dniowa gwarancja zwrotu pieniędzy" + ikona (hardcoded inline SVG) + "Umów się na konsultacje" — wszystko hardcoded
- Price box VAT info: "Cena zawiera 23% VAT, nie obejmuje kosztów przejazdów" + inline SVG info icon
- "Zarezerwuj Termin" button label
- Linki: "Kup dla kogoś" (URL `home_url('/voucher/')`) + "Sprawdź Regulamin Oferty" (URL `#` placeholder!) — ikony inline SVG
- "Powiązane Tematy Bloga:" label
- "Sprawdź też inne usługi" heading
- Sekcja "Opinia klienta" — eyebrow "Opinia klienta"

**`sections/service/header.blade.php`**
- "511 Zadowolonych klientów, którzy skorzystali z Tej Oferty" — całość hardcoded (cyfra + tekst)
- Inline SVG ikona ludzików

**`sections/service/breadcrumbs.blade.php`** — sprawdzić zawartość, ale prawdopodobnie też hardcode

**`sections/footer.blade.php`** (już opisane w Sezonie 2)
- Slogan "Pomagam facetom wyglądać tak, jak chcieliby wyglądać"
- "Osobisty stylista" subline pod logo
- Address fallback "ul. Marszałkowska 1 / 00-001 Warszawa" (italicized placeholder)
- NIP "000-000-00-00" + REGON "000000000" (italicized placeholders)
- Phone fallback "+48 884 826 068" / `+48884826068`
- Email fallback "kontakt@dominikpakula.pl"
- Copyright "© Dominik Pakuła. Wszelkie prawa zastrzeżone."
- Linki: Polityka prywatności + Regulamin (URL'e do nieistniejących stron)

**`partials/blog/subscribe.blade.php`** (używany też w `acf/subscribe`)
- Tytuł "Nie przegap kolejnego wpisu"
- Tekst "Raz w miesiącu wysyłam maila…"
- Disclaimer "Zapisując się, akceptujesz politykę prywatności…"
- Tytuł karty Instagram: "Codzienne inspiracje stylowe"
- Tekst karty Instagram: "Pokazuję stylizacje na różne okazje…"
- URL Instagram: `https://www.instagram.com/dpakula_stylist/` + handle `@dpakula_stylist`
- CTA "Śledź @dpakula_stylist"

**`blocks/newsletter.blade.php`**
- Tytuł "Bądź na Bieżąco"
- Opis "Zapisz się do naszego newslettera…"
- Label inputu "E-mail"
- Placeholder "Twój e-mail"
- CTA "Zapisz mnie do Newslettera"
- Disclaimer "Zapisując się, akceptujesz nasze warunki…"
- Inline SVG koperty (zamiast `<x-icons.envelope>`)

**`blocks/knowledge-base.blade.php`**
- Heading "Poradniki"
- "Zobacz Więcej >" linki (label)
- "Czytaj Więcej >" w kartach poradników

**`blocks/hero.blade.php`**
- Inline SVG strzałki (`size-6` w przycisku CTA) — można wymienić na `<x-icons.arrow-right>`

**`blocks/contact.blade.php`**
- "Kontakt" eyebrow
- H2 "Masz do mnie jakieś pytania?"
- Subtitle "Napisz, zadzwoń albo wypełnij formularz — odezwę się w ciągu 24 godzin"
- Etykieta "E-mail:" / "Telefon" / "Adres:"
- Etykieta "Imie" placeholder "Twoje Imie" (literówka — Imię nie Imie!)
- Placeholder "Twój adres e-mail"
- Etykieta "Wiadomość" placeholder "Wprowadź tekst swojej wiadomości.."
- GDPR text "Wyrażam zgodę na przetwarzanie moich danych osobowych zgodnie z polityką prywatności"
- Disclaimer "Odpowiadam w ciągu 24 godzin. Zero spamu, tylko konkret."
- CTA "Wyślij"
- Wszystkie inline SVG (envelope, telefon, location)

### Bloki/sekcje DUŻO HARDCODE-OWANE (priorytet refactoringu wysoki)
1. **`sections/service/sidebar.blade.php`** — najbardziej "zaśmiecony" hardcodem (Trustpilot, CTAs, gwarancja, VAT, linki, ikony) — całe 90% sztywne
2. **`sections/footer.blade.php`** — slogan, adres, NIP/REGON, copyright — wszystko hardcoded (z fallbackami w Composerze które nie istnieją w panelu)
3. **`partials/blog/subscribe.blade.php`** — newsletter+Instagram, dwie pełne karty hardcode (komunikat, CTA, IG URL/handle)
4. **`blocks/newsletter.blade.php`** — pełen tekst + CTA + disclaimer
5. **`ServiceDescBlockComposer`** + view — 3 listy + eyebrows hardcoded

### Refaktor priorytetowy (gdy klient wpisze pola ACF):
1. **Options Page "Ustawienia strony"** — najpilniejsze, blokuje większość fallbacków (kontakt, social, polityka prywatności URL)
2. **`service-desc` repeatery** — żeby każda usługa miała inne kryteria "dla kogo"
3. **`service_included_items` repeater** — żeby każda usługa miała własną checklistę "W cenie znajdziesz"
4. **`personal-intro` ACF** — żeby Dominik mógł wgrać własne zdjęcie i edytować tekst
5. **Sidebar Trustpilot** → Options Page field `trust_rating` lub usunąć jeśli nie planujemy mieć Trustpilota
6. **Footer linki prawne** — utworzenie stron "Polityka prywatności" + "Regulamin", potem URL'e w sidebar/footer się rozwiążą same

## Sesja 2026-07-02 — strona zbiorcza Poradniki

Odpowiednik strony zbiorczej bloga, ale dla CPT `guide` (Poradniki). Guide nie ma taksonomii → brak paska filtrów (prostszy niż blog-archive).

### Nowe pliki
- `app/Taxonomies/GuideCategory.php` — taksonomia `guide_category` („Kategorie poradników"), hierarchiczna, przypięta do `guide`, rewrite `/temat-poradnika/`. Wzorzec 1:1 z `Season.php`.
- `app/View/Composers/GuidesArchiveBlockComposer.php` — `WP_Query` post_type `guide`, 9/stronę, filtr po `guide_category` (`?category=slug`), paginacja (kod 1:1 z BlogArchiveBlockComposer). Zwraca `guides` + `categories` + `currentCategory` + `paginationHtml` + `totalFound`. Excerpt fallback z `post_content` jak w KnowledgeBaseBlockComposer.
- `resources/views/blocks/guides-archive.blade.php` — pasek chipsów kategorii (warunkowy, bez dropdownu sezonu) + grid `<x-blog-card>` + paginacja. **Trzy stany:** grid / „brak poradników w tej kategorii" (gdy filtr nic nie zwrócił) / **pusty stan** (zero poradników w ogóle) — karta `bg-[#f1f1f1]` z ikoną document, nagłówek „Poradniki są już w drodze", tekst + przycisk CTA „Zapisz się do newslettera" (`href="#newsletter-form"` → blok `subscribe`, bez duplikowania `id`).

### Zmienione
- `app/blocks.php` — rejestracja bloku `guides-archive` (ikona `book-alt`), wstawiony przed `subscribe`.
- `functions.php` — dopisany `Taxonomies/GuideCategory` do listy ładowanych plików.

### Auto-flush rewrite rules
- `Taxonomies/GuideCategory.php` — jednorazowy `flush_rewrite_rules()` wersjonowany opcją `dp_rewrite_version` (`2026070201`), priorytet init 20 (po rejestracji CPT+taksonomii). Rozwiązuje 404 na pojedynczych poradnikach / URL-ach taksonomii bez ręcznego zapisu permalinków. **Przy kolejnych zmianach rewrite bumpnij stałą wersji**, żeby wymusić ponowny flush.

### Single Guide — szablon pojedynczego poradnika (zakres „średni")
WordPress łapie `single-{post_type}` → `single-guide.blade.php` działa automatycznie (jak single-service/portfolio). Reużywa `.post-content` + id `#blog-toc-*-wrapper` + `[data-share-copy]`, więc **`blog-toc.js` i `blog-share.js` działają bez zmian w JS** (odpalają się globalnie, gated selektorem).

Nowe pliki:
- `app/View/Composers/SingleGuideComposer.php` — bind `single-guide` + `partials.guide.*`. Zwraca title/lead/content/date/readingTime/heroImageTag + `guidesUrl` (WP page o slugu `poradniki`, fallback `/poradniki/`) + `categories` (guide_category z linkiem do przefiltrowanej strony zbiorczej `?category=slug`) + `relatedGuides` (3) + `shareLinks` + `authorName`.
- `resources/views/single-guide.blade.php` — breadcrumbs → hero → body → pasek chipsów kategorii → related → subscribe (reużyty `partials.blog.subscribe`) → powrót do poradników.
- `resources/views/partials/guide/{breadcrumbs,hero,body,sidebar,toc,share,related}.blade.php` — mirrory blogowych, te same klasy/id dla współdzielonego JS.

Zmienione:
- `app/Blog/Filters.php` — `add_heading_ids` dopuszcza `is_singular(['post', 'guide'])` (wstrzykiwanie id nagłówków dla TOC działa też na poradnikach).
- `app/Blog/Helpers.php` — nowy helper `related_guides($postId, $limit)` (guide/guide_category, fallback newest — wzorzec `related_posts`).

### Strony tekstowe (polityka prywatności / regulamin) — ostylowany szablon `page`
Domyślny `page.blade.php` renderował goły `<h1>` + surowe `the_content()` bez kontenera/typografii → wklejony tekst prawny się rozjeżdżał. Przebudowany:
- `resources/views/page.blade.php` — BEZ własnego nagłówka (user dodaje nagłówek blokiem `page-header` w treści). `the_content()` w wrapperze z `prose`, ale zawężanie do czytelnej szerokości (`max-w-[820px]`) dotyczy **tylko luźnego tekstu** — selektor `[&>*:not(section)]`. Bloki (renderowane jako `<section>`) zostają na pełnej szerokości i nietknięte.
- `blocks/page-header.blade.php` — dodane `not-prose` na `<section>`, żeby typografia `prose` nie ingerowała w blok gdy jest w treści strony (na innych stronach bez efektu).
- Surowe `<?php the_post(); the_content(); ?>` zamiast `@php(...)` inline (zgodnie z zasadą dla PHP 8.5).
- Działa automatycznie dla każdej strony na domyślnym szablonie. Strony z blokami (template-blocks/front-page) nietknięte.
- **Uwaga:** rozwiązanie zakłada, że nagłówek usera to blok renderowany jako `<section>` (themowy `page-header`). Blok innego typu (core Cover/Group) trzeba by dodać do wyjątku selektora.

### Podstrona Konsultacje (2026-07-02)
Dedykowana strona „Jak działa konsultacja" — do niej prowadzi link „Jak to działa?" z sidebara usługi. Reużywa schodkowy design 4 kroków ze strony głównej (`blocks.process.step-card`) i modal rezerwacji.
- `app/View/Composers/ConsultationProcessBlockComposer.php` — ACF z fallbackami: label/title/lead + repeater `consultation_steps` (4 hardcoded fallback kroki: Wybierasz termin → Potwierdzamy SMS/mail → Rozmawiamy → Umawiamy usługę) + CTA label/service + footer.
- `resources/views/blocks/consultation-process.blade.php` — intro + schodki (reuse step-card) + CTA `<x-button class="booking-trigger" data-service="Konsultacja">` (otwiera modal, pomija wybór usługi).
- `app/blocks.php` — rejestracja bloku `consultation-process`.
- `sections/service/sidebar.blade.php` — link „Jak to działa?" `href="#"` → `home_url('/konsultacje/')`.
- Backend rezerwacji nietknięty. SMS wg planu przez Make.com (obecnie tylko e-mail).

### Domknięcie martwych linków — 3 punkty (2026-07-02)
1. **Strona „O mnie"** (`/o-mnie/`) — placeholder utworzony przez wp-cli, potem **USUNIĘTY na życzenie usera** (ma własną wersję z innego urządzenia). Link `/o-mnie/` w bloku `service-video` pozostaje — zadziała, gdy user opublikuje swoją stronę o slugu `o-mnie` (obecnie 404 do tego czasu).
2. **Archiwum realizacji** (`/realizacje/`) — `PostTypes/Portfolio.php` `has_archive => true`; nowy szablon `archive-portfolio.blade.php` (grid 2/3/4 kol + paginacja + pusty stan) + `ArchivePortfolioComposer` (WP_Query portfolio, mapowanie na `portfolio-card`). `portfolio-card` dostał prop `grid` (w-full aspect-[3/4] zamiast fixed-width slidera). Auto-flush rewrite: `dp_rewrite_version` bump → `2026070202`.
3. **CTA chowają się gdy URL pusty** (zamiast linku do `#`): composery `Hero/Offer/Video/Voucher` fallback `'#'`→`''`; warunki w Blade `@if (text && url)` w `hero`, `offer/index`, `voucher` (@elseif url), `components/video-section` (oba warianty + default `''`). Koniec z „przyciskiem donikąd".

### Audyt bezpieczeństwa + martwe linki (2026-07-02)
**Bezpieczeństwo formularzy:**
- `app/Booking/Api.php` — `get_client_ip()` przepisane: **REMOTE_ADDR jako źródło prawdy** (nie da się sfałszować). Nagłówki proxy (CF-Connecting-IP / X-Forwarded-For) honorowane TYLKO gdy zdefiniujesz `BOOKING_TRUST_PROXY` w wp-config (np. za Cloudflare). Naprawia potwierdzony bypass rate-limitu przez spoofing nagłówka IP + fałszowanie logu RODO.
- Honeypot dodany do `/reserve` (Api.php) i `/voucher` (VoucherApi.php) — wcześniej miały go tylko contact/newsletter. Pola `website` w formularzach booking/voucher (booking-modal, voucher-modal) + wysyłka w booking.js/voucher.js.
- **Znane, świadomie zostawione (NISKI):** brak weryfikacji nonce na publicznych endpointach (rate-limit + honeypot jako obrona), Reply-To z `$name` w contact (newline'y ucięte), race condition podwójnej rezerwacji.

**Martwe linki — naprawione w kodzie:**
- Social w `sections/header.blade.php` + `header/nav-mobile.blade.php` — `href="#"` → warunkowo z `$social` (FB/TikTok znikają gdy brak URL; IG z fallbacku). `target=_blank rel=noopener`.
- `blocks/newsletter.blade.php` — „warunki korzystania z usługi" `#` → `/regulamin/`.

**Martwe linki — wymagają strony (nie kod):**
- `/polityka-prywatnosci/` i `/regulamin/` — strony w **draft** → 404. Do opublikowania (treść usera).
- `/o-mnie/` (CTA w `service-video`) — strona nie istnieje. Do utworzenia.
- `/realizacje/` (breadcrumb pojedynczej realizacji) — Portfolio CPT ma `has_archive=false`, brak archiwum. Do decyzji: włączyć archiwum + szablon / strona / zmiana linku.

### Pusty stan poradników w bloku knowledge-base (2026-07-02)
- `blocks/knowledge-base.blade.php` — prawa kolumna „Poradniki" renderowała listę tylko `@if ($guides)`; przy braku poradników zostawała pusta. Dodany `@else` z kartą pustego stanu (ikona document + „Poradniki są już w drodze" + zachęta), spójny z pustym stanem `guides-archive`. „Zobacz Więcej →" ukrywane, gdy brak poradników.

### Fix linków w sidebarze usługi (2026-07-02)
- `sections/service/sidebar.blade.php` — „Sprawdź Regulamin Oferty" `href="#"` → `home_url('/regulamin/')`.
- `components/gift-banner.blade.php` — domyślny `href` „Pomysł na prezent (voucher)" `#` → `home_url('/voucher/')` (banner używany w bloku `service-desc` „Dla kogo" na każdej usłudze). Explicit href nadal nadpisuje.

### Deploy 2026-07-02
- Commit `07d54d7` na `develop` → push. Merge do `staging` (`7b4f72f`) i **`main` (`b162aad`) — pierwszy pełny release produkcyjny** (wcześniej main = tylko „Initial commit"). Wszystkie 3 branche `0 0` z origin, zero konfliktów.
- Serwer dhosting (`dominikpakula.wdb-creative.pl`, branch `staging`): `git pull` + `npm run build` OK.
- **UWAGA:** udokumentowany jest tylko ten jeden serwer (ciągnie `staging`). Jeśli istnieje osobny host produkcyjny — brak jego danych w pamięci, do uzupełnienia.

**Utworzone na serwerze przez wp-cli (2026-07-02):**
- Strona **Poradniki** (ID 378, publish, `template-blocks`): page-header „Poradniki" → guides-archive → subscribe → contact. Zweryfikowana curl-em: HTTP 200, renderuje grid 4 poradników (są demo dane: stacje narciarskie/e-commerce/hak). Single guide `/poradniki/{slug}/` też 200 (bez kolizji ze slugiem strony).
- Strona **Regulamin** (ID 379, **draft**): page-header + placeholder — do wklejenia treści i publikacji.
- Kategorie `guide_category`: Stylizacje (7), Garderoba (8), Okazje specjalne (9) — jeszcze nieprzypisane do poradników (chipsy filtrów pojawią się po przypisaniu).
- `wp rewrite flush` wykonany.
- **Do zrobienia przez usera:** przypisać kategorie do poradników; opublikować Regulamin (po wklejeniu treści); **opublikować Politykę prywatności (ID 3 — nadal draft, link w stopce daje 404)**; podmienić demo-poradniki na realne treści.

### Pułapka deployu: okno OPcache
Przy deployu zgody RODO `/kontakt/` na chwilę zwróciło „W witrynie wystąpił błąd krytyczny". Przyczyna: `opcache.revalidate_freq=2` na dhostingu. Po `git pull` web miał już nowy `ContactBlockComposer.php` (plik nowy, więc bez wpisu w cache), ale wciąż stary `booking.php` z cache — bez `require Consent.php`. Efekt: wywołanie nieistniejącej jeszcze `contact_consent_html()`.

Naprawiło się samo po ~2 s. CLI tego nie pokazuje, bo nie korzysta ze współdzielonego OPcache — `wp eval` renderował stronę poprawnie w tym samym czasie, gdy www zwracało błąd.

**Wniosek na przyszłość:** gdy commit dodaje nowy plik i jednocześnie modyfikuje plik, który go ładuje, po `git pull` na prodzie odczekaj kilka sekund przed weryfikacją albo zresetuj OPcache. Pojedynczy błąd 500 tuż po deployu nie musi oznaczać zepsutego kodu.

### Do zrobienia ręcznie (user)
- [ ] Utworzyć kategorie poradników (Poradniki → Kategorie) i przypisać je do poradników — dopiero wtedy pojawi się pasek filtrów (chipsy renderują się tylko dla `hide_empty=true`).
- [ ] Utworzyć stronę WP „Poradniki" (slug `poradniki`), szablon „Strona z blokami", ułożyć bloki: `page-header` (tytuł/opis/breadcrumb) → **`guides-archive`** → `subscribe` → `contact`.
- [ ] Zweryfikować, że pojedynczy poradnik otwiera się pod `/poradniki/{slug}/` po utworzeniu strony `/poradniki/` (CPT ma `has_archive => false`, więc baza wolna — ale sprawdzić w praktyce).
- [ ] Deploy: nowe klasy Tailwind (`size-16` itp.) → wymaga `npm run build` na stagingu.

---

## 🚀 URUCHOMIENIE PRODUKCJI — meskistylista.pl (2026-07-07)

Pełny deploy staging → produkcja od zera. Produkcja to osobna instancja na tym samym serwerze dhosting (user `wiktor1249`), NIE współdzieli bazy ani plików ze stagingiem.

### Środowisko produkcyjne
- **Domena:** https://meskistylista.pl (live, publiczny DNS działa, PHP 8.x ustawiony w panelu dhosting)
- **Bedrock root:** `~/meskistylista.pl/app/`
- **public_html:** symlink → `app/public` (jak staging)
- **Branch:** `main` (staging zmergowany do main, commit `37fa0ca`; potem fix portretu `52ce5a9`)
- **Baza:** `aew7oo_meskisty` (user `wiktor1249`, hasło = SSH, host `wiktor1249.mysql.dhosting.pl`, prefix `wp_`)
- **`.env`:** `WP_ENV=production`, **świeże salty** (nie te ze stagingu), DB_USER/PASS/HOST te same co staging
- **Staging** (`dominikpakula.wdb-creative.pl`, baza `etey9y_dominikp`) — **nietknięty**, dalej osobne środowisko testowe

### Przebieg deployu (kroki)
1. Merge `staging` → `main` + push (168 commitów, czysty merge)
2. Klon repo do `~/meskistylista.pl/app` (branch main) + kopia `auth.json`
3. `.env` produkcyjny — skrypt czytał staging `.env` (hasło zostało w pliku, nie w komendzie) + podmiana WP_ENV/WP_HOME/DB_NAME + regeneracja 8 saltów
4. **Composer padł na ACF Pro** (`402 activation_limit` — staging zajął seat licencji). Obejście: skopiowane gotowe artefakty ze stagingu (patrz niżej)
5. Build assetów: `npm ci && npm run build`
6. Baza: `wp db export` staging → `wp db import` prod (18 tabel) → `search-replace dominikpakula.wdb-creative.pl → meskistylista.pl` (**101 zamian, 0 pozostałych**)
7. Uploady: kopia 25 MB (wszystkie zdjęcia)
8. `admin_email=kontakt@meskistylista.pl`, `blog_public=1`, flush permalinków, symlink public_html
9. Weryfikacja: home + /o-mnie/ + /uslugi/ + /blog/ + /kontakt/ + podstrona miasta = **HTTP 200, 0 błędów PHP**, CSS/JS/zdjęcia OK, wp-login + sitemap OK

### ⚠️ Skopiowane ze stagingu (bo composer nie pobrał ACF Pro)
- `vendor/` (Bedrock 1.2M) + **theme `vendor/` (43M z Acornem)** — UWAGA: w Sage 11 Acorn siedzi w vendor MOTYWU, nie Bedrocka; oba gitignorowane, więc przy świeżym klonie trzeba je dostarczyć (bez theme vendor → „Error locating autoloader")
- `public/wp` (WP core), `public/app/plugins` (ACF Pro + Rank Math), `mu-plugins`, `languages`, `uploads`
- `composer dump-autoload --optimize` (offline) na prod po skopiowaniu vendor

### ⚠️ ACF Pro — limit aktywacji licencji (do zrobienia przez usera)
Licencja ACF Pro osiągnęła limit aktywacji (staging zajmuje seat). Strona i edytor **działają w 100%** (pliki skopiowane), ale wp-admin pokazuje nag „activation limit reached" i ACF nie auto-aktualizuje. **User musi** wejść na advancedcustomfields.com → licencje i dokupić seat / zwolnić starą aktywację, żeby aktywować meskistylista.pl.

### Fix: portret w bloku personal-intro na /kontakt/ (2026-07-07)
- `PersonalIntroBlockComposer.php` — usunięty nieaktualny guard `if (production) return null` z `fallbackImage()`. Powód: po imporcie bazy załącznik ID 42 („portret dominik") jest identyczny na staging i prod, więc guard tylko chował zdjęcie. Fallback po ID 42 działa teraz na obu środowiskach. Deploy: develop → staging + main → `git pull` na obu serwerach (bez builda, sama zmiana PHP).
- Nadal to fallback po sztywnym ID. Docelowo: dorobić ręcznie pole ACF `intro_image` (typ Image) dla bloku „Personal Intro" — kod już je obsługuje priorytetowo (`get_field('intro_image') ?: fallback`).

### Audyt indeksowania / SEO (2026-07-07) — nic nie blokuje widoczności ✅
- `blog_public=1`, `WP_ENV=production` (mu-plugin `bedrock-disallow-indexing` NIE blokuje na prod)
- Meta robots na wszystkich kluczowych stronach = `index, follow, max-image-preview:large`
- Brak nagłówka `X-Robots-Tag`; `robots.txt` czysty (blokuje tylko `/wp/wp-admin/`, wskazuje sitemapę)
- Rank Math trzyma rozsądne domyślne noindexy (puste taksonomie, wyniki wyszukiwania) — celowe, nie dotyczy treści
- **Poprawka:** `service`/`portfolio`/`guide` NIE były w sitemapie (Rank Math `pt_*_sitemap` nieustawione = pomijane). Włączone przez `wp eval` na opcji `rank-math-options-sitemap` + wyczyszczony cache. Teraz `service-sitemap.xml` = 6 URL (w tym podstrona miasta). `guide-sitemap` pojawi się po opublikowaniu pierwszego poradnika.
- **UWAGA:** ta poprawka sitemapy jest w BAZIE produkcji (konfiguracja WP-admin, nie kod). Przy ewentualnym nadpisaniu bazy prod importem ze stagingu — włączyć ponownie.

### Do zrobienia po stronie usera (produkcja)
- [ ] **ACF Pro:** aktywować licencję dla meskistylista.pl (dokupić seat / zwolnić aktywację) — patrz wyżej
- [ ] **Search Console:** dodać właściwość `meskistylista.pl`, zweryfikować, wysłać `https://meskistylista.pl/sitemap_index.xml`
- [ ] (opcjonalnie) Bing Webmaster Tools — to samo
- [ ] (opcjonalnie) pole ACF `intro_image` dla bloku personal-intro, żeby portret był edytowalny z panelu

### Jak deployować na prod w przyszłości
1. `git checkout main && git merge staging --no-ff && git push origin main`
2. SSH: `cd ~/meskistylista.pl/app && git pull && cd public/app/themes/dominikpakula && export NVM_DIR=$HOME/.nvm && . $NVM_DIR/nvm.sh && npm run build`
3. Treść tworzy się bezpośrednio na produkcji (prod jest źródłem treści — NIE nadpisywać bazy prod importem ze stagingu bez potrzeby)
4. **WP-CLI na serwerze:** domyślny `wp` pada (stary PHP). Używaj: `/usr/bin/php85 /usr/local/bin/wp-cli.phar <cmd>` z katalogu `~/meskistylista.pl/app` (czyta `wp-cli.yml`).

## Audyt bezpieczeństwa produkcji (2026-07-11)

Pełny audyt meskistylista.pl (crawl 23 stron, formularze, black-box + review kodu endpointów). Raport: `~/.claude/plans/cryptic-drifting-kitten.md`.

### Naprawione w KODZIE (branch `develop` — NIEZDEPLOYOWANE, czeka na build)
- **H1 race condition rezerwacji** — `app/Booking/Api.php`: atomowa blokada `GET_LOCK`/`RELEASE_LOCK` wokół check+insert (+ maile poza blokadą).
- **M3 nonce** — nowy helper `verify_booking_nonce()` + guard `X-WP-Nonce` (`wp_rest`) na reserve/contact/newsletter/voucher (JS już wysyłał nonce; front-page cache nieaktywny → bezpieczne).
- **M4 /available** — dodany `check_rate_limit('available',60,10min)` + `meta_query` BETWEEN na miesiąc zamiast `posts_per_page => -1`.
- **L1 limity długości** — reserve/voucher (`mb_strlen` na imię/nazwisko/telefon/email/usługa).
- **L5** — ujednolicone komunikaty „termin niedostępny" (blocked == booked, brak enumeracji).
- **H3 newsletter RODO** — `NewsletterApi.php` wymaga `gdpr` + loguje zgodę (mail admina); checkbox zgody w 2 formularzach (`blocks/newsletter.blade.php`, `partials/blog/subscribe.blade.php`); `newsletter-form.js` waliduje/wysyła `gdpr`; `NewsletterBrevo.php` przyjmuje kontekst zgody.
- **H2+M1+M2+M5 — nowy `app/security.php`** (zarejestrowany w `functions.php`): nagłówki bezpieczeństwa (HSTS/nosniff/X-Frame-Options/Referrer/Permissions-Policy) + `header_remove('X-Powered-By')`; ukrycie wersji WP (generator, `?ver=`, RSD/WLW); blokada enumeracji userów (REST `/users` dla anon + redirect archiwów autora); wyłączenie komentarzy globalnie.

### Zrobione na PRODUKCJI przez WP-CLI (2026-07-11)
- Komentarze: 4 śmieciowe do kosza (1 domyślny WP + 3 testy właściciela), `default_comment_status`/`default_ping_status=closed`, zamknięte na wszystkich 13 wpisach/stronach. Licznik = 0.

### Wymaga decyzji/działania USERA
- **Post ID 1 `witaj-swiecie`** — realna treść (13 KB, bloki lookbook), ale ex-„Hello world" w „Bez kategorii"; niemal duplikat posta 254 (Moda). User sam oceni w panelu (edit: `post=1` vs `post=254`). Po decyzji: ew. draft/rekategoryzacja + kategoria „bez-kategorii".
- **Deploy kodu** — zmiany są na `develop`, niezbudowane. Wymagają pipeline develop→staging→(weryfikacja formularzy)→main + `npm run build` na serwerze.
- **Serwer LiteSpeed / hardening** (nie do zrobienia kodem):
  - Login: limit prób / 2FA (wtyczka przez Composer) — REST users + author już zablokowane kodem.
  - TRACE `→200` (L2) i `.git/` w docroot 403 (L3) — reguły serwera/`.htaccess`.
  - Po deployu zweryfikować `X-Powered-By` (jeśli `header_remove` nie zadziała — Acorn/serwer) i obecność HSTS.

## Sesja 2026-07-17 — copy sidebara usługi, nagłówki bloga, klikalne karty portfolio

Wszystkie zmiany zdeployowane end-to-end: `develop` → `staging` → `main` (produkcja meskistylista.pl), z buildem i czyszczeniem cache na obu serwerach. Zweryfikowane na żywo.

### Sprawdzenie środowisk
- Staging (`dominikpakula.wdb-creative.pl`) i produkcja (`meskistylista.pl`) — SSH OK (klucz bez hasła), HTTP 200, branche `staging`/`main` zgodne. Oba na tym samym serwerze dhosting (`web03-s232`).

### Sidebar usługi — `sections/service/sidebar.blade.php`
- Usunięty mylący dopisek „Cena zawiera 23% VAT, nie obejmuje kosztów przejazdów" (nie pasował do bloku z rezerwacją rozmowy).
- Dodana etykieta **„cena usługi"** nad kwotą — żeby liczba (np. 2800 zł) nie wyglądała na koszt samej rozmowy.
- Nowy dopisek pod przyciskiem: **„Rozmowa jest bezpłatna. Podana cena to koszt usługi — płacisz dopiero, gdy po konsultacji zdecydujesz się na współpracę."** Rozdziela bezpłatną konsultację od płatnej usługi (płatność po decyzji).

### Blok blog — `blocks/blog.blade.php`
- Nagłówki przepisane z brzmienia zespołowego + „świat technologii" na **pierwszą osobę i tematykę męskiego stylu** (strona jednego stylisty).
  - H2: „Styl, inspiracje i porady – zajrzyj do moich najnowszych artykułów."
  - Opis: „Na blogu dzielę się wiedzą i doświadczeniem ze świata męskiego stylu. Zobacz, co nowego i zainspiruj się do zmian w swoim wizerunku."
- Teksty nadal hardcode w szablonie (do ew. przeniesienia na ACF w przyszłości).

### Portfolio — cała karta klikalna
- `components/portfolio-card.blade.php`: **stretched link** (jeden `<a>` z `absolute inset-0 z-20` na całą kartę, `data-card-link`, aria-label „Zobacz realizację: …"). Strzałka zamieniona z linku na element wizualny (`<span aria-hidden>` + `group-hover:scale-110`). Jeden cel fokusa zamiast małej strzałki — lepsza dostępność.
- `js/components/drag-scroll.js`: **blokada kliknięcia po przeciągnięciu** (próg 5px → flaga `dragged` → `click` w fazie capture robi `preventDefault`+`stopPropagation`). Chroni sliderową wersję przed przypadkowym otwarciem realizacji przy drag-scrollu.
- Miejsce: „Portfolio Komercyjne" w menu → strona **`/realizacje/`** (szablon `archive-portfolio.blade.php`, grid `:grid="true"`, bez slidera — więc klik działa bez ryzyka; drag-guard „na zapas" dla bloku sliderowego).

### Learning zapisany do pamięci
- **Po zmianach w Blade**, jeśli strona serwuje starą wersję mimo `git pull` + `npm run build`: wyczyścić skompilowany cache widoków Acorn: `wp acorn view:clear` + `wp cache flush` (przez `/opt/alt/php85/usr/bin/php ~/wp-cli.phar ... --path=public/wp`). `litespeed-purge` NIE jest zarejestrowaną komendą wp-cli w tym projekcie. Page cache LiteSpeed jest serwerowy z krótkim TTL (brak wtyczki LiteSpeed w WP).

### Commity
- Sidebar VAT→CTA: `1f70cd6`, lepszy CTA: `67da3f5`, doprecyzowanie ceny/rozmowy: `445ab10`
- Nagłówki bloga: `9163719`
- Klikalne karty portfolio + drag-guard: `12171e3`
- Breadcrumb bloga: `ad52629` — `blog_url()` (`app/Blog/Helpers.php`) najpierw szuka statycznej strony o slugu `blog`, dopiero potem spada do `home_url()`. Wcześniej breadcrumb „Blog" na wpisie prowadził na stronę główną.
- Produkcja (main) na końcu sesji: `8a0129c`

## Sesja 2026-08-05 — porządek w bloczkach Gutenberga (kategorie + dostępność per typ treści)

Problem: wszystkie 39 bloków ACF siedziało w jednej kategorii „Motyw". Przy pisaniu wpisu blogowego edytor pokazywał komplet — hero, bloki usługi, archiwa — bez sygnału, które są od bloga.

### Grupy bloków — `app/blocks.php` (przebudowa rejestracji)
Wprowadzone pojęcie **grupy**. Każdy blok ma klucz `group`, grupa decyduje o kategorii w edytorze **i** o `post_types` (gdzie blok w ogóle da się wstawić). Dwie funkcje pomocnicze w `App\`: `block_groups()` (definicje) i `block_category_order()` (kolejność kategorii per typ treści).

| Grupa | Kategoria w edytorze | Dostępna w | Bloki |
|-------|----------------------|------------|-------|
| `article` | **Wpis blogowy — wstawki w treść** | wszędzie | blog-pullquote, blog-callout, blog-personal-quote, lookbook-section |
| `blog` | **Blog i poradniki — sekcje** | `page` | blog (3 najnowsze), blog-archive, guides-archive, knowledge-base |
| `service` | **Podstrona usługi** | `page`, `service` | 8× `service-*` (desc, desc-alt, what, why, process, faq, trust, video) |
| `section` | **Sekcje stron** | `page`, `service` | hero, subpage-hero, page-header, services, offer, process, testimonials, portfolio, video, voucher, features, brand-logos, local-seo, manifest\*, text-columns\*, consultation-process, personal-intro |
| `contact` | **Kontakt i newsletter** | wszędzie | contact, contact-bar, contact-channels, next-steps, newsletter, subscribe |

\* `manifest` i `text-columns` mają własne `'post_types' => []` (nadpisanie grupy) — są na tyle uniwersalne, że mogą trafić też do wpisu.

### Kolejność kategorii zależna od kontekstu
`block_categories_all` dostaje `$context` i sortuje kategorie motywu pod edytowany typ treści:
- `post` / `guide` → **Wpis blogowy** na górze, potem Kontakt, Blog, Sekcje, Usługa
- `service` → Usługa, Sekcje, Kontakt, Wpis, Blog
- reszta (strony) → Sekcje, Blog, Kontakt, Usługa, Wpis

### Efekt w edytorze wpisu blogowego
Widoczne tylko: **Wpis blogowy — wstawki w treść** (4 bloki, na samej górze listy) + **Kontakt i newsletter** + `manifest`/`text-columns`. Hero, archiwa i bloki usługi zniknęły z wyszukiwarki.

### Ważne o `post_types`
Ograniczenie działa **wyłącznie na wstawianie nowych bloków**. Treść, która już gdzieś istnieje, renderuje się dalej bez zmian (blok jest zarejestrowany globalnie, filtrowana jest tylko wyszukiwarka). Jeśli okaże się, że jakiś blok był używany poza swoim typem i teraz go nie widać przy edycji — wystarczy dopisać `'post_types' => []` przy tym bloku.

### Zmienione pliki
- `app/blocks.php` — pełna przebudowa: `block_groups()`, `block_category_order()`, klucz `group` przy każdym z 39 bloków, warunkowe `post_types`, `block_categories_all` z `$context` (2 argumenty). Stara kategoria `theme` („Motyw") usunięta — kategoria nie jest zapisywana w treści, więc istniejące bloki nic nie tracą.
- Tytuł bloku `blog` doprecyzowany: „Blog" → „Blog — 3 najnowsze wpisy" (mylił się ze stroną zbiorczą i wstawkami blogowymi).

### Uwagi
- Zmiana jest czysto PHP (brak nowych klas Tailwinda), ale build i tak leci — plus `wp acorn view:clear` na serwerach, zgodnie z learningiem z 2026-07-17.
- Nie udało się zinwentaryzować użycia bloków na produkcji przez SSH (komendy `wp db query` / pętla po `wp post get` zablokowane przez klasyfikator uprawnień) — stąd konserwatywne `post_types` (sekcje dostępne i na stronach, i na usługach).

## 🚨 INCYDENT BEZPIECZEŃSTWA 2026-08-05 — obce konta administratora (prod + staging)

Wykryty przy okazji zgłoszenia „nie mogę się zalogować na admina, a nie zmieniałem hasła".

### Zakres
- **meskistylista.pl (prod):** 20 obcych kont administratora, zakładanych od **2026-07-21 01:13** do **2026-08-04 23:58**. Wzorce nazw: `Nx_*@nx.invalid` (7), `w2s_*@wp2shell.local` (7), `wp2_*@wp2shell.invalid` (4), `wpenginebot@wpengine.com`, `wpsvc_*@wordpress-svc.internal`.
- **dominikpakula.wdb-creative.pl (staging):** 4 obce konta od **2026-07-20 20:35** (`Nx_*`, `bunk_*`, `wp_admin_9d7008@local.host`).
- **Aktywne sesje intruza w chwili wykrycia:** 2 (`wp2_507429c8c1c6`, `wpenginebot`). Konto `admin` miało 6 wiszących sesji.

### Co NIE zostało naruszone (zweryfikowane)
- Pliki motywu i Bedrocka — `git status` czysty na obu serwerach, zero podmian
- Rdzeń WordPressa — `wp core verify-checksums` przechodzi
- Brak PHP w `uploads/`, brak obcych wtyczek, mu-pluginów i drop-inów
- `.htaccess` niezmieniony (7.07), cron czysty, `users_can_register=0`
- Brak haseł aplikacji (typowa persystencja) na jakimkolwiek koncie
- `~/.ssh/authorized_keys` — 4 klucze, wszystkie własne (`deploy@zahakowani-prod` to klucz do `zahakowani.pl`, innej domeny na tym samym koncie), plik nietykany od 12.05
- Treści: od 15.07 zmienione 3 pozycje, wszystkie autorstwa ID 1 (własne edycje)
- **Rezerwacje: 0 rekordów** — brak danych osobowych klientów do wykradzenia. Newsletter siedzi w Brevo, nie w WP.

### Wektor wejścia — ustalenia z logów
Logi dostępowe: `~/.logs/www/<domena>/access.log*` (dhosting trzyma od 07.07, nie na dysku projektu).
- **W momencie powstania pierwszego konta (21.07 01:13) NIE MA żadnego żądania HTTP** — ani logowania, ani wywołania REST. Konta nie powstały przez formularz ani API tej witryny.
- Pierwsze zalogowanie intruza w logach: **29.07 12:06 z IP `87.120.93.46` (DE)** — `POST /wp/wp-login.php` → 302 **za pierwszym razem**, bez śladu zgadywania hasła. Przyszedł z gotowymi danymi konta założonego wcześniej.
- Po zalogowaniu próbował `plugin-install.php` i `update-core.php` → 404 (ścieżki Bedrocka) — a instalacja wtyczek i tak jest zablokowana przez `DISALLOW_FILE_MODS`/`DISALLOW_FILE_EDIT` w `config/application.php`. To tłumaczy brak backdoora w plikach.
- XML-RPC: próby z TR (20.07, 21.07) → 403, odbite przez serwer.

**Wniosek:** wpis szedł z pominięciem WordPressa — dostęp do bazy lub do konta hostingowego. Pasuje do tego niezrealizowany od maja punkt „rotacja hasła SSH dhosting (było plaintextem w czacie)" — to samo hasło jest hasłem MySQL, a obie strony (prod + staging) współdzielą konto `wiktor1249`. Na koncie stoi **11 domen pod jednym użytkownikiem systemowym**, więc alternatywny scenariusz to kompromitacja sąsiedniej witryny i wejście przez współdzielony filesystem. Rozstrzygnięcie wymaga sprawdzenia pozostałych 10 stron (nie zrobione — komendy poza katalogiem projektu blokuje klasyfikator uprawnień).

### Hardening wdrożony w kodzie — `app/security.php` (dopisek)
Blokady dróg wejścia przez aplikację:
- **Limit prób logowania** — 5 nieudanych z jednego IP / 15 min blokuje kolejne (transient, `authenticate` prio 30 + `wp_login_failed` + `wp_login`). Domykało otwarty punkt audytu z lipca.
- **Jednolity komunikat błędu logowania** (`login_errors`) — koniec z rozróżnianiem „zły login" / „złe hasło".
- **XML-RPC wyłączony** w aplikacji (`xmlrpc_enabled`, `xmlrpc_methods`, zdjęty `X-Pingback`) — kanał brute-force przez `system.multicall`.
- **Hasła aplikacji wyłączone** (`wp_is_application_passwords_available`) — działają po zmianie hasła konta, wygodna persystencja.
- **Zakaz zakładania kont przez REST** (`rest_pre_insert_user`, tylko tworzenie; aktualizacje profilu przechodzą).

Wykrywanie:
- **Alarm mailowy o nowym administratorze** — `user_register` / `set_user_role` / `add_user_role`; mail z loginem, e-mailem, IP, kto wykonał.
- **Dobowy audyt listy adminów** (cron `dp_admin_audit`) — porównuje bieżącą listę z opcją `dp_known_admins` i mailuje o różnicy. **To jedyna kontrola, która wyłapałaby ten incydent**, bo wpis prosto do bazy nie odpala żadnego hooka. Pierwsze uruchomienie zapisuje stan odniesienia — dlatego czyszczenie obcych kont trzeba zrobić PRZED albo skasować `dp_known_admins` po sprzątaniu.

### Sprzątanie — wykonane 2026-08-05
- [x] **Nowe konto administratora** `dpakula` (ID 22, `kontakt@meskistylista.pl`) na produkcji — hasło wygenerowane przez wp-cli, zmienione przez usera po pierwszym logowaniu
- [x] **Usunięte wszystkie 24 obce konta** — 20 na produkcji, 4 na stagingu (`--reassign=1`, treści przepisane na ID 1)
- [x] **Sesje wyczyszczone** — `wp user session destroy 1 --all` na obu środowiskach (konto `admin` miało 6 wiszących sesji)
- [x] **Rotacja saltów** na prod i staging — 8 wartości (80 znaków, `openssl rand`) wygenerowanych bezpośrednio na serwerze, backup w `.env.bak-20260805`. Po rotacji smoke-test: home/blog/usługi/panel = 200
- [x] **Sekretny adres logowania** aktywny na obu środowiskach (patrz sekcja wyżej)
- [x] Weryfikacja końcowa: zero obcych kont, zero haseł aplikacji, `git status` czysty, `core verify-checksums` OK, cron bez obcych zadań

### Do zrobienia — poza kodem (user)
- [ ] **Zmiana hasła dhosting (panel + SSH + MySQL)** — priorytet 1, jedyny nie domknięty element wektora. Po zmianie hasła MySQL podmienić `DB_PASSWORD` w `.env` na obu serwerach, inaczej strony padną.
- [ ] Stare konto `admin` (ID 1) — zdegradować lub usunąć po przepisaniu treści; login `admin` jest zgadywalny. E-mail wciąż `dev-email@wpengine.local` (dlatego reset hasła nie działał).
- [ ] **Przegląd pozostałych 10 domen** na koncie `wiktor1249` pod kątem tego samego wzorca kont (`Nx_*`, `w2s_*`, `wp2_*`)
- [ ] Rozważyć 2FA (wtyczka przez Composer) — kod limituje próby, ale nie zastępuje drugiego składnika
- [ ] Usunąć backupy `.env.bak-20260805` z obu serwerów, gdy potwierdzisz że wszystko działa (zawierają stare salty i hasło do bazy)

### Sekretny adres logowania (2026-08-05, po hardeningu)
- `app/login-url.php` (nowy, ładowany w `functions.php`) + `Config::define('WP_LOGIN_SLUG', …)` w `config/application.php`.
- Slug siedzi w `.env` każdego środowiska (**nie w repo**), inny na prod i na stagingu. Wejście na `/<slug>/` serwuje `wp-login.php`; bezpośrednie wejście na `wp-login.php` oraz na `wp-admin` bez sesji → 302 na stronę główną. Wszystkie adresy generowane przez WP (logowanie, wylogowanie, reset hasła, przekierowania) są przepisywane na slug.
- Wyjątki: `action=postpass`, `admin-ajax.php`, `admin-post.php`.
- **Awaryjny wyłącznik:** usuń `WP_LOGIN_SLUG` z `.env` → logowanie wraca na `wp-login.php`. Lokalnie zmiennej nie ma, więc Local działa standardowo.
- Zweryfikowane na obu środowiskach curl-em (formularz pod slugiem, 302 na wp-login/wp-admin, POST ze złym hasłem → jednolity komunikat).
- **Pułapka przy weryfikacji:** LiteSpeed serwował przez chwilę stare odpowiedzi (slug 404, wp-login 200) mimo działającego kodu. Sprawdzać z `?nocache=<losowe>`, zanim zacznie się szukać błędu w kodzie.

### Wnioski
- `DISALLOW_FILE_MODS` uratował sytuację: intruz z prawami administratora **nie mógł** zainstalować wtyczki-backdoora, więc kompromitacja została w bazie i sprząta się usunięciem kont + rotacją haseł.
- Brak jakiegokolwiek monitoringu oznaczał, że konta przybywały przez 15 dni niezauważone. Stąd dobowy audyt — bez niego następny taki incydent też wyjdzie przypadkiem.
- Hasła produkcyjne nigdy nie mogą przechodzić przez czat. Punkt „rotacja hasła SSH" wisiał niezrealizowany od maja i jest dziś głównym podejrzanym.

## Sesja 2026-08-06 — wpis blogowy: sidebar po prawej, zdjęcie autora, kolejność sekcji

### Zmiana 1 — sidebar po prawej, `partials/blog/body.blade.php`
- `<aside>` ze sticky sidebarem (TOC + „Czytaj też" + Share) przeniesiony **fizycznie za** kolumnę contentu; usunięte `lg:order-first`.
- Efekt uboczny na plus: kolejność w DOM zgadza się teraz z wizualną, więc czytnik ekranu i tabulacja idą **najpierw przez treść wpisu**, dopiero potem przez TOC/share. Wcześniej `order-first` je rozjeżdżał.
- Mobile bez zmian — sidebar dalej `hidden lg:block`, TOC w `<details>` i share pod treścią.
- Partiale `sidebar`, `toc`, `share`, `related-teaser` nie miały żadnych klas zależnych od strony (`border-l`, `pl-*` itp.) — nic nie wymagało korekty.

### Zmiana 2 — zdjęcie autora w sekcji „Autor", `SinglePostComposer.php`
Sekcja „Autor" pod wpisem brała avatar wprost z `get_avatar_url()`. Konta bez Gravatara (m.in. `dpakula` na produkcji) pokazywały domyślną szarą sylwetkę.
- Nowa metoda `SinglePostComposer::authorPhoto(int $authorId): string` — kolejność źródeł:
  1. pole ACF `author_photo` z profilu użytkownika (`get_field('author_photo', "user_{$id}")`)
  2. wspólny portret — stała `FALLBACK_PORTRAIT_ID = 42` („portret dominik", ten sam załącznik co fallback w `PersonalIntroBlockComposer`)
  3. Gravatar (`get_avatar_url`, 192px)
- Pole ACF obsłużone we wszystkich formatach zwrotu (Array / ID / URL) przez `match(true)` — pole tworzone ręcznie w panelu, więc nie zakładamy ustawienia.
- Blade `partials/blog/author-bio.blade.php` **bez zmian** — dalej dostaje gotowy URL w `$author['avatar']`.
- **Kadr do sprawdzenia okiem:** załącznik 42 to `Strona-5-scaled.jpg` w proporcji poziomej 3:2 (medium = 300×200), a wyświetla się w kółku z `object-cover` — WP przycina środkowy kwadrat i obcina boki. Jeśli kadr nie siada, wgrać kwadratowe zdjęcie i podpiąć przez `author_photo`.
- **Do zrobienia w panelu (user):** pole `author_photo` (typ **Image**, lokalizacja `User Form is equal to All`). Zakładać jako **nową grupę**, nie dopisywać do grupy z `author_role` — tamta powstała przed auto-syncem i **nie ma jej w `acf-json/`**, więc siedzi tylko w bazie i nie pojedzie gitem na prod.

### Zmiana 3 — kolejność sekcji: „Autor" przed „Subscribe", `single-post.blade.php`
- Było: body → **subscribe** → **author bio** → booking CTA. Jest: body → **author bio** → **subscribe** → booking CTA.
- **Świadome odwrócenie wcześniejszej decyzji projektowej** z briefu (2026-04-21: „subscribe natychmiast po body, przed author bio — email capture kiedy reader jest zaangażowany"). Decyzja usera 2026-08-06: podpis autora ma iść bezpośrednio pod treścią, newsletter/Instagram dopiero pod nim.
- Zmiana to wyłącznie przestawienie dwóch `@include` — oba partiale niezmienione, numeracja komentarzy w szablonie zaktualizowana.

### Deploy — develop → staging → produkcja (ta sama sesja)

**Zmiana 1 (sidebar):**
- Commit na `develop`: **`de5cbd0`**
- Merge `develop → staging` (--no-ff): **`a9df5e2`** → SSH `git pull` + `npm run build` (Vite 1.87s) + `wp acorn view:clear` + `wp cache flush`
- Zweryfikowane przez usera na stagingu → merge `staging → main` (--no-ff): **`04c531c`** → SSH `git pull` + `npm run build` (Vite 1.76s) + view:clear + cache flush
- Na `staging` względem `main` nie było żadnych obcych commitów — na produkcję pojechała wyłącznie ta zmiana.
- Hashe assetów po buildzie identyczne na obu środowiskach (`app-DNoLvp9J.css`, `app-DvaDIHZ1.js`) — zmiana była czysto w Blade, CSS/JS bez różnic. `view:clear` był tu **konieczny**, bo build sam z siebie nie odświeża skompilowanych widoków.
- Wszystkie trzy branche zsynchronizowane, praca wraca na `develop`.

**PROJECT_STATUS.md** (sam dokument): commit **`bfce46e`** na `develop`, pojechał na serwery razem z kolejną paczką.

**Zmiana 2 (zdjęcie autora):**
- Commit na `develop`: **`5cb4725`** → merge `staging` **`215f518`** → merge `main` **`7bf761c`**
- Oba środowiska: `git pull` + `npm run build` + `wp acorn view:clear` + `wp cache flush`
- Zweryfikowane curl-em w renderze: staging i produkcja zwracają `<img src=".../Strona-5-300x200.jpg">` w sekcji Autor.
- **Pułapka przy weryfikacji:** pierwsze sprawdzenie produkcji pokazało jeszcze `secure.gravatar.com/...&d=mm`, mimo `view:clear` + `cache flush`. To był nieodświeżony cache brzegowy, nie kod — kolejne żądanie (już po wygaśnięciu TTL) zwróciło portret. Nie zadziałał tu cache-buster w query stringu, tylko upływ czasu — patrz sekcja niżej.
- Diagnostyka przy okazji (wp-cli na prod): `wp post get 42` → „portret dominik", `_wp_attached_file` = `2026/03/Strona-5-scaled.jpg`, `wp_get_attachment_image_url(42, 'medium')` zwraca URL poprawnie na obu środowiskach.

**Zmiana 3 (kolejność sekcji):**
- Commit na `develop`: **`407d469`** → merge `staging` **`cf19b66`** → merge `main` **`3bf4b60`**
- Oba środowiska: `git pull` + `npm run build` + `wp acorn view:clear` + `wp cache flush`
- Zweryfikowane w renderze — sekcja Autor wychodzi przed `id="newsletter-form"` i kartą Instagrama na obu środowiskach.

### Zmiana 4 — podpis autora wewnątrz kolumny treści
Sekcja „Autor" była osobnym, pełnoszerokościowym blokiem pod gridem — bio ciągnęło się przez całą stronę, także pod sidebarem, i nie trzymało się krawędzi tekstu wpisu.
- `partials/blog/author-bio.blade.php` — zdjęty własny kontener (`mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16`); zastąpiony `mt-12 pt-10 border-t border-black/10` (ta sama cienka linia co nad tagami). Partial nie ma już własnych paddingów, bo dziedziczy je z kolumny.
- `partials/blog/body.blade.php` — `@include('partials.blog.author-bio')` na samym dole kolumny treści, pod tagami i mobilnym share.
- `single-post.blade.php` — usunięty osobny `@include`, numeracja sekcji poprawiona (0–8).
- Wcześniej w tej samej sesji: usunięte `max-w-[640px]` z akapitu bio (tekst łamał się dużo wcześniej niż galeria nad nim).
- **Uwaga:** kolumna treści to `lg:col-span-8 xl:col-span-9`, więc bio łamie się na więcej linii niż w wersji pełnoszerokościowej. Jeśli okaże się za ciasno — zmniejszyć avatar albo przenieść bio pod niego zamiast obok.
- `author-bio` jest używany **wyłącznie** w `single-post` (sprawdzone grepem), więc przebudowa partiala nie dotyka innych szablonów.

### Zmiana 5 — „W cenie znajdziesz" wypełnione per usługa (zmiana w BAZIE, nie w kodzie)
Repeater ACF `service_included_items` był pusty we wszystkich usługach, więc sidebar leciał z hardcodowanego fallbacku w `ServiceComposer::includedItems()` (`Konsultacja 1-1 (60 min)` / `Plan stylizacji dopasowany do Ciebie` / …). Uzupełnione z notatki usera, **6 usług × 4 pozycje, na produkcji i na stagingu**.

| ID | Usługa | Lista |
|----|--------|-------|
| 362 | Zakupy ze stylistą | zakupy |
| 138 | Przegląd szafy + zakupy | zakupy |
| 477 | Zakupy ze Stylistą Kraków | zakupy |
| 367 | Zakupy Online ze Stylistą | online |
| 354 | Przegląd szafy | przegląd |
| 358 | Stylizacja Okazjonalna | okazjonalna |

- Zapis przez `wp eval-file` + `update_field()` (skrypt jednorazowy, po wykonaniu usunięty z serwera). ID usług są **takie same na prod i na stagingu** (bazy z tego samego importu).
- Dwie normalizacje względem notatki: „Wiedz**ą** na temat tkanin…" → „Wiedza…", oraz małe „konsultacja 1-1" → „Konsultacja 1-1" (spójnie z pozostałymi listami).
- **To zmiana w bazie — nie wersjonuje się w gicie.** Przy nadpisaniu bazy produkcyjnej importem trzeba powtórzyć.
- **Uwaga na pomyłkę:** sekcja **„Co Dostaniesz"** w treści strony usługi to co innego — blok `acf/service-what` z własnymi polami (`what_items`: ikona + tytuł + opis), edytowany w Gutenbergu per strona. Nie ma nic wspólnego z sidebarowym `service_included_items` i nie został tknięty.

### Zmiana 6 — tytuły i slugi usług + `app/redirects.php`
- **477**: „Zakupy ze Stylista Kraków" (prod) / „Zakupy ze Stylista **Karków**" (staging, literówka) → **„Zakupy ze Stylistą Kraków"** na obu.
- **477 slug**: `zakupy-ze-stylista-krakow-2` (prod) / `zakupy-ze-stylista-karkow` (staging) → **`krakow`**. Sufiks `-2` brał się z kolizji z **załącznikiem ID 437** o slugu `zakupy-ze-stylista-krakow`. Nowy URL: `/uslugi/zakupy-ze-stylista/krakow/` (477 jest dzieckiem usługi 362).
- **362**: „Zakupy ze stylista" → **„Zakupy ze stylistą"**. Slug bez zmian, więc URL się nie ruszył.
- **🔑 Pułapka:** `wp_check_for_changed_slugs()` (a więc `_wp_old_slug` i automatyczne przekierowanie WP) **nie działa dla typów hierarchicznych** — a `service` jest hierarchiczny. Po zmianie sluga stary adres dawał **404, nie 301**. Stąd nowy plik:
- **`app/redirects.php`** (nowy, dopisany do listy w `functions.php` po `login-url`) — mapa `stara ścieżka => nowa ścieżka`, wpięta w `template_redirect` z priorytetem 1, odpala się wyłącznie gdy `is_404()`. Zawiera oba stare adresy Krakowa (prod + staging). Kolejne zmiany slugów w hierarchicznych CPT dopisywać do `App\redirect_map()`.
- Zweryfikowane: stary URL → **301** na `/uslugi/zakupy-ze-stylista/krakow/`, nowy → 200, na obu środowiskach.

**Ta sama literówka w opiniach (CPT `testimonial`, pole `testimonial_service`):**
- prod: opinia **103 (Michał)** miała `"Zakupy ze stylista "` (bez „ą", ze spacją na końcu) → `Zakupy ze stylistą`
- staging: opinia **88 (Karol)** — to samo. Uwaga: **opinie na stagingu to inne osoby niż na prodzie** (103 = Wiktor, 101 = Adam, 88 = Karol), więc ID nie mapują się 1:1 jak w usługach.
- Po poprawkach: **zero** wystąpień starego zapisu na stronach głównych obu środowisk.

### ❓ „Nic się nie zmieniło na produkcji" — sprawdzone, nic nie jest hardkodowane
Zgłoszenie po wypełnieniu `service_included_items`. Weryfikacja: wyciągnięty tekst z żywej strony prod pokazuje **nowe** pozycje, a stary fallback (`Konsultacja 1-1 (60 min)`, `Plan stylizacji dopasowany do Ciebie` z `ServiceComposer.php:162-167`) nie pojawia się na żadnej z 5 dostępnych stron usług.
- Najczęstsza pomyłka: sekcja **„Co Dostaniesz"** w treści strony to blok `acf/service-what` (pola `what_items`: ikona + tytuł + opis, edytowane w Gutenbergu per strona) — **to nie jest** sidebarowe `service_included_items` i nie da się jej wypełnić z tej samej listy jednolinijkowców.
- **Trzecia i faktyczna przyczyna w tym zgłoszeniu: user patrzył na LOKALNĄ stronę.** Lokalna baza jest mocno nieaktualna — ma **1 usługę** (138 „Przegląd szafy + zakupy"), podczas gdy prod i staging mają **6**. Pole było tam puste, więc leciał fallback. Uzupełnione lokalnie 2026-08-06 (`wp eval-file` + `wp acorn view:clear`). **Do rozważenia: zrzut bazy z produkcji na lokalkę**, żeby nie pracować na treściach sprzed kilku miesięcy.
- Druga przyczyna: **produkcja rewaliduje z opóźnieniem**. Po deployu zmiany w PHP stary stan potrafi się utrzymać kilkanaście sekund mimo `view:clear` + `cache flush` (przekierowanie Krakowa: 404 przy pierwszym sprawdzeniu, 301 po ~15 s, bez żadnej dodatkowej akcji). Staging odpowiada od razu.

### Zmiana 7 — „Dla kogo” wariant C (karty) — TEST, tylko staging
Nowy układ bloku „Czy ta usługa jest dla Ciebie?” wzorowany na referencji od usera: trzy karty obok siebie, **pierwsza (sekcja „Tak”) wyróżniona** `bg-primary` z CTA `.booking-trigger`, dwie pozostałe białe. Separatory rysowane przez `gap-px` na tle `black/10`.

- `resources/views/blocks/service-desc-cards.blade.php` — nowy widok
- `ServiceDescBlockComposer` — dopisany drugi widok do `$views`; **wariant C dzieli dane z wariantem A**, zero duplikacji logiki
- `acf-json/group_69cbafc509318.json` — druga reguła lokalizacji (`block == acf/service-desc-cards`)
- `app/blocks.php` — rejestracja „Dla kogo — wariant C (karty)”, grupa `service`
- Na stagingu podmieniony w treści 5 głównych usług (362, 138, 354, 358, 367). Strona Kraków (477) zostaje na wariancie B.
- **Na produkcji NIE wdrożone** — kod jest tylko na `develop`/`staging`, treść usług na prodzie dalej używa wariantu A.

**Dlaczego podmiana nazwy bloku nie gubi treści:** ACF Blocks trzymają wartości pól w atrybucie `data` komentarza bloku (w `post_content`), nie w postmeta. Wspólna grupa pól + zmiana samej nazwy bloku = te same dane, inny render.

**🔑 Wpadka i nauka — `wp_slash()`:**
`wp_update_post()` **i `update_post_meta()`** robią wewnętrznie `wp_unslash()`. Pierwsza wersja skryptu podmieniającego zapisała treść bez `wp_slash()` → z każdego wpisu zniknęły wszystkie backslashe: `\r\n`→`rn`, `\t`→`t`, `<`→`u003c`, `"`→`u0022`. Widoczne na stronie jako literalne „rn” w tekście.
- **Kopia zapasowa też była uszkodzona**, bo zapisał ją `update_post_meta()` bez `wp_slash()` — rewert przywrócił zepsutą treść. Kopia bez `wp_slash()` jest bezwartościowa.
- Nadpisanie treścią z produkcji **odrzucone przez bezpiecznik** — staging ma własne teksty (358 różni się o 977 znaków).
- Naprawa dwuetapowa: `uXXXX` → `\uXXXX` (tylko 3 kody w danych: `"`, `<`, `>` — sprawdzone, żadnego trafienia w prozę), potem `>rn t<` → `>\r\n \t<` wg wzorca z produkcji.
- **Kolejność ma znaczenie:** naprawa `uXXXX` przed `rn` tworzy literę `e` przed `rn`, przez co lookbehind `[A-Za-z]` pomija trafienie. Za pierwszym razem właśnie tak zostały 3 niedobitki.
- `rn` występuje w polskich słowach („oga**rn**ąć”) — wzorzec musi być zawężony do sąsiedztwa `<`/`>`.
- Każdy krok walidował `json_decode()` wszystkich komentarzy bloków przed zapisem. Stan końcowy = format identyczny z produkcją.

**🐛 Znaleziony przy okazji, NIEnaprawiony błąd na produkcji:** warianty arbitralne `[&_a]:` w `blocks/service-desc.blade.php` (wariant A) **nie działają w treści z `the_content`** — wptexturize zamienia `&` na `&#038;`, więc w HTML jest `[&#038;_a]:underline` i Tailwind tego nie dopasowuje. Na prodzie **54 zepsute wystąpienia** — linki w sekcji „Raczej nie” są nieostylowane. Wariant C omija problem klasą `.desc-card-item` + regułą `@apply` w `app.css`. **Wariant A do poprawienia tym samym sposobem** (patrz `feedback_wptexturize_arbitrary_variants`).

### ⚠️ Weryfikacja renderu — cache brzegowy na produkcji ignoruje query string
Uzupełnienie learningu z 2026-07-17, kosztowało dziś dwa fałszywe alarmy (avatar autora, kolejność sekcji):
- Na `meskistylista.pl` **`?nocache=…` / `?bust=…` NIE omijają cache brzegowego** — dwa różne, losowe bustery zwróciły identyczną starą stronę, mimo że plik na serwerze był poprawny (`git log` + `grep` potwierdzone) i compiled views wyczyszczone.
- Omija dopiero nagłówek żądania: `curl -s -H 'Cache-Control: no-cache' -H 'Pragma: no-cache' <URL>` — i wtedy od razu widać nową wersję.
- Cache wygasa sam po ~minucie; zwykłe żądanie pokazuje wtedy nowe.
- Na stagingu query string wystarcza — stąd mylące wrażenie, że „na stagingu działa, na prodzie nie".
- **Kolejność diagnozy przy podejrzeniu nieudanego deployu:** `git log -1` na serwerze → `grep` zmienionego fragmentu w pliku → `curl` z nagłówkiem no-cache. Dopiero gdy to nie pomoże, szukać błędu w kodzie.

### Bez zmian w stosunku do poprzedniej sesji
Otwarte punkty z incydentu 2026-08-05 (rotacja hasła dhosting, stare konto `admin` ID 1, przegląd 10 pozostałych domen, 2FA, usunięcie `.env.bak-20260805`) — **nadal do zrobienia po stronie usera**.

---

## Sesja 2026-08-11 — nawigacja na tablecie w poziomie

**Problem:** przy szerokościach tabletu w poziomie (1024–1279 px) desktopowa nawigacja się rozjeżdża — logo + pozycje menu + 3 ikony social + CTA nie mieszczą się w jednym rzędzie.

**Rozwiązanie (wybrane przez usera):** progi `lg` zostają bez zmian (poniżej 1024 px dalej hamburger), a w zakresie `lg`–`xl` **ukrywana jest ostatnia pozycja pierwszego poziomu** menu `primary_navigation`. Od 1280 px w górę menu jest kompletne. W menu mobilnym pozycja jest widoczna zawsze.

> Uwaga na przyszłość: pierwsze podejście przesuwało cały próg desktop↔mobile z `lg` na `xl` — **cofnięte**, user chciał zachować desktopową nawigację na tabletach w poziomie.

Pliki:
- `app/View/Composers/NavigationComposer.php` — nowe metody `menuItems(string $location)` i `lastTopLevelId(array $items)`; do widoków trafiają `primaryMenuItems` (surowe pozycje menu) i `primaryLastItemId`. Przy okazji: pobieranie menu zeszło z Blade do Composera, zgodnie z zasadą „backend do backendu”.
- `resources/views/sections/header/nav-desktop.blade.php` — `$menuItems` bierze się z `$primaryMenuItems`; zmienna `$tabletHidden` (`hidden xl:block` dla ostatniej pozycji) doklejana do wszystkich czterech wariantów renderowania pozycji: trigger mega-menu Usług, trigger mega-menu Bazy Wiedzy, zwykły dropdown i zwykły link.
- `resources/views/sections/header/nav-mobile.blade.php` — usunięty hack `$menuItems = $menuItems ?? wp_get_nav_menu_items(...)`, dane idą z Composera.

**Dlaczego `hidden xl:block`, a nie `lg:hidden`:** nav jest `hidden lg:flex`, więc poniżej `lg` pozycja i tak nie istnieje na ekranie. `hidden xl:block` daje jeden spójny zapis dla wszystkich czterech wariantów (`<a>` i `<div>`), a w kontenerze flex `block` vs `inline` nie robi różnicy wizualnej.

**Bez zmian:** JS — `mega-menu.js` nie ma logiki breakpointowej, a `initMegaPanel()` robi early-return gdy nie znajdzie triggera. Jeśli ostatnią pozycją okaże się trigger mega-menu, handlery po prostu nigdy nie odpalą (element `display:none`).

Build lokalny odpalony (`npm run build`), `NavigationComposer.php` przeszedł `php -l` (PHP 8.5 z Local). **Nie zdeployowane na staging ani prod.**

### Stopka — overflow na tablecie w poziomie (ta sama sesja)

**Problem:** stopka wychodziła poza ekran w zakresie 1024–1279 px. `$gridCols` definiował 5 sztywnych torów od `lg`: `minmax(180,220) + minmax(160,180) + minmax(180,220) + minmax(140,170)` = **660 px minimum** + 4 × `gap-12` = **192 px**, razem 852 px. Przy 1024 px na treść zostaje 864 px (`px-20` = 160 px), więc na piąty tor zostawało 12 px — a `1fr` ma domyślnie `min-width: auto`, czyli nie schodzi poniżej min-content nazw usług. Efekt: poziomy scroll.

**Zmiana** (`resources/views/sections/footer.blade.php`):
- Sztywne tory przeniesione z `lg:` na `xl:` — mieszczą się dopiero od 1280 px.
- Skala kolumn: `grid-cols-1` → `sm:grid-cols-2` → `lg:grid-cols-3` → `xl:` sztywne tory. Przy 1024 px daje to 3 × 256 px.
- Ostatni tor `1fr` → **`minmax(0,_1fr)`** — bez tego tor nie może zejść poniżej min-content i to on generuje overflow.
- `min-w-0` na wszystkich pięciu kolumnach (dzieci grida też mają domyślnie `min-width: auto`).
- Lista usług: `sm:grid-cols-2` → `xl:grid-cols-2`, bo poniżej xl kolumna jest za wąska na pełne nazwy usług.

**Do zapamiętania:** przy `grid-cols-[...]` z sztywnymi `minmax()` zawsze licz sumę minimów + gapy względem najwęższego breakpointu, na którym klasa działa, i ostatni elastyczny tor pisz jako `minmax(0,_1fr)`, nie `1fr`.

### Tablet w pionie (md, 768–1023 px) — 2 kolumny w dwóch sekcjach

Dotyczy strony głównej i `/uslugi/` — obie używają tych samych bloków, więc zmiana w szablonie bloku pokrywa obie strony.

**`blocks/offer/index.blade.php`** („MOJA OFERTA") — `grid-cols-1 lg:grid-cols-4` → `grid-cols-1 md:grid-cols-2 lg:grid-cols-4`.

**`blocks/services/index.blade.php`** („Powiedz mi, z czym się mierzysz") — sekcja była flexem (`flex-col lg:flex-row`), bo od lg karty mają stałe 300 px, a highlight rozpycha się na resztę. Na md przełączona na grid: `flex flex-col md:grid md:grid-cols-2 lg:flex lg:flex-row`. Przy 4 elementach (highlight + 3 karty) daje układ 2×2.

**`blocks/services/highlight-card.blade.php`** — `h-[436px] lg:h-auto lg:min-h-[436px]` → `h-[436px] md:h-auto md:min-h-[436px]`. Bez tego w gridzie na md karta zostawałaby na sztywnych 436 px zamiast rosnąć do wysokości wiersza. `lg:` warianty zbędne, bo `md:` obowiązuje też wyżej.

**Uwaga przy zmianie display przez warianty:** `md:grid` + `lg:flex` działa, bo Tailwind emituje media queries w kolejności breakpointów (48rem przed 64rem) — zweryfikowane w skompilowanym CSS.

### Listingi bloga — 3 kolumny od md

- `blocks/blog.blade.php` (blok „najnowsze wpisy", 3 ostatnie) — `grid-cols-1 lg:grid-cols-3` → `grid-cols-1 md:grid-cols-3`.
- `blocks/blog-archive.blade.php` — `grid-cols-1 md:grid-cols-2 lg:grid-cols-3` → `grid-cols-1 md:grid-cols-3` (usunięty pośredni krok na 2 kolumny).
- `partials/blog/related-posts.blade.php` — już miał `md:grid-cols-3`, bez zmian.
- `lg:grid-cols-3` stało się zbędne, bo `md:` obowiązuje też wyżej.

Przy 768 px daje to ~229 px na kartę (`px-4` = 32 px + 2 × `gap-5`). `blog-card` nie ma sztywnych szerokości, więc się skaluje.

**NIE ruszone (do decyzji usera):** `blocks/guides-archive.blade.php` i `partials/guide/related.blade.php` dalej mają `md:grid-cols-2 lg:grid-cols-3` — to poradniki, nie blog.

---

## 🚨 INCYDENT 2026-08-10 — przejęcie konta `admin` ID 1 na produkcji

Wykryty 2026-08-11 przy okazji pytania „gdzie zniknęła strona /baza-wiedzy/". Drugi incydent na tym samym koncie co 2026-08-05.

### Dowód
Konto **`admin` ID 1** (`dev-email@wpengine.local`, relikt z Local by Flywheel) miało 3 aktywne sesje:

| Zalogowano (UTC) | IP | rDNS | UA |
|---|---|---|---|
| 2026-08-07 17:12 | 91.150.222.195 | `dynamic.play.pl` | Mac / Safari |
| 2026-08-10 02:44 | **34.70.236.161** | **`googleusercontent.com`** | Mac / Chrome |
| 2026-08-10 05:52 | **34.70.236.161** | **`googleusercontent.com`** | Windows / Chrome |

Dwa logowania z VM w Google Cloud, dwa różne user-agenty — automat. Zostawiły changesety Customizera (posty 689, 692) z payloadem `nav_menu_item` o tytule `proof` i URL `https://github.com/dinosn/wp2shell-lab` (publiczne repo do ćwiczenia przejmowania WP) plus dwa posty typu `request`/status `parse` (687, 690) z datą `2020-01-01`. Pozycja „proof" **nigdy nie była żywa w żadnym menu**.

### Czego NIE znaleziono
`wp core verify-checksums` czyste · brak PHP w `uploads/` · `mu-plugins` czyste · brak drop-inów · `.htaccess` standardowy · `git status` czysty · 2 konta, zero ukrytych ról · cron czysty · wtyczki tylko ACF Pro + Rank Math. **Brak trwałego backdoora.** Wektor najpewniej hasło konta `admin`.

### Containment (2026-08-11)
1. `wp user session destroy 1 --all` + `22 --all` → 0 sesji
2. `wp user update 1 --user_pass=<48 hex> --role=subscriber`
3. Rotacja 8 saltów w `.env` prod (`~/dp-rotate-salts.php`, backup `~/env-backup-meskistylista-20260811` chmod 600). Po rotacji `/`, `/baza-wiedzy/`, `/uslugi/`, `/blog/` → 200.

### Otwarte
- Artefakty 687, 689, 690, 692 **zostały w bazie** — inertne, stanowią dowód; do skasowania z wp-admin gdy trzeba.
- **Staging: to samo konto `admin` ID 1, i jest to jedyne konto tego środowiska** — nie degradować, tylko zmienić hasło. Staging czysty (0 sesji, 0 śladów).
- Rotacja hasła dhosting — otwarta od 2026-08-05. 2FA — brak.

### Przy okazji: strona /baza-wiedzy/
Trafiła do **kosza 2026-08-07 19:13:54** (czas warszawski). `_edit_lock` wskazywał ID 1, sesja z `dynamic.play.pl` zalogowana 19:12 → akcja ręczna z panelu, najpewniej samego usera. Na stagingu strona cały czas opublikowana.

Przywrócenie: `wp_untrash_post(234)` — **uwaga, wraca jako `draft`, nie `publish`** — potem `wp post update 234 --post_status=publish`. Pozycja menu 693 „Baza Wiedzy" wskazywała na Blog (256, ustawione przez usera 2026-08-10 13:43), przepięta na 234 przez `update_post_meta(693, '_menu_item_object_id', wp_slash('234'))`.

**Uwaga na przyszłość:** motyw linkuje na sztywno do `/baza-wiedzy/` w `nav-desktop.blade.php:189` i `nav-mobile.blade.php:257`. Jeśli ta strona kiedyś zniknie, oba linki prowadzą w 404 — warto to podpiąć pod ID strony albo dodać fallback.

---

## Sesja 2026-08-11 (cd.) — avatar autora na listingach + strona 404

### Avatar autora — dlaczego pokazywał szarą sylwetkę
Logika wyboru zdjęcia autora (ACF `author_photo` z profilu użytkownika → wspólny portret ID 42 „portret dominik" → Gravatar) siedziała **tylko** w `SinglePostComposer::authorPhoto()`. Przez to pojedynczy wpis pokazywał portret, a listingi leciały prosto na `get_avatar_url()` i renderowały domyślną sylwetkę Gravatara, bo konto autora nie ma zarejestrowanego Gravatara.

- **`app/Blog/Helpers.php`** — nowa funkcja `App\Blog\author_photo(int $authorId, string $size = 'medium')` + stała `FALLBACK_PORTRAIT_ID = 42` przeniesiona z composera. Obsługuje wszystkie formaty zwrotu ACF (Array / ID / URL).
- **`SinglePostComposer`** — metoda i stała usunięte, delegacja do helpera (`use function App\Blog\author_photo`).
- **`BlogArchiveBlockComposer`** — `get_avatar_url(…80)` → `author_photo($authorId, 'thumbnail')`.
- **`BlogBlockComposer`** — w ogóle nie przekazywał avatara ani roli autora; dodane `authorAvatar` + `authorRole`.
- **`blocks/blog.blade.php`** — karta dostaje `:authorAvatar` i `:authorRole`.

Zweryfikowane na prodzie: `/blog/` i strona główna renderują `…/uploads/2026/03/Strona-5-150x150.jpg`, Gravatar został już tylko w schema JSON-LD Rank Matha (to jego pole, nie nasze).

### Strona 404 i puste stany
Wzorowana na referencji od usera (screenshot z `miejskafala`): hero z H1, leadem, dwoma CTA i blokiem „Dokąd dalej", pod spodem karty usług.

- **`sections/not-found/hero.blade.php`** — przyjmuje `$heading`, `$lead`, `$primaryLabel`, `$primaryUrl` przez `@include(…, [...])`, więc jeden plik obsługuje 404, pustą wyszukiwarkę i pusty listing. „Dokąd dalej" bierze pozycje z `$primaryMenuItems`.
- **`sections/not-found/services.blade.php`** — `x-service-card variant="detailed"` z `$navServices`, grid `1 → md:2 → lg:4`. Bez `description`, bo wariant renderuje ją w `font-metro text-xs` (patrz `feedback_fonts` — metro nie nadaje się na wielolinijkowy tekst).
- **`404.blade.php`**, **`search.blade.php`**, **`index.blade.php`** — przepisane na te sekcje zamiast `x-alert` + gołego `get_search_form()`.
- **`NavigationComposer`** — do `$views` dopisane `sections.not-found.*`.

**Status HTTP zostaje 404** — świadomie bez auto-redirectu na stronę główną (soft 404 psuje sygnał dla Google i gubi usera).

### `app/redirects.php` — dopasowanie po slugu
Drugi hook `template_redirect` (priorytet 2, po mapie statycznej): jeśli 404 i ostatni segment ścieżki pasuje do opublikowanego wpisu (`post`, `page`, `service`, `guide`, `portfolio`) → 301 na jego permalink. Zabezpieczenia: pomija segmenty numeryczne i z kropką (pliki), oraz sprawdza czy cel nie jest tą samą ścieżką (pętla).

Zweryfikowane na prodzie: `/taka-strona-nie-istnieje-test-404/` → **404** z pełną nową stroną; `/?s=zzzqqqxxx` → „Nic nie znalazłem" + sekcje.

---

## Sesja 2026-08-11

### Zmiana treści na produkcji: rola autora
`wp_usermeta` → user ID 1 → ACF `author_role`: „Stylista Modivo" → **„Osobisty Stylista od 2020"**. Zmiana wykonana przez `wp search-replace --all-tables --precise` na prodzie (1 trafienie w całej bazie), potem `acorn view:clear` + `cache flush`. Zweryfikowane na `/blog/` — renderuje się w `x-blog-card`.

**Nie zrobione:** staging (komenda blokowana przez uprawnienia — do odpalenia ręcznie) i lokal (Local nie był uruchomiony).

Uwaga: na stronie „O mnie" (ID 440) zostaje osobna wzmianka „Modivo" — to nazwa logotypu klienta w bloku logos (`logos_items_3_name` + załącznik ID 456). Świadomie nietknięta.

### Formularz kontaktowy — opcjonalne pole telefonu
Powód: ludzie piszą mailem, ale szybciej odpowiedzieć SMS-em, jeśli zostawią numer.

- **`blocks/contact.blade.php`** — nowe pole między E-mailem a Wiadomością. `type="tel"`, `inputmode="tel"`, `autocomplete="tel"`, `maxlength="30"`, **bez `required`**. Ramka z `<x-icons.phone>` w środku, spójna z polem E-mail (`focus-within:border-primary`). Pod polem hint „Zostaw numer, jeśli wolisz odpowiedź SMS-em." powiązany przez `aria-describedby`.
- **`js/components/contact-form.js`** — `phone` czytany przez `?.` (formularz działa też bez tego pola) i dokładany do payloadu. Celowo **bez walidacji blokującej po stronie klienta** — pole opcjonalne, nie chcemy odbijać usera literówką.
- **`Booking/ContactApi.php`** — `$phone` sanitowany + trim. Walidacja odpala się **tylko gdy pole niepuste**: dozwolone `[0-9+\-\s()]`, min 9 cyfr po odfiltrowaniu nie-cyfr, max 30 znaków → inaczej 400 „Nieprawidłowy numer telefonu.". W mailu powiadomienia dochodzi `<li>` z klikalnym `tel:` (link czyszczony do `[^0-9+]`), pomijany gdy numer pusty.

Przetestowane przypadki: `+48 500 600 700`, `500600700`, `500-600-700`, `(12) 345 67 89` → OK; `123`, `abc123456789`, `500600700; DROP`, numer >30 znaków → odrzucone.

**Status:** na `develop` + `staging`, zbudowane na serwerze, zweryfikowane w HTML na `dominikpakula.wdb-creative.pl/kontakt/`. **Na produkcję niewypchnięte.**

### Deploy na produkcję
Formularz z polem telefonu wdrożony na `main` + build na serwerze. Zweryfikowane w HTML na `meskistylista.pl/kontakt/`.

### Dokumenty prawne — uzupełnione na produkcji
Polityka prywatności (ID 3) i Regulamin (ID 379) zaktualizowane bezpośrednio w bazie prod przez `wp eval-file` + `wp_slash()`. Podmiany robione skryptem z asercjami (każda musiała trafić dokładną liczbę razy, inaczej przerwanie bez zapisu) — 14 podmian, wszystkie potwierdzone. Kopie oryginałów: patrz historia rewizji WP.

**Poprawione rozbieżności ze stanem faktycznym:**
- E-mail `kontakt@dominikpakula.pl` → `kontakt@meskistylista.pl` (2 miejsca w polityce, 8 w regulaminie)
- Telefon `+48 884 826 068` → `+48 577 190 949` (zgodnie z tym co widnieje na stronie)
- Domena `dominikpakula.pl` → `meskistylista.pl` (§ 2 polityki, § 1.1 i link do polityki w regulaminie)

**Uzupełnione placeholdery:**
- § 5 polityki lit. a i b — hosting i poczta: dhosting.pl Sp. z o.o., ul. Pamiętna 14B/2, 02-972 Warszawa, KRS 0000336780, NIP 7010198361. Zweryfikowane: MX wskazuje `dpoczta.pl`, SPF `include:_mail.dhosting.pl`
- § 5 lit. e — **dodane Brevo** (wcześniej w ogóle nie było, mimo że newsletter przez nie leci)
- § 5 lit. f — system rezerwacji: własny, w ramach Serwisu, bez zewnętrznego dostawcy kalendarza
- § 4 polityki — nowy ustęp o dobrowolności numeru telefonu (art. 6 ust. 1 lit. b i f RODO)
- § 7.4 regulaminu — ważność Vouchera: **12 miesięcy**
- § 13.1 regulaminu — obowiązuje od **11 sierpnia 2026 r.**
- **Załącznik nr 1 do regulaminu** — wzór formularza odstąpienia. § 8 ust. 2 się na niego powoływał, ale dokument go nie zawierał

### Zgoda RODO jako dowód w mailu
Wcześniej mail miał tylko szary drobny druk „GDPR zaakceptowane: <data>". RODO art. 7 ust. 1 wymaga wykazania **na co** użytkownik się zgodził, więc sam fakt nie wystarcza.

- **`app/Booking/Consent.php`** (nowy) — kanoniczna treść zgody w trzech wariantach: `contact_consent_template()` (szablon z `%s` na link), `contact_consent_html()` (dla widoku, z klikalnym linkiem), `contact_consent_plain()` (dla maila, z rozwiniętym URL-em). Jedno źródło prawdy — formularz i archiwum mailowe nie mogą się rozjechać.
- **`ContactBlockComposer`** (nowy) — podaje `$gdprConsent` do `blocks.contact`. Widok przestał hardkodować tekst zgody.
- **`ContactApi`** — wiersz „Zgoda RODO: TAK — udzielona <data>" w podsumowaniu + osobna sekcja „Zgoda na przetwarzanie danych" z dokładną treścią checkboxa, datą, IP i adresem strony (Referer, opisany jako deklaracja przeglądarki, nie dowód).

Przetestowane na stagingu przez `wp eval-file` z przechwyceniem `pre_wp_mail` (żaden mail nie wyszedł): z numerem → 200 z pełną sekcją zgody; bez numeru → 200, wiersz telefonu pominięty, sekcja zgody obecna; numer `123` → 400; brak zgody → 400; 4. próba w 10 min → 429 (rate limiter).

### Do zrobienia
- [ ] **Adres do korespondencji** — jedyny placeholder jaki został. 3 miejsca: § 1 polityki, § 1.3 regulaminu, Załącznik nr 1. Wymagany przez ustawę o prawach konsumenta, user zdecydował zostawić na później
- [ ] **Polityka opisuje narzędzia, których nie ma** — § 5 lit. c/d, § 8 i § 9 opisują Google Analytics 4, Google Ads, GTM i Cookiebot. Produkcyjny HTML nie ładuje ani jednego zewnętrznego skryptu. User świadomie zostawił te zapisy, bo planuje wdrożyć analitykę — do domknięcia razem z bannerem zgód
- [ ] Brevo w § 5 wpisane bez pełnych danych rejestrowych — nie udało się ich pobrać z oficjalnych stron Brevo, do uzupełnienia
- [ ] Staging ma dalej starą rolę autora („Stylista Modivo") — komenda blokowana przez uprawnienia

---

## Sesja 2026-08-12 — Google Tag Manager + zdarzenia konwersji

### Decyzja: bez wtyczki GTM4WP
GTM4WP zarabia na siebie przy WooCommerce / Contact Form 7 / Gravity Forms — automatycznie wypycha ich zdarzenia do dataLayer. Tu nie ma żadnego z nich: rezerwacja, voucher, kontakt i newsletter to własny kod REST (`app/Booking/*` + `resources/js/components/*`), o którym wtyczka nic nie wie. Zostałby z niej sam snippet kontenera plus ekran ustawień klikany ręcznie w adminie (poza gitem, niedeployowalny) i kolejna powierzchnia ataku — po dwóch incydentach przejęcia admina argument nie kosmetyczny. Scroll depth i kliknięcia `tel:`/`mailto:` ogarniają wbudowane triggery GTM.

### ID kontenera przez .env (wzorzec Brevo)
- `config/application.php` — `Config::define('GTM_CONTAINER_ID', env('GTM_CONTAINER_ID') ?: '')`
- `.env.example` — nowa sekcja z opisem
- `.env` (lokalny) — wpis zakomentowany, do odkomentowania przy testach
- Kontener produkcyjny: **GTM-PQPMDHS4**. Puste ID = kod całkowicie uśpiony (wyłącznik awaryjny). Każde środowisko ma własną wartość, więc staging może mieć inny kontener albo żaden.

### `app/analytics.php` (nowy, wpięty w `functions.php` po `security`)
- Snippet w `wp_head` **priorytet 1** + `<noscript>` w `wp_body_open` priorytet 1 (layout ma `wp_body_open()` w pierwszej linii `<body>`).
- **Nie ładuje się** gdy: brak/zły format ID, `is_admin`, AJAX, cron, REST, `is_preview`, `is_customize_preview`, oraz dla zalogowanych z `edit_posts` (redakcja nie zaśmieca statystyk). Zalogowany subskrybent jest liczony normalnie.
- Decyzja `should_load()` memoizowana w statycznej — head i body muszą odpowiedzieć tak samo, inaczej powstałby osierocony `<noscript>`.
- Walidacja ID regexem `/^GTM-[A-Z0-9]{4,}$/` — wartość trafia wprost do stringa w `<script>`. Odrzuca m.in. `GTM-X');alert(1)//`.
- Kontekst strony wypychany do dataLayer **przed** snippetem (po starcie kontenera push nie zasili zmiennych czytanych przy inicjalizacji tagów): `pageType`, `postId`, `postType`, `postTitle`, `postCategory`, `postAuthor`, `isLoggedIn`. JSON kodowany z `JSON_HEX_TAG`, więc `</script>` w tytule wpisu nie rozerwie bloku.

### Consent Mode — obsługuje Cookiebot, nie my
Świadomie **nie** wypisujemy własnych `gtag('consent','default',…)`. Cookiebot ma wejść jako tag **wewnątrz** kontenera GTM (trigger „Consent Initialization – All Pages"). Dwa źródła defaultów potrafią się nadpisać i skończyć zgodą, której użytkownik nie dał.

**Jeśli kiedyś Cookiebot wjedzie własnym `<script>` w `<head>` zamiast przez GTM — musi być WYŻEJ niż nasz snippet**, czyli trzeba podbić priorytet hooka `wp_head` w `analytics.php` powyżej priorytetu Cookiebota.

### `resources/js/lib/analytics.js` (nowy)
`pushEvent(name, params)` — jedyne miejsce dotykające `window.dataLayer`. Pomija puste wartości, żeby w GA4 nie lądowały wymiary „undefined". Nie sprawdza zgody sam — push do dataLayer niczego nie śledzi, decyzję podejmują tagi GTM + Cookiebot.

### Zdarzenia wpięte w istniejące komponenty
| Plik | Zdarzenia | Parametry |
|---|---|---|
| `booking.js` | `booking_start`, `booking_service_selected`, `booking_date_selected`, **`booking_submit`** | `service`, `date`, `entry_point` (`usluga`/`ogolne`) |
| `voucher.js` | `voucher_start`, `voucher_service_selected`, `voucher_recipient_filled`, **`voucher_submit`** | `service`, `price` |
| `contact-form.js` | **`contact_submit`** | `form_id`, `has_phone` |
| `newsletter-form.js` | **`newsletter_signup`** | `placement` |

Pogrubione = konwersje. Wszystkie odpalają się **po potwierdzeniu z serwera**, nie na kliknięcie — samo „Wyślij" mogło polec na walidacji albo rate limiterze.

Przy okazji: `data-newsletter` dostało wartości (`blok-newsletter`, `blog-wpis`) — wcześniej był to goły atrybut, teraz zasila parametr `placement`.

### Weryfikacja
- `php -l` czysty na `analytics.php` i `application.php` (PHP z Local: `%APPDATA%\Local\lightning-services\php-8.2.27+1\bin\win32\php.exe` — `php` nie jest w PATH).
- `npm run build` przechodzi (29 modułów, `app-DtrGYURt.js` 33.33 kB).
- Snippet uruchomiony na stubach WP poza WordPressem — wyjście bajt w bajt zgodne z oryginałem od Google, walidacja ID odrzuca wstrzyknięcia.
- Local nie był uruchomiony, więc render sprawdzony dopiero na produkcji (niżej).

### Deploy na produkcję (2026-08-12) — ZROBIONE
`develop` a7c973c → `staging` a84fb9a → `main` f5d0e57, pull + `npm run build` na serwerze (Node 20.20.0), `acorn view:clear` + `cache flush` (zmieniły się 2 pliki Blade).

`.env` na prodzie: dopisane `GTM_CONTAINER_ID=GTM-PQPMDHS4` (linia 27, uprawnienia 640). Backup przed zmianą: `~/env-backup-meskistylista-20260812` chmod 600.

**Zweryfikowane na żywym HTML meskistylista.pl:**
- Snippet to **pierwszy skrypt w `<head>`** (linie 7–14, przed `<title>`), `<noscript>` w linii 81 zaraz po `<body>` z linii 79
- Bundle `app-DtrGYURt.js` (hash identyczny z lokalnym) zawiera wszystkie 10 nazw zdarzeń
- dataLayer na stronie głównej: `pageType: front_page`, postId 6
- dataLayer na wpisie: `pageType: single`, postId 610, `postCategory: Moda`, autor OK
- 404 raportuje `pageType: not_found` (sprawdzone przypadkiem na `/author/`, zablokowanym przez `security.php`)
- **Staging: 0 trafień `googletagmanager`** — kontener się tam nie ładuje, bo staging `.env` nie ma zmiennej. Izolacja środowisk potwierdzona, prod śledzi sam siebie.

### Do zrobienia
- [ ] Cookiebot: tag CMP w GTM na triggerze „Consent Initialization – All Pages"
- [ ] W GTM: tag GA4 Configuration + 4 triggery Custom Event na konwersje + tagi GA4 Event; w GA4 oznaczyć jako kluczowe zdarzenia
- [ ] Zmienne dataLayer w GTM dla `pageType`, `postCategory`, `service`, `placement` (Data Layer Variable)
- [ ] Sprawdzić Tag Assistantem: snippet w `<head>`, `<noscript>` zaraz po `<body>`, zdarzenia lecą po sukcesie formularza
- [ ] Po uruchomieniu analityki polityka prywatności przestaje kłamać w § 5 lit. c/d, § 8, § 9 — zweryfikować czy zapisy zgadzają się ze stanem faktycznym (Cookiebot tak, Google Ads na razie nie)

## Sesja 2026-08-27 — lookbook: podgląd pustego bloku w edytorze + wybór strony dużego zdjęcia

### Problem
Blok `lookbook-section` przy pustych polach nie renderował nic (bloki mają `mode => 'preview'`),
więc w edytorze był pustym obszarem — do formularza dało się dostać dopiero ołówkiem na pasku bloku.
Dodatkowo layout `split` miał duże zdjęcie zabetonowane po lewej.

### Zrobione
- **Nowy komponent `components/block-placeholder.blade.php`** — kafelek z przerywaną ramką: nazwa bloku,
  podpowiedź i opcjonalny slot na szkielet layoutu. Reużywalny, do wykorzystania w kolejnych blokach.
- **Nowy partial `blocks/partials/lookbook-skeleton.blade.php`** — szare prostokąty odwzorowujące
  ten sam grid co realny render (`grid-3` / `grid-4` / `split`), z uwzględnieniem strony dużego zdjęcia.
- **`app/blocks.php`** — `render_callback` przyjmuje teraz `$isPreview` (ACF podaje flagę TRZECIM ARGUMENTEM,
  nie w tablicy `$block`) i normalizuje ją do `$block['preview']`. Zmiana globalna dla wszystkich bloków —
  każdy widok/composer ma odtąd jedno miejsce na sprawdzenie „czy renderuję w edytorze".
- **`LookbookSectionBlockComposer`** — nowe klucze `isEmpty`, `isPreview`, `featuredFirst`;
  wyliczanie layoutu wyniesione do `layout()`.
- **`blocks/lookbook-section.blade.php`** — gałąź pustego bloku (placeholder tylko w edytorze, front bez zmian)
  + `lg:order-1` / `lg:order-2` na kolumnach layoutu `split`. Na mobile duże zdjęcie zawsze pierwsze.

### Pole ACF do utworzenia ręcznie w panelu
| Nazwa pola | Typ | Wartości | Default | Warunek |
|---|---|---|---|---|
| `lookbook_featured_position` | Button Group | `left : Po lewej`, `right : Po prawej` | `left` | pokaż gdy `lookbook_layout` = `split` (lub `grid-5`) |

Composer traktuje wszystko poza jawnym `right` jako lewą stronę, więc **brak pola nie psuje istniejących wpisów**.

### Weryfikacja
- `php -l` czysty na `app/blocks.php` i `LookbookSectionBlockComposer.php` (PHP 8.5 z Local).
- Wszystkie 3 szablony Blade skompilowane przez `BladeCompiler::compileString()` + `php -l` na wyjściu — bez błędów.
- `npm run build` przechodzi; sprawdzone, że `editor.css` zawiera użyte utilities
  (`aspect-[4/5]`, `lg:order-1/2`, `min-h-[64px]`, `border-dashed`, `bg-black/[0.02]`, `text-black/70`).
- **Uwaga:** `editor.css` kompiluje własny Tailwind BEZ tokenów z `@theme` (są tylko w `app.css`),
  więc `font-poppins` i `not-prose` w edytorze NIE istnieją. Placeholder używa gołych utilities,
  a tekst siedzi w `span` (nie `p`), bo `.editor-styles-wrapper p` nadpisałoby rozmiary.
- Cache skompilowanych widoków wyczyszczony (`app/public/app/cache/acorn/framework/views`).
- **Local nie był uruchomiony** — render w edytorze do sprawdzenia po starcie strony.

### Deploy na produkcję (2026-08-27) — ZROBIONE
`develop` 504699a → `staging` 35faec2 → `main` ea9ab81, push origin, na serwerze `git pull`
+ `npm run build` (Node 20.20.0, nowe hashe: `editor-DiVlTR1T.css`, `app-MjUv3vzt.css`)
+ `wp acorn view:clear` + `wp cache flush`.

Zweryfikowane na żywej produkcji: `/`, `/blog/`, `/uslugi/` → 200; w `editor-DiVlTR1T.css`
obecne `lg:order-1`, `lg:order-2`, `border-dashed`, `aspect-[4/5]`, `bg-black/[0.02]`, `grid-rows-2`.

Deploy **nie** obejmuje pola ACF — `lookbook_featured_position` trzeba założyć ręcznie w panelu prod,
inaczej przełącznika lewo/prawo nie widać (kod leci wtedy na default = lewa, czyli bez zmian).

### Poprawka 2026-08-27 (druga tura) — `grid-5-right` zamiast osobnego pola

Osobne pole `lookbook_featured_position` wymagało ręcznego założenia w panelu, więc w praktyce
przełącznika nie było widać. Zamiast tego **druga opcja w istniejącym dropdownie `lookbook_layout`**:

| Wartość | Znaczenie |
|---|---|
| `grid-3` | siatka 3 kolumny |
| `grid-4` | siatka 4 kolumny |
| `grid-5` | 1 duże + 2x2, duże zdjęcie po **lewej** |
| `grid-5-right` | 1 duże + 2x2, duże zdjęcie po **prawej** |

Composer: `layout()` mapuje `grid-5` ORAZ `grid-5-right` na `split`; `featuredFirst()` zwraca false
tylko dla `grid-5-right`. Opcjonalne pole `lookbook_featured_position` jest dalej honorowane,
gdyby kiedyś powstało — ale nie istnieje i nic nie robi.

**Pole ACF zmienione przez WP-CLI na produkcji** (`acf_update_field` na `field_69f1b8a14e1e8`,
grupa „LookBook" `group_69f1b8816b165`, post 277): dodany choice `grid-5-right` + czytelne etykiety
dla pozostałych. Wartości `grid-3`/`grid-4`/`grid-5` bez zmian, więc istniejące wpisy nietknięte.
Zapis zweryfikowany w świeżym procesie wp-cli (deserializuje się, polskie znaki całe).

Deploy: `develop` e4b5d9b → `staging` f855722 → `main` 98aaf51, pull + `acorn view:clear` + `cache flush`
(bez `npm run build` — zmiana czysto PHP, zero nowych klas Tailwind).

Zweryfikowane na żywej produkcji: wpis „Przegląd nowości z sieciówek – jesień #1" ma 4 lookbooki
w układzie split, wszystkie bez klas `lg:order-*` = duże zdjęcie po lewej, czyli jak przed zmianą.

**Staging ma osobną bazę — tam choice `grid-5-right` NIE został dodany.**

### Poprawka 2026-08-27 (trzecia tura) — nowy layout `grid-6`

Mozaika 6 zdjęć z referencji (screenshot od usera): 2 kolumny płynące **niezależnie**,
duże kadry po przekątnej. Wiersze celowo NIE są wyrównane.

```
LEWA           PRAWA
┌─────────┐    ┌───┐ ┌───┐
│    1    │    │ 4 │ │ 5 │
│  (duże) │    └───┘ └───┘
│         │    ┌─────────┐
└─────────┘    │    6    │
┌───┐ ┌───┐    │  (duże) │
│ 2 │ │ 3 │    │         │
└───┘ └───┘    └─────────┘
```

- Duże: `aspect-[2/3]` (wyższe niż `4/5` w split). Małe: `aspect-[3/4]`.
- Kolejność w repeaterze **kolumnami**: 1-3 lewa kolumna, 4-6 prawa (decyzja usera).
- Nowy partial `blocks/partials/lookbook-grid-6.blade.php` — blok się nie rozrasta.
- Gałąź w `lookbook-section` wymaga **min. 6 zdjęć**, inaczej spada na `grid-3`
  (analogicznie do `split` przy < 2) — niedokończony blok się nie rozjeżdża.
- `lookbook-skeleton` dostał wariant `grid-6` dla podglądu pustego bloku.
- Mobile: jedna kolumna, kolejność duże → para → para → duże.
- Wariant odbity `grid-6-right` **świadomie pominięty** — user zdecydował „na razie tylko grid-6".

Deploy: `develop` e966cfa → `staging` ea5caa8 → `main` 40f0b52, pull + `npm run build`
(nowa klasa `aspect-[2/3]`, więc build KONIECZNY) + `acorn view:clear` + `cache flush`.
Nowe assety: `editor-CsJw_yUA.css`, `app-CQyTf_cj.css`.

Choice `grid-6` dopisany do pola ACF przez WP-CLI na prodzie. Pełna lista wartości
`lookbook_layout`: `grid-3`, `grid-4`, `grid-5`, `grid-5-right`, `grid-6`.

Zweryfikowane: `/` i wpis z lookbookami → 200, `aspect-[2/3]` obecne w żywym `editor.css`.

### Staging dociągnięty (2026-08-27) — ZROBIONE

Staging stał na `50641e6` (sprzed GTM), **18 commitów w tyle**. Pull + `npm run build`
(Node 20.20.0, hashe identyczne z prodem: `editor-CsJw_yUA.css`, `app-CQyTf_cj.css`)
+ `acorn view:clear` + `cache flush`. HEAD: `9c431eb`.

Choices `grid-5-right` i `grid-6` dopisane do `field_69f1b8a14e1e8` (ten sam klucz co na prodzie,
bo baza prod powstała z importu stagingu). Zweryfikowane w świeżym procesie wp-cli.
Smoke test: `/` i `/blog/` → 200, `aspect-[2/3]` w żywym `editor.css`.

**⚠️ Serwer stagingowy ma LOKALNE, niezacommitowane zmiany** w `composer.json`, `composer.lock`
i `package-lock.json` — z `composer.json` usunięty jest `wpengine/advanced-custom-fields-pro`
(stary workaround na limit aktywacji ACF). Pull ich nie dotknął i **nie wolno ich zresetować**,
bo `composer install` zacznie się wykrackać na 402 activation_limit.

### Do zrobienia
- [ ] Wstawić grid-6 na realnym wpisie i sprawdzić proporcje kadrów (2/3 i 3/4 są do strojenia)
- [ ] Sprawdzić w edytorze prod: placeholder pustego bloku + przełączenie lookbooka na `grid-5-right`
- [ ] Rozważyć `mode => 'auto'` dla lookbooka (klik w blok otwiera formularz zamiast ołówka) —
      wymaga per-blokowego nadpisania `mode` w pętli rejestracji w `app/blocks.php`
- [ ] Placeholder w pozostałych blokach (komponent jest już gotowy)

