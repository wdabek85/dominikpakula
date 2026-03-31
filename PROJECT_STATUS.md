# Project Status — dominikpakula

## Stack
- Bedrock 1.30.0 (web root zmieniony na `public/` dla Local by Flywheel)
- Sage 11.0.3 (motyw: `dominikpakula`)
- Acorn v5.1.0 (tylko w Sage, usunięty z Bedrocka)
- WordPress 6.9.4
- PHP 8.5.1 (Local)
- Node 24.11.1
- Tailwind CSS v4 (konfiguracja przez @theme w app.css)
- ACF Pro (aktywny)
- Rank Math (zainstalowany)

## Design tokens
- Max-width: 1440px
- Primary color: #282435
- Fonty: Inter (sans), Poppins (poppins), PT Serif (serif), Metrophobic (metro), Oswald (oswald), Work Sans (work)
- Desktop padding: 80px lewo/prawo, 48px góra/dół
- Mobile padding: 16px lewo/prawo, 32px góra/dół

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
│   │   ├── nav-desktop.blade.php
│   │   └── nav-mobile.blade.php
│   ├── footer.blade.php
│   └── sidebar.blade.php
├── components/
│   ├── alert.blade.php
│   ├── blog-card.blade.php
│   ├── button.blade.php
│   ├── portfolio-card.blade.php
│   ├── section.blade.php
│   ├── service-card.blade.php
│   ├── testimonial-card.blade.php
│   ├── video-section.blade.php
│   └── icons/
│       ├── arrow-long-right.blade.php
│       ├── arrow-right.blade.php
│       ├── arrow-up-right.blade.php
│       ├── chevron-down.blade.php
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
├── template-custom.blade.php
├── template-front-page.blade.php         ← wyświetla the_content() (bloki Gutenberga)

app/
├── blocks.php                            ← rejestracja ACF Blocks (11 bloków)
├── setup.php
├── filters.php
├── PostTypes/
│   ├── Testimonial.php                   ← CPT "Opinie" (testimonial)
│   └── Portfolio.php                     ← CPT "Realizacje" (portfolio, rewrite: /realizacje/)
├── Providers/
│   └── ThemeServiceProvider.php
├── View/Composers/
│   ├── App.php
│   ├── Comments.php
│   ├── Post.php
│   ├── HeroComposer.php
│   ├── VideoBlockComposer.php
│   ├── ServicesBlockComposer.php
│   ├── OfferBlockComposer.php
│   ├── ProcessBlockComposer.php
│   ├── TestimonialsBlockComposer.php
│   ├── PortfolioBlockComposer.php
│   ├── BlogBlockComposer.php
│   └── VoucherBlockComposer.php

resources/js/
├── app.js                                ← importuje moduły
├── editor.js                             ← block editor setup
└── components/
    ├── mobile-menu.js
    ├── lite-youtube.js
    ├── testimonial-video.js
    ├── drag-scroll.js                    ← drag scroll dla sliderów
    └── slider-arrows.js                  ← nawigacja strzałkami prev/next

resources/css/
├── app.css                               ← Tailwind v4 + @theme + custom fonts
└── editor.css                            ← Tailwind dla edytora bloków
```

## ACF Blocks — zarejestrowane (11 bloków)
| Blok | Widok | Composer | Status |
|------|-------|----------|--------|
| Hero | blocks.hero | HeroComposer | Gotowy — wymaga pól ACF |
| Video | blocks.video | VideoBlockComposer | Gotowy — wymaga pól ACF |
| Usługi | blocks.services.index | ServicesBlockComposer | Gotowy — wymaga pól ACF |
| Oferta | blocks.offer.index | OfferBlockComposer | Gotowy — wymaga pól ACF |
| Proces | blocks.process.index | ProcessBlockComposer | Gotowy — wymaga pól ACF |
| Opinie | blocks.testimonials.index | TestimonialsBlockComposer | Gotowy — wymaga CPT + pól ACF |
| Portfolio | blocks.portfolio.index | PortfolioBlockComposer | Gotowy — wymaga CPT + pól ACF |
| Voucher | blocks.voucher | VoucherBlockComposer | Gotowy — wymaga pól ACF |
| Blog | blocks.blog | BlogBlockComposer | Gotowy (WP_Query, bez ACF) |
| Newsletter | blocks.newsletter | — | Gotowy (szablon) |
| Kontakt | blocks.contact | — | Gotowy (szablon) |

## Custom Post Types (2)
| CPT | Slug | Plik | Opis |
|-----|------|------|------|
| Opinie | testimonial | PostTypes/Testimonial.php | Opinie klientów (non-public) |
| Realizacje | portfolio | PostTypes/Portfolio.php | Portfolio prac (public, /realizacje/) |

## Komponenty Blade (8)
| Komponent | Plik | Opis |
|-----------|------|------|
| Button | components/button.blade.php | Primary/secondary, lg/sm, z ikoną |
| Section | components/section.blade.php | Wrapper sekcji z paddingami i nagłówkiem |
| Service Card | components/service-card.blade.php | Karta usługi (default/compact) |
| Testimonial Card | components/testimonial-card.blade.php | Karta opinii (zdjęcie/wideo + cytat) |
| Video Section | components/video-section.blade.php | YouTube lazy embed |
| Blog Card | components/blog-card.blade.php | Karta wpisu (tytuł, excerpt, data, autor) |
| Portfolio Card | components/portfolio-card.blade.php | Karta realizacji (zdjęcie, tytuł, kategoria) |
| Alert | components/alert.blade.php | Komponent alertu/notyfikacji |

## Ikony (11)
arrow-long-right, arrow-right, arrow-up-right, chevron-down, facebook, instagram, menu-icon, phone, play-circle, tiktok, x-mark

## JS Moduły (5)
| Moduł | Plik | Opis |
|-------|------|------|
| Mobile Menu | mobile-menu.js | Toggle mobilnej nawigacji |
| Lite YouTube | lite-youtube.js | Lazy load YouTube iframe |
| Testimonial Video | testimonial-video.js | Modal z wideo dla opinii |
| Drag Scroll | drag-scroll.js | Horizontal drag scroll dla sliderów |
| Slider Arrows | slider-arrows.js | Prev/next nawigacja strzałkami |

## ACF pola do stworzenia ręcznie

### Blok Hero
Grupa: **Blok Hero** (przypisana do bloku `acf/hero`)
- `hero_title`, `hero_description`, `hero_button_text`, `hero_button_url`
- `hero_image`, `hero_card_image`, `hero_card_title`, `hero_card_link_text`, `hero_card_link_url`

### Blok Video
Grupa: **Blok Video** (przypisana do bloku `acf/video`)
- `video_image` (image), `video_youtube_id` (text), `video_heading` (text)
- `video_description` (textarea), `video_button_text` (text), `video_button_url` (url)
- `video_label` (text)

### Blok Usługi
Grupa: **Blok Usługi** (przypisana do bloku `acf/services`)
- `services_title` (text), `services_subtitle` (textarea)
- `services_highlight_image` (image), `services_highlight_title` (text), `services_highlight_description` (textarea)
- `services_cards` (repeater): services_card_name, services_card_problem, services_card_icon, services_card_description, services_card_link_text, services_card_link_url

### Blok Oferta
Grupa: **Blok Oferta** (przypisana do bloku `acf/offer`)
- `offer_label` (text), `offer_title` (text)
- `offer_cards` (repeater): offer_card_title, offer_card_description, offer_card_features, offer_card_price, offer_card_link_url
- `offer_button_text` (text), `offer_button_url` (url)

### Blok Proces
Grupa: **Blok Proces** (przypisana do bloku `acf/process`)
- `process_label` (text), `process_title` (text), `process_description` (textarea)
- `process_steps` (repeater): process_step_title, process_step_description, process_step_icon
- `process_footer` (text)

### Blok Opinie
Grupa: **Blok Opinie** (przypisana do bloku `acf/testimonials`)
- `testimonials_title` (text), `testimonials_subtitle` (textarea)
- `testimonials_items` (relationship → CPT testimonial)

### Blok Portfolio
Grupa: **Blok Portfolio** (przypisana do bloku `acf/portfolio`)
- `portfolio_title` (text), `portfolio_subtitle` (textarea)
- `portfolio_items` (relationship → CPT portfolio)

### Blok Voucher
Grupa: **Blok Voucher** (przypisana do bloku `acf/voucher`)
- `voucher_title` (text), `voucher_description` (textarea)
- `voucher_button_text` (text), `voucher_button_url` (url)
- `voucher_image_left` (image), `voucher_image_right` (image)

### CPT Testimonial — pola ACF
Grupa: **Opinia** (przypisana do CPT `testimonial`)
- `testimonial_quote` (textarea), `testimonial_media_type` (select: image/video)
- `testimonial_video_url` (text), `testimonial_service` (text)
- Thumbnail (wbudowany WP)

### CPT Portfolio — pola ACF
Grupa: **Portfolio** (przypisana do CPT `portfolio`)
- `portfolio_category` (text)

## Co zostało do zrobienia
- [x] Stworzyć pola ACF w panelu WP dla WSZYSTKICH bloków
- [x] Stworzyć pola ACF dla CPT Testimonial i Portfolio
- [x] Dodać bloki na stronę główną w Gutenbergu
- [x] Wypełnić treścią wszystkie bloki
- [ ] Footer — dopracować treść i linki
- [ ] Podstrony (usługi, o mnie, kontakt)
- [ ] Social media — prawdziwe linki
- [ ] Inicjalizacja Git
- [ ] Export pól ACF do JSON

## Zasady pracy
- ACF pola tworzone ręcznie w panelu WP, nie kodem PHP
- Ikony z Heroicons, w `views/components/icons/`
- JS dzielony na osobne pliki w `resources/js/components/`, app.js tylko importuje
- W Composerach `\get_field()` z backslashem (namespace)
- Wszystkie sekcje jako ACF Blocks (nie @include)

## Uwagi
- PHP CLI: `C:/Users/wdabe/AppData/Roaming/Local/lightning-services/php-8.5.1+1/bin/win64/php.exe`
- Composer phar: `E:/LocalSites/dominikpakula/composer.phar`
- Bedrock webroot: `public/` (nie domyślne `web/`)
