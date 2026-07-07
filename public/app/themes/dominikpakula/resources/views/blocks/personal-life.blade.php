@if ($heading || $body || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16">
    <div class="bg-[#f1f1f1] rounded-xl p-6 lg:p-12">
      <div class="flex flex-col lg:flex-row items-center gap-8 lg:gap-14">

        {{-- Zdjęcie --}}
        @if ($image)
          <div class="shrink-0 w-full lg:w-[360px] aspect-[4/5] lg:aspect-square rounded-lg overflow-hidden bg-[#e7e7e7]">
            <img
              src="{{ $image }}"
              alt="{{ $imageAlt }}"
              class="size-full object-cover"
              loading="lazy"
            >
          </div>
        @endif

        {{-- Tekst --}}
        <div class="flex flex-col gap-4 lg:gap-5 flex-1 text-center lg:text-left">
          @if ($eyebrow)
            <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">{{ $eyebrow }}</span>
          @endif
          @if ($heading)
            <h2 class="font-poppins font-medium text-2xl lg:text-[32px] leading-tight text-[#19121e]">
              {{ $heading }}
            </h2>
          @endif
          @if ($body)
            <div class="font-poppins text-base lg:text-lg leading-relaxed text-[#19121e]/85 space-y-4">
              {!! $body !!}
            </div>
          @endif
        </div>

      </div>
    </div>
  </section>
@endif
