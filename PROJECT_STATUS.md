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
- Fonty: Inter (sans), Poppins (poppins), Metrophobic (metro)
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
│   ├── hero.blade.php                    ← blok Hero (migracja z sections/)
│   ├── video.blade.php                   ← blok Video (wrapper na <x-video-section>)
│   └── services/
│       ├── index.blade.php               ← blok Usługi (nagłówek + grid)
│       └── highlight-card.blade.php      ← karta z foto i overlay
├── sections/
│   ├── header.blade.php                  ← header (logo, social, CTA, toggle)
│   ├── header/
│   │   ├── nav-desktop.blade.php
│   │   └── nav-mobile.blade.php
│   └── footer.blade.php
├── components/
│   ├── button.blade.php                  ← reużywalny przycisk (primary/secondary, lg/sm, z ikoną)
│   ├── section.blade.php                 ← wrapper sekcji z paddingami i nagłówkiem + slot
│   ├── service-card.blade.php            ← karta usługi (default/compact, font Metrophobic)
│   ├── video-section.blade.php           ← komponent wideo z YouTube lazy embed
│   └── icons/
│       ├── arrow-long-right.blade.php
│       ├── arrow-right.blade.php
│       ├── chevron-down.blade.php
│       ├── facebook.blade.php
│       ├── instagram.blade.php
│       ├── menu-icon.blade.php
│       ├── phone.blade.php
│       ├── play-circle.blade.php
│       ├── tiktok.blade.php
│       └── x-mark.blade.php
├── template-front-page.blade.php         ← wyświetla the_content() (bloki Gutenberga)

app/
├── blocks.php                            ← rejestracja ACF Blocks (hero, video, services)
├── View/Composers/
│   ├── App.php
│   ├── Comments.php
│   ├── Post.php
│   ├── HeroComposer.php                 ← dane ACF dla bloku Hero
│   ├── VideoBlockComposer.php           ← dane ACF dla bloku Video
│   └── ServicesBlockComposer.php        ← dane ACF dla bloku Usługi
├── setup.php
└── filters.php

resources/js/
├── app.js                                ← importuje moduły
└── components/
    ├── mobile-menu.js
    └── lite-youtube.js
```

## ACF Blocks — zarejestrowane
| Blok | Widok | Composer | Status |
|------|-------|----------|--------|
| Hero | blocks.hero | HeroComposer | Gotowy (migracja) |
| Video | blocks.video | VideoBlockComposer | Gotowy — wymaga pól ACF |
| Usługi | blocks.services.index | ServicesBlockComposer | Gotowy — wymaga pól ACF |

## ACF pola do stworzenia ręcznie

### Blok Video (nowe pola)
Grupa: **Blok Video** (przypisana do bloku `acf/video`)
- `video_image` (image) — tło sekcji
- `video_youtube_id` (text) — ID filmu YouTube
- `video_heading` (text) — nagłówek
- `video_description` (textarea) — opis
- `video_button_text` (text) — tekst przycisku
- `video_button_url` (url) — link przycisku
- `video_label` (text) — etykieta "Obejrzyj Wideo"

### Blok Usługi (nowe pola)
Grupa: **Blok Usługi** (przypisana do bloku `acf/services`)
- `services_title` (text) — nagłówek sekcji (z HTML)
- `services_subtitle` (textarea) — podtytuł
- `services_highlight_image` (image) — zdjęcie wyróżniające
- `services_highlight_title` (text) — tytuł na zdjęciu
- `services_highlight_description` (textarea) — opis na zdjęciu
- `services_cards` (repeater):
  - `services_card_name` (text) — nazwa usługi
  - `services_card_problem` (text) — problem klienta
  - `services_card_icon` (image) — ikonka
  - `services_card_description` (textarea) — opis rozwiązania
  - `services_card_link_text` (text) — tekst linku
  - `services_card_link_url` (url) — URL linku

### Blok Hero (istniejące pola)
Grupa: **Hero** (przypisana do strony głównej — PRZENIEŚĆ na blok `acf/hero`)
- hero_title, hero_description, hero_button_text, hero_button_url
- hero_image, hero_card_image, hero_card_title, hero_card_link_text, hero_card_link_url

## Co zostało do zrobienia
- [ ] Stworzyć pola ACF w panelu WP dla bloku Video
- [ ] Stworzyć pola ACF w panelu WP dla bloku Usługi
- [ ] Przenieść istniejące pola Hero z page rule na block rule (acf/hero)
- [ ] Dodać bloki na stronę główną w Gutenbergu (Hero → Video → Usługi)
- [ ] Wypełnić treścią bloki Video i Usługi
- [ ] Kolejne sekcje strony głównej
- [ ] Footer
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
