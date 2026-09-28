@props([
  'variant' => 'primary',
  'size' => 'lg',
  'icon' => 'none',
  'href' => null,
  'label' => '',
  'type' => 'button',
  'iconSvg' => null,
])

@php
  $tag = $href ? 'a' : 'button';

  $base = 'inline-flex items-center justify-center font-poppins font-medium text-base leading-[26px] rounded-[2px] border transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';

  // Kolor focus ringa siedzi w wariancie — na ciemnym tle (light / outline-light) ring jest biały.
  $variants = [
    'primary' => 'bg-primary border-primary text-white hover:bg-primary/90 focus:ring-primary',
    'secondary' => 'bg-white border-primary text-black hover:bg-gray-50 focus:ring-primary',
    'light' => 'bg-white border-white text-primary hover:bg-white/90 focus:ring-white focus:ring-offset-primary',
    'outline-light' => 'bg-transparent border-white text-white hover:bg-white/10 focus:ring-white focus:ring-offset-primary',
  ];

  $sizes = [
    'lg' => 'px-6 py-4',
    'sm' => 'px-6 py-3',
  ];

  $iconGap = $icon !== 'none' ? 'gap-2' : '';

  $classes = implode(' ', [
    $base,
    $variants[$variant] ?? $variants['primary'],
    $sizes[$size] ?? $sizes['lg'],
    $iconGap,
  ]);
@endphp

<{{ $tag }}
  @if($href) href="{{ $href }}" @endif
  @if(!$href) type="{{ $type }}" @endif
  {{ $attributes->merge(['class' => $classes]) }}
>
  @if($icon === 'left' && $iconSvg)
    <span class="size-6 shrink-0" aria-hidden="true">{!! $iconSvg !!}</span>
  @endif

  <span>{{ $label }}</span>

  @if($icon === 'right' && $iconSvg)
    <span class="size-6 shrink-0" aria-hidden="true">{!! $iconSvg !!}</span>
  @endif
</{{ $tag }}>
