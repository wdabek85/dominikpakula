@if ($text)
  <section class="not-prose mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

      {{-- LEWA: graficzny cytat + autor --}}
      <div>
        @if ($eyebrow)
          <span class="block font-metro text-xs uppercase tracking-[3px] text-black/60 mb-4">{{ $eyebrow }}</span>
        @endif

        {{-- Duży cudzysłów --}}
        <span aria-hidden="true" class="block font-serif text-[130px] lg:text-[180px] leading-[0.55] text-primary select-none">&bdquo;</span>

        {{-- Cytat --}}
        <p class="font-poppins font-light text-[26px] lg:text-[34px] leading-[1.2] tracking-tight text-[#19121e] mt-3 max-w-[460px]">
          {{ $text }}
        </p>

        {{-- Autor --}}
        @if ($image || $attribution)
          <div class="flex items-center gap-4 mt-8">
            @if ($image)
              <img
                src="{{ $image }}"
                alt="{{ $imageAlt ?: $attribution }}"
                class="size-16 lg:size-[72px] shrink-0 object-cover rounded-sm grayscale"
                width="72"
                height="72"
                loading="lazy"
              >
            @endif
            @if ($attribution)
              <div class="flex flex-col">
                <span class="font-poppins font-medium text-base text-[#19121e]">{{ $attribution }}</span>
                @if ($role)
                  <span class="font-poppins text-sm text-black/50">{{ $role }}</span>
                @endif
              </div>
            @endif
          </div>
        @endif
      </div>

      {{-- PRAWA: wpasowany tekst --}}
      @if ($body)
        <div class="font-poppins text-base lg:text-lg leading-relaxed text-[#19121e]/80 [&>p]:mb-4 [&>p:last-child]:mb-0">
          {!! $body !!}
        </div>
      @endif

    </div>
  </section>
@endif
