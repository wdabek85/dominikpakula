@if ($text)
  <section class="not-prose mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">

      {{-- LEWA: graficzny cytat + autor --}}
      <div>
        @if ($eyebrow)
          <span class="block font-metro text-xs uppercase tracking-[3px] text-black/60 mb-4">{{ $eyebrow }}</span>
        @endif

        {{-- Cudzysłów (lewa) + cytat (obok) — bez nachodzenia --}}
        <div class="flex items-start gap-5 lg:gap-8">
          <span aria-hidden="true" class="shrink-0 font-serif font-bold text-[100px] lg:text-[150px] leading-[0.7] text-primary select-none">&bdquo;</span>
          <p class="font-poppins font-light text-[24px] lg:text-[32px] leading-[1.3] tracking-tight text-[#19121e] pt-4 lg:pt-8">
            {{ $text }}
          </p>
        </div>

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
        <div class="font-poppins text-base lg:text-lg leading-relaxed text-[#19121e]/80 space-y-4">
          {!! $body !!}
        </div>
      @endif

    </div>
  </section>
@endif
