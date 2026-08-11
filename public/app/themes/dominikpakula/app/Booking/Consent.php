<?php

/**
 * Treść zgód zbieranych w formularzach — jedno źródło prawdy.
 *
 * Formularz i mail-powiadomienie muszą pokazywać DOKŁADNIE tę samą treść zgody.
 * RODO art. 7 ust. 1 wymaga wykazania, na co konkretnie użytkownik się zgodził —
 * jeśli tekst na stronie i tekst w archiwum mailowym się rozjadą, dowód traci wartość.
 */

namespace App\Booking;

/**
 * Kanoniczna treść zgody RODO przy formularzu kontaktowym.
 *
 * Zawiera token %s w miejscu odnośnika do polityki prywatności — widok podstawia
 * tam link, mail podstawia sam adres URL.
 */
function contact_consent_template(): string
{
    return 'Wyrażam zgodę na przetwarzanie moich danych osobowych zgodnie z %s.';
}

/**
 * Wersja dla widoku — z klikalnym odnośnikiem do polityki prywatności.
 */
function contact_consent_html(): string
{
    $link = sprintf(
        '<a href="%s" class="underline">polityką prywatności</a>',
        esc_url(home_url('/polityka-prywatnosci/'))
    );

    return sprintf(esc_html(contact_consent_template()), $link);
}

/**
 * Wersja dla archiwum mailowego — pełny tekst z rozwiniętym adresem URL,
 * żeby dowód zgody był czytelny bez wchodzenia na stronę.
 */
function contact_consent_plain(): string
{
    return sprintf(
        contact_consent_template(),
        'polityką prywatności (' . home_url('/polityka-prywatnosci/') . ')'
    );
}
