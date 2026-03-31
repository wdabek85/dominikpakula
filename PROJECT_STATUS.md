# Project Status — dominikpakula

## Stack
- Bedrock 1.30.0 (web root zmieniony na `public/` dla Local by Flywheel)
- Sage 11.0.3 (motyw: `dominikpakula`)
- Acorn v5.1.0 (tylko w Sage, usunięty z Bedrocka)
- WordPress 6.9.4
- PHP 8.5.1 (Local)
- Node 24.11.1
- Tailwind CSS v4 (konfiguracja przez @theme w app.css)
- Tailwind Typography (@tailwindcss/typography) — klasy `prose` do WYSIWYG
- ACF Pro (aktywny)
- Rank Math (zainstalowany)

## Design tokens
- Max-width: 1440px
- Primary color: #282435
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
├── blocks/                               ← ACF Blocks
│   ├── hero.blade.php
│   ├── video.blade.php
│   ├── blog.blade.php
│   ├── contact.blade.php
│   ├── newsletter.blade.php
│   ├── voucher.blade.php
│   ├── service-desc.blade.php            ← Opis Usługi / Dla Kogo
│   ├── service-what.blade.php            ← Opis Usługi / Co Dostaniesz
│   ├── service-why.blade.php             ← Opis Usługi / Dlaczego Warto
│   ├── service-process.blade.php         ← Opis Usługi / Proces Współpracy
│   ├── service-faq.blade.php             ← Opis Usługi / FAQ (accordion)
│   ├── subpage-hero.blade.php            ← Hero Podstrona (2 zdjęcia + tytuł)
│   ├── services/
│   │   ├── index.blade.php
│   │   └── highlight-card.blade.php
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
│   │   ├── nav-desktop.blade.php         ← mega-menu (lista + podgląd)
│   │   └── nav-mobile.blade.php          ← 3-panelowe slide menu
│   ├── footer.blade.php
│   ├── sidebar.blade.php
│   └── service/                          ← partiale szablonu usługi
│       ├── breadcrumbs.blade.php
│       ├── header.blade.php
│       ├── sidebar.blade.php
│       └── testimonials.blade.php
├── components/
│   ├── alert.blade.php
│   ├── badge.blade.php                   ← reużywalny badge (border, Poppins semibold)
│   ├── blog-card.blade.php
│   ├── button.blade.php
│   ├── gift-banner.blade.php             ← banner "Pomysł na prezent" (hardcode)
│   ├── portfolio-card.blade.php
│   ├── section.blade.php
│   ├── service-card.blade.php            ← 3 warianty: default/compact/detailed
│   ├── testimonial-card.blade.php
│   ├── video-section.blade.php
│   └── icons/
│       ├── arrow-long-right.blade.php
│       ├── arrow-right.blade.php
│       ├── arrow-up-right.blade.php
│       ├── chevron-down.blade.php
│       ├── chevron-right.blade.php
│       ├── facebook.blade.php
│       ├── instagram.blade.php
│       ├── menu-icon.blade.php
│       ├── phone.blade.php
│       ├── play-circle.blade.php
│       ├── tiktok.blade.php
│       └── x-mark.blade.php
├── partials/
│   ├── comments.blade.php
│   ├── content.blade.php
│   ├── content-page.blade.php
│   ├── content-search.blade.php
│   ├── content-single.blade.php
│   ├── entry-meta.blade.php
│   └── page-header.blade.php
├── forms/
│   └── search.blade.php
├── 404.blade.php
├── index.blade.php
├── page.blade.php
├── search.blade.php
├── single.blade.php
├── single-service.blade.php              ← szablon usługi (7fr/3fr grid + sticky sidebar)
├── template-blocks.blade.php             ← szablon "Strona z blokami" (bez tytułu)
├── template-custom.blade.php
├── template-front-page.blade.php

app/
├── blocks.php                            ← rejestracja ACF Blocks (18 bloków)
├── setup.php
├── filters.php
├── PostTypes/
│   ├── Testimonial.php
│   ├── Portfolio.php
│   └── Service.php                       ← CPT "Usługi" (/uslugi/)
├── Providers/
│   └── ThemeServiceProvider.php
├── View/Composers/
│   ├── App.php
│   ├── Comments.php
│   ├── Post.php
│   ├── HeroComposer.php
│   ├── VideoBlockComposer.php
│   ├── ServicesBlockComposer.php
│   ├── OfferBlockComposer.php            ← obsługuje wariant kart (compact/detailed)
│   ├── ProcessBlockComposer.php
│   ├── TestimonialsBlockComposer.php
│   ├── PortfolioBlockComposer.php
│   ├── BlogBlockComposer.php
│   ├── VoucherBlockComposer.php
│   ├── ServiceComposer.php               ← dane ACF dla single-service
│   ├── ServiceTestimonialsComposer.php   ← 3 ostatnie opinie (bez ACF)
│   ├── ServiceDescBlockComposer.php
│   ├── ServiceWhatBlockComposer.php
│   ├── ServiceWhyBlockComposer.php
│   ├── ServiceProcessBlockComposer.php
│   ├── ServiceFaqBlockComposer.php
│   ├── SubpageHeroBlockComposer.php
│   └── NavigationComposer.php            ← pobiera usługi z CPT dla mega-menu

resources/js/
├── app.js
├── editor.js
└── components/
    ├── mobile-menu.js                    ← 3-panelowe slide menu
    ├── mega-menu.js                      ← desktop mega-menu (hover, detail switch)
    ├── faq-accordion.js                  ← accordion toggle
    ├── lite-youtube.js
    ├── testimonial-video.js
    ├── drag-scroll.js
    └── slider-arrows.js

resources/css/
├── app.css                               ← Tailwind v4 + @theme + typography plugin
└── editor.css
```

## ACF Blocks — zarejestrowane (18 bloków)
| Blok | Widok | Composer | Status |
|------|-------|----------|--------|
| Hero | blocks.hero | HeroComposer | Gotowy |
| Video | blocks.video | VideoBlockComposer | Gotowy |
| Usługi | blocks.services.index | ServicesBlockComposer | Gotowy |
| Oferta | blocks.offer.index | OfferBlockComposer | Gotowy (wariant compact/detailed) |
| Proces | blocks.process.index | ProcessBlockComposer | Gotowy |
| Opinie | blocks.testimonials.index | TestimonialsBlockComposer | Gotowy |
| Portfolio | blocks.portfolio.index | PortfolioBlockComposer | Gotowy |
| Voucher | blocks.voucher | VoucherBlockComposer | Gotowy |
| Blog | blocks.blog | BlogBlockComposer | Gotowy |
| Newsletter | blocks.newsletter | — | Gotowy |
| Kontakt | blocks.contact | — | Gotowy |
| Opis Usługi / Dla Kogo | blocks.service-desc | ServiceDescBlockComposer | Gotowy |
| Opis Usługi / Co Dostaniesz | blocks.service-what | ServiceWhatBlockComposer | Gotowy |
| Opis Usługi / Dlaczego Warto | blocks.service-why | ServiceWhyBlockComposer | Gotowy |
| Opis Usługi / Proces Współpracy | blocks.service-process | ServiceProcessBlockComposer | Gotowy |
| Opis Usługi / FAQ | blocks.service-faq | ServiceFaqBlockComposer | Gotowy |
| Hero Podstrona | blocks.subpage-hero | SubpageHeroBlockComposer | Gotowy |

## Custom Post Types (3)
| CPT | Slug | Plik | Opis |
|-----|------|------|------|
| Opinie | testimonial | PostTypes/Testimonial.php | Opinie klientów (non-public) |
| Realizacje | portfolio | PostTypes/Portfolio.php | Portfolio prac (public, /realizacje/) |
| Usługi | service | PostTypes/Service.php | Usługi (public, /uslugi/, editor+thumbnail) |

## Szablony stron
| Szablon | Plik | Opis |
|---------|------|------|
| Front Page | template-front-page.blade.php | Strona główna (the_content z blokami) |
| Strona z blokami | template-blocks.blade.php | Podstrony bez tytułu (np. Usługi) |
| Single Service | single-service.blade.php | Pojedyncza usługa (grid 7fr/3fr + sticky sidebar) |

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
- Dane z NavigationComposer (CPT service)

### Mobile
- 3-panelowe slide menu:
  1. Menu główne → klik "Usługi"
  2. Lista usług → klik na usługę
  3. Szczegóły usługi (zdjęcie + opis + CTA) + "← Wstecz"

## Komponenty Blade (11)
| Komponent | Plik | Opis |
|-----------|------|------|
| Badge | components/badge.blade.php | Reużywalny badge z border |
| Button | components/button.blade.php | Primary/secondary, lg/sm, z ikoną |
| Gift Banner | components/gift-banner.blade.php | Banner "Pomysł na prezent" (hardcode) |
| Section | components/section.blade.php | Wrapper sekcji z paddingami |
| Service Card | components/service-card.blade.php | 3 warianty: default/compact/detailed |
| Testimonial Card | components/testimonial-card.blade.php | Karta opinii (zdjęcie/wideo) |
| Video Section | components/video-section.blade.php | YouTube lazy embed |
| Blog Card | components/blog-card.blade.php | Karta wpisu bloga |
| Portfolio Card | components/portfolio-card.blade.php | Karta realizacji |
| Alert | components/alert.blade.php | Komponent alertu |

## Ikony (12)
arrow-long-right, arrow-right, arrow-up-right, chevron-down, chevron-right, facebook, instagram, menu-icon, phone, play-circle, tiktok, x-mark

## JS Moduły (7)
| Moduł | Plik | Opis |
|-------|------|------|
| Mobile Menu | mobile-menu.js | 3-panelowe slide menu z usługami |
| Mega Menu | mega-menu.js | Desktop mega-menu hover + detail switch |
| FAQ Accordion | faq-accordion.js | Toggle accordion (one open at a time) |
| Lite YouTube | lite-youtube.js | Lazy load YouTube iframe |
| Testimonial Video | testimonial-video.js | Modal z wideo dla opinii |
| Drag Scroll | drag-scroll.js | Horizontal drag scroll dla sliderów |
| Slider Arrows | slider-arrows.js | Prev/next nawigacja strzałkami |

## Co zostało do zrobienia
- [x] Stworzyć pola ACF w panelu WP dla WSZYSTKICH bloków
- [x] Stworzyć pola ACF dla CPT Testimonial i Portfolio
- [x] Dodać bloki na stronę główną w Gutenbergu
- [x] Wypełnić treścią wszystkie bloki
- [x] CPT Service + szablon single-service
- [x] Bloki opisu usługi (Dla Kogo, Co Dostaniesz, Dlaczego Warto, Proces, FAQ)
- [x] Mega-menu desktop + mobile
- [x] Hero Podstrona + szablon "Strona z blokami"
- [x] Staging deployment pipeline
- [ ] Footer — dopracować treść i linki
- [ ] Podstrony (o mnie, kontakt)
- [ ] Social media — prawdziwe linki
- [ ] Export pól ACF do JSON

## Zasady pracy
- ACF pola tworzone ręcznie w panelu WP, nie kodem PHP
- Ikony z Heroicons, w `views/components/icons/`
- JS dzielony na osobne pliki w `resources/js/components/`, app.js tylko importuje
- W Composerach `\get_field()` z backslashem (namespace)
- Wszystkie sekcje jako ACF Blocks (nie @include)
- Badge jako komponent `<x-badge>` (nie inline)

## Uwagi
- PHP CLI: `C:/Users/wdabe/AppData/Roaming/Local/lightning-services/php-8.5.1+1/bin/win64/php.exe`
- Composer phar: `E:/LocalSites/dominikpakula/composer.phar`
- Bedrock webroot: `public/` (nie domyślne `web/`)
- Staging: dominikpakula.wdb-creative.pl (PHP 8.5 wymagane w panelu hostingu)
- Deploy: git push → pull na serwerze → npm run build → import bazy → search-replace URLs
