@php
  $isShopLink = ! empty($item['shopUrl']);
  $fillHeight = ! empty($fillHeight);
  $aspect = $aspect ?? 'aspect-[3/4]';
  $bgClass = $item['type'] === 'product' ? 'bg-[#f1f1f1]' : 'bg-[#19121e]/5';

  // Gdy fillHeight = true (np. items po prawej w split layoucie), bez fixed aspect — wypełnia cell
  $imageWrapperClass = $fillHeight ? 'h-full w-full' : $aspect;
  $rootHeightClass = $fillHeight ? 'h-full flex flex-col' : '';
@endphp

<a
  href="{{ $isShopLink ? $item['shopUrl'] : $item['fullSrc'] }}"
  @if ($isShopLink)
    target="_blank"
    rel="noopener nofollow"
  @else
    data-lightbox-trigger
    data-lightbox-src="{{ $item['fullSrc'] }}"
    data-lightbox-alt="{{ $item['alt'] }}"
    data-lightbox-caption="{{ $item['brand'] }}"
  @endif
  class="block group rounded overflow-hidden {{ $isShopLink ? '' : 'cursor-zoom-in' }} {{ $rootHeightClass }}"
  aria-label="{{ $isShopLink ? ('Sklep: ' . ($item['brand'] ?: $item['alt'])) : ($item['brand'] ?: 'Powiększ zdjęcie') }}"
>
  {{-- Obraz --}}
  <div class="{{ $imageWrapperClass }} {{ $bgClass }} overflow-hidden relative {{ $fillHeight ? 'flex-1' : '' }}">
    <img
      src="{{ $item['src'] }}"
      alt="{{ $item['alt'] }}"
      @if ($item['width']) width="{{ $item['width'] }}" @endif
      @if ($item['height']) height="{{ $item['height'] }}" @endif
      class="size-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
      loading="lazy"
    >

    {{-- Ikona sklepu w prawym górnym (visual hint że link external) --}}
    @if ($isShopLink)
      <span
        class="absolute top-2 right-2 size-7 rounded-full bg-white/90 text-[#19121e] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
        aria-hidden="true"
      >
        <x-icons.arrow-up-right class="size-4" />
      </span>
    @endif
  </div>

  {{-- Brand label pod zdjęciem --}}
  @if ($item['brand'])
    <p class="font-metro text-xs uppercase tracking-[3px] text-black/70 mt-2 group-hover:text-primary transition-colors">
      {{ $item['brand'] }}
    </p>
  @endif
</a>
