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

## Custom Taxonomies (1)
| Taxonomia | Slug | Powiązana z | Plik | Opis |
|-----------|------|-------------|------|------|
| Sezony | season | post (blog) | Taxonomies/Season.php | Hierarchiczna, /sezon/, dla filtra blog-archive |

## Szablony stron
| Szablon | Plik | Opis |
|---------|------|------|
| Front Page | template-front-page.blade.php | Strona główna (the_content z blokami) |
| Strona z blokami | template-blocks.blade.php | Podstrony bez tytułu (Usługi, Voucher, Baza Wiedzy, Blog) |
| Single Service | single-service.blade.php | Pojedyncza usługa (grid 7fr/3fr + sticky sidebar) |
| Single Post | single-post.blade.php | Pojedynczy wpis blogowy (z TOC, share, prev/next, autor, related) |

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

## Komponenty Blade (12)
| Komponent | Plik | Opis |
|-----------|------|------|
| Alert | components/alert.blade.php | Komponent alertu |
| Badge | components/badge.blade.php | Reużywalny badge z border |
| Blog Card | components/blog-card.blade.php | + propsy: category, authorAvatar, authorRole, withShadow, hover zoom obrazu |
| Button | components/button.blade.php | Primary/secondary, lg/sm, z ikoną |
| Eyebrow | components/eyebrow.blade.php | Mały label nad tytułami |
| Gift Banner | components/gift-banner.blade.php | Banner "Pomysł na prezent" |
| Portfolio Card | components/portfolio-card.blade.php | Karta realizacji |
| Section | components/section.blade.php | Wrapper sekcji z paddingami |
| Service Card | components/service-card.blade.php | 3 warianty + hover lift/shadow + ikona aspect-fit (h-20 w-auto self-start) |
| Testimonial Card | components/testimonial-card.blade.php | Karta opinii (zdjęcie/wideo) |
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
- [x] **Pola ACF service — W cenie znajdziesz** ✅ (2026-04-29) — service_included_heading, service_included_items (repeater)
- [ ] **Pola ACF Single Portfolio** — `portfolio_intro` (Textarea), `portfolio_gallery` (Gallery, Array), `portfolio_category` (sprawdzić istnienie). Lokalizacja: Post Type → Realizacja
- [ ] **Pełna strona Kontakt** ✅ — wszystkie bloki (page-header, contact-bar, personal-intro, contact-channels, next-steps, contact form, testimonials, subscribe) wstawione na stronie ID 270 (sezon 3, 2026-04-23/04-28)
- [ ] **service-desc rebuild** ✅ — editorial layout 3 sekcje stackowane na szarym tle (sezon 3)
- [ ] **Sidebar single-service wzbogacony** ✅ — W cenie znajdziesz + Opinia klienta + Sprawdź też inne usługi (sezon 3)
- [ ] **Refaktor hardcodów na ACF** — patrz sekcja "Hardcode w blokach (do przepisania na dynamiczne ACF)" niżej. Priorytet: Options Page → service-desc repeatery → service_included_items → personal-intro
- [ ] **Utworzyć WP menu i przypisać do "Footer Navigation"** (Wygląd → Menu) — bez tego kolumna "Nawigacja" w stopce się ukrywa
- [ ] **Polityka prywatności** + **Regulamin** — strony prawne (footer linki obecnie w 404)
- [ ] Podstrony "O mnie", "Kontakt"
- [ ] Eksport pól ACF do JSON (po stworzeniu Options Page i `author_role`)
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
- [x] `author_role` (Text, np. "Stylista Modivo") — utworzone lokalnie 2026-04-22, **na staging do zrobienia**

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
Po przebudowie sezon 3 — editorial layout, 3 sekcje stackowane (TAK / POLECAM / RACZEJ NIE) z hardcodem w composerze.
- [ ] `desc_label` (Text, fallback "Dla kogo")
- [ ] `desc_heading` (Text, fallback "Czy ta usługa jest dla Ciebie?")
- [ ] `desc_positive_eyebrow` / `desc_positive_title` (Text — eyebrow i title sekcji "Tak")
- [ ] `desc_highlight_eyebrow` / `desc_highlight_title` (Text — sekcji "Polecam")
- [ ] `desc_negative_eyebrow` / `desc_negative_title` (Text — sekcji "Raczej nie")
- *(opcjonalnie 3 repeatery `desc_positive_items` / `desc_highlight_items` / `desc_negative_items` per usługa — obecnie wszystkie listy hardcoded w `ServiceDescBlockComposer::positiveItems()/highlightItems()/negativeItems()`. Per CPT service ma sens jeśli każda usługa ma inne kryteria 'dla kogo')*

### Grupa: **Usługa** (lokalizacja: `Post Type is equal to service`) — rozszerzona w sezonie 3
Pola dodatkowe do tych co już istnieją (service_sidebar_title/description/price/tags):
- [ ] `service_included_heading` (Text, fallback "W cenie znajdziesz")
- [ ] `service_included_items` (Repeater) z polem `service_included_item` (Text) — checklista co klient dostaje za cenę. Per usługa może być inna lista. Obecnie 4 hardcoded fallback w `ServiceComposer::includedItems()`.

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
- [ ] Eksport ACF JSON z lokalu → import na staging (po utworzeniu wszystkich field groups powyżej)

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
- Staging: ⏳ ACF field group "Profil autora" (eksport JSON z lokalu → import na staging)
- Staging: ⏳ WP Menu "Stopka" przypisany do "Footer Navigation"
- Oba: ⏳ Logo w Wygląd → Konfigurator → Tożsamość witryny

## Zasady pracy
- ACF pola tworzone ręcznie w panelu WP, nie kodem PHP
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
