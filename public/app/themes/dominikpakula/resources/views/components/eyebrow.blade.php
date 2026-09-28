{{--
  Nadtytuł sekcji (Metrophobic, wersaliki).

  variant: default — mały, z kreską 60 px (większość sekcji, hero bloga)
           large   — duży „MOJA OFERTA” z długą kreską (Oferta, Proces, Konsultacje)
  color:   klasa koloru tekstu; biała kreska dla text-white
--}}
@props([
  'label' => '',
  'variant' => 'default',
  'align' => 'left',
  'color' => 'text-[#19121e]',
  'line' => true,
])

@php
  $large = $variant === 'large';
  $lineColor = $color === 'text-white' ? 'bg-white' : 'bg-[#19121e]';
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-6' . ($align === 'center' ? ' justify-center' : '')]) }}>
  @if ($line && ! $large)
    <div class="h-px w-[60px] shrink-0 {{ $lineColor }}" aria-hidden="true"></div>
  @endif

  <span class="font-metro leading-none uppercase whitespace-nowrap {{ $large ? 'text-2xl tracking-[6px]' : 'text-sm tracking-[4px]' }} {{ $color }}">
    {{ $label }}
  </span>

  @if ($line && $large)
    <div class="h-px flex-1 lg:flex-none lg:w-[180px] {{ $lineColor }}" aria-hidden="true"></div>
  @endif
</div>
