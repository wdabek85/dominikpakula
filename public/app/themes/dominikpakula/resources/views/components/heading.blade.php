{{--
  Nagłówek sekcji — jeden styl H2 dla całej strony.

  variant: section  — zwykła sekcja strony (domyślny)
           display  — duże CTA na pełną szerokość (newsletter, kontakt, rezerwacja)
           column   — bloki w kolumnie treści usługi (obok sidebaru)
  tone:    dark (ciemny tekst) / light (na ciemnym tle)
  as:      tag (domyślnie h2)
--}}
@props([
  'variant' => 'section',
  'tone' => 'dark',
  'as' => 'h2',
])

@php
  $variants = [
    'section' => 'font-poppins font-medium text-[28px] lg:text-4xl leading-tight',
    'display' => 'font-poppins font-medium text-[32px] lg:text-5xl leading-tight tracking-tight',
    'column' => 'font-poppins font-bold text-xl leading-snug',
  ];
  $tones = [
    'dark' => 'text-[#19121e]',
    'light' => 'text-white',
  ];
@endphp

<{{ $as }} {{ $attributes->merge(['class' => ($variants[$variant] ?? $variants['section']) . ' ' . ($tones[$tone] ?? $tones['dark'])]) }}>
  {{ $slot }}
</{{ $as }}>
