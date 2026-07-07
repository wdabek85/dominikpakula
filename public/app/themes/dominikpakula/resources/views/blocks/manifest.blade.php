@if ($text || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

      {{-- LEWA: cytat --}}
      <div>
        <span aria-hidden="true" class="block font-serif text-[110px] lg:text-[150px] leading-[0.5] text-primary select-none">&bdquo;</span>

        @if ($text)
          <p class="font-poppins text-[28px] lg:text-[40px] leading-tight lg:leading-[56px] tracking-[-0.8px] text-black mt-3 max-w-[466px]">
            {!! nl2br(e($text)) !!}
          </p>
        @endif

        @if ($avatar || $label)
          <div class="flex flex-col gap-3 mt-8 lg:mt-10">
            @if ($avatar)
              <img
                src="{{ $avatar }}"
                alt="{{ $avatarAlt ?: $label }}"
                class="size-[84px] lg:size-[96px] rounded-md object-cover"
                width="96"
                height="96"
                loading="lazy"
              >
            @endif
            @if ($label)
              <span class="font-poppins text-base text-black/70">{{ $label }}</span>
            @endif
          </div>
        @endif
      </div>

      {{-- PRAWA: duże zdjęcie --}}
      @if ($image)
        <div class="rounded-lg overflow-hidden">
          <img
            src="{{ $image }}"
            alt="{{ $imageAlt }}"
            class="w-full aspect-[772/377] object-cover"
            loading="lazy"
          >
        </div>
      @endif

    </div>
  </section>
@endif
