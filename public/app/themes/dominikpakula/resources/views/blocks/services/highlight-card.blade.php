<div class="group relative flex flex-col justify-end rounded overflow-hidden h-[436px] lg:h-auto lg:min-h-[436px] lg:min-w-[300px] lg:flex-1 px-5 py-4">

  @if ($image)
    <img
      src="{{ $image['url'] }}"
      alt="{{ $image['alt'] ?? '' }}"
      class="absolute inset-0 size-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
      width="{{ $image['width'] ?? '' }}"
      height="{{ $image['height'] ?? '' }}"
      loading="lazy"
    >

    {{-- Gradient overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent" aria-hidden="true"></div>
  @endif

  @if ($title || $description)
    <div class="relative z-10">
      @if ($title)
        <p class="font-medium text-[15px] leading-normal text-white">
          {{ $title }}
        </p>
      @endif

      @if ($description)
        <p class="text-[15px] leading-normal text-white">
          {{ $description }}
        </p>
      @endif
    </div>
  @endif

</div>
