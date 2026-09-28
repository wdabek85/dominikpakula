{{--
  Wrapper sekcji strony — jeden kontener i jeden rytm pionowy dla wszystkich bloków.

  spacing: default (40 / 56 px) | tight (24 / 32 px) | none
  bg:      klasa tła na PEŁNĄ szerokość ekranu (np. bg-[#f1f1f1]) — wtedy treść
           trafia do wewnętrznego kontenera 1440 px. Bez bg sekcja sama jest kontenerem.
--}}
@props([
  'spacing' => 'default',
  'bg' => null,
  'as' => 'section',
])

@php
  $container = 'mx-auto max-w-[1440px] px-4 lg:px-20';
  $spacings = [
    'default' => 'py-10 lg:py-14',
    'tight' => 'py-6 lg:py-8',
    'none' => '',
  ];
  $padding = $spacings[$spacing] ?? $spacings['default'];
@endphp

@if ($bg)
  <{{ $as }} {{ $attributes->merge(['class' => trim("{$bg} {$padding}")]) }}>
    <div class="{{ $container }}">
      {{ $slot }}
    </div>
  </{{ $as }}>
@else
  <{{ $as }} {{ $attributes->merge(['class' => trim("bg-white {$container} {$padding}")]) }}>
    {{ $slot }}
  </{{ $as }}>
@endif
