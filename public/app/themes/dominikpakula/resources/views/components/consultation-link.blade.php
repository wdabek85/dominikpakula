{{--
  Link tekstowy do podstrony /konsultacje/ obok przycisku otwierającego modal rezerwacji.

  tone:  dark (na jasnym tle) | light (na ciemnym tle)
  label: treść linku
--}}
@props([
  'tone' => 'dark',
  'label' => 'Jak wygląda bezpłatna konsultacja',
])

@php
  $tones = [
    'dark' => 'text-[#655098] focus-visible:ring-primary',
    'light' => 'text-white focus-visible:ring-white focus-visible:ring-offset-primary',
  ];
@endphp

<a
  href="{{ home_url('/konsultacje/') }}"
  {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 font-poppins text-sm underline underline-offset-4 rounded-sm hover:no-underline focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 ' . ($tones[$tone] ?? $tones['dark'])]) }}
>
  {{ $label }}
  <x-icons.arrow-right class="size-4 shrink-0" />
</a>
