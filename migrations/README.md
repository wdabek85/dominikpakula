# Migracje treści

Skrypty WP-CLI zmieniające treść/bazę (nie kod). Idempotentne — można puścić ponownie.
Nowe podstrony miast: `lib/city.php` (`mig_city_page()`) + `lib/blocks.php` (`mig_block()`), wzór — `2026-09-28-kielce.php`.
Odpalaj z roota Bedrocka **po** wdrożeniu kodu (`git pull` + `npm run build`):

```
wp eval-file migrations/<plik>.php dry   # podgląd, nic nie zapisuje (tam, gdzie obsługiwane)
wp eval-file migrations/<plik>.php
wp acorn view:clear && wp cache flush
wp eval '\RankMath\Sitemap\Cache::invalidate_storage();'   # nowe/zmienione adresy → odśwież sitemapę Rank Math
```

Na dhosting: `/opt/alt/php85/usr/bin/php ~/wp-cli.phar --path=public/wp ...`.
Kolejność przy nowym środowisku: najpierw `audyt`, potem miasta; na końcu `audyt` jeszcze raz (ustawia kolejność podstron utworzonych po nim).
Przed uruchomieniem na produkcji zrób backup bazy (`wp db export`).

| Plik | Co robi | local | staging | prod |
|---|---|---|---|---|
| 2026-09-28-warszawa.php | podstrona Zakupy ze stylistą → Warszawa | ✅ | ✅ | ✅ |
| 2026-09-28-audyt.php | audyt: grupy ACF → tylko acf-json, Ustawienia strony, Karta usługi, bloki usług z CPT | ✅ | ✅ | ✅ |
| 2026-09-28-wroclaw.php | podstrona Zakupy ze stylistą → Wrocław + import zdjęcia z `assets/` | ✅ | ✅ | ✅ |
| 2026-09-28-krakow.php | przebudowa Krakowa (usuwa kanibalizację z rodzicem: 40% → 3% wspólnej treści) | ✅ | ✅ | ✅ |
| 2026-09-28-kielce.php | podstrona Zakupy ze stylistą → Kielce (zdjęcie tymczasowe — z usługi-rodzica) | ✅ | ✅ | ✅ |
| 2026-09-28-seo-przeglad-zakupy.php | Rank Math: frazy „Przegląd szafy + zakupy” bez fraz innych usług | ✅ | ✅ | ✅ |
| 2026-09-28-faq-przeglad-zakupy.php | FAQ „Przegląd szafy + zakupy” zamiast zaślepki z szablonu — **nie odpalaj, zastąpiona przez `2026-11-16-faq-uslugi-konsultacje`** | ✅ | ✅ | — |
| 2026-11-16-linkowanie.php | linkowanie: `service_city` w miastach, blok „Gdzie działam” na głównej, przyciski pod logotypami na /o-mnie/, menu „Stopka – Informacje” | ✅ | ✅ | ✅ |
| 2026-11-16-schema.php | Rank Math: nazwa strony / Knowledge Graph → „Dominik Pakuła – stylista męski” (graf JSON-LD robi kod `app/Schema`) | ✅ | ✅ | ✅ |
| 2026-11-16-poznan.php | podstrona Zakupy ze stylistą → Poznań (+ FAQ; od promptu 5 własne teksty Procesu / Dla kogo / Co dają — puść ponownie), Poznań w „Gdzie działam” na głównej, meta description rodzica | ✅ | ✅ | ✅ |
| 2026-11-16-miasta-faq.php | lokalne FAQ (galeria, czas) na Warszawie, Krakowie, Wrocławiu, Kielcach; title głównej bez „Kraków” | ✅ | ✅ | ✅ |
| 2026-11-16-faq-uslugi-konsultacje.php | FAQ 5 usług zamiast zaślepek z szablonu (zastępuje `faq-przeglad-zakupy`), /konsultacje/: literówki w nagłówku, 3 sekcje text-columns + FAQ | ✅ | ✅ | ✅ |
| 2026-11-16-faq-dojazd.php | pytanie o dojazd (zawsze wliczony) w FAQ 5 miast, zakupów ze stylistą, przeglądu szafy i pakietu — **puść ponownie po każdym uruchomieniu `poznan` / `faq-uslugi-konsultacje`** (nadpisują FAQ) | ✅ | ✅ | ✅ |
| 2026-11-16-gdzie-dzialam.php | strona główna: „Gdzie działam” pod blogiem, tekst z `{miasta}`, `areas_links` = Zakupy online (miasta dopisuje composer); `service_city_genitive` na 5 miastach | ✅ | ⏳ | ⏳ |

> ⚠️ Grup pól ACF nie usuwaj przez `acf_delete_field_group()` ani przez kosz w panelu ACF — przy local JSON ACF kasuje też plik z `acf-json/`. Migracja audytu usuwa tylko wiersze z bazy.
