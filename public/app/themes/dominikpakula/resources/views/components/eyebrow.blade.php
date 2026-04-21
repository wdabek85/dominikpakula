@props([
  'label' => '',
  'align' => 'left',
  'color' => 'text-[#19121e]',
  'line' => true,
])

@php
  $wrapper = $align === 'center'
    ? 'flex items-center gap-6 justify-center'
    : 'flex items-center gap-6';
@endphp

<div {{ $attributes->merge(['class' => $wrapper]) }}>
  @if ($line)
    <div class="h-px w-[60px] shrink-0 {{ $color === 'text-white' ? 'bg-white' : 'bg-[#19121e]' }}" aria-hidden="true"></div>
  @endif

  <span class="font-metro text-sm leading-none tracking-[4px] uppercase whitespace-nowrap {{ $color }}">
    {{ $label }}
  </span>
</div>
