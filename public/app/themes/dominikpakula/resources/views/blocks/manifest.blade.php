@if ($text || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr] gap-8 lg:gap-x-20 items-center">

      {{-- Cytat z cudzysłowem w tle (nachodzi od góry) --}}
      <div class="relative pt-10 lg:pt-14">
        <img
          src="{{ Vite::asset('resources/images/quote-mark.png') }}"
          alt=""
          aria-hidden="true"
          class="absolute top-0 left-0 w-24 lg:w-32 select-none pointer-events-none"
        >
        @if ($text)
          <p class="relative font-poppins text-[28px] lg:text-[38px] leading-[1.25] tracking-[-0.8px] text-black max-w-[520px]">
            {!! nl2br(e($text)) !!}
          </p>
        @endif
      </div>

      {{-- Zdjęcie — reszta szerokości --}}
      @if ($image)
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="w-full rounded-lg object-cover aspect-[664/377]"
          loading="lazy"
        >
      @endif

    </div>
  </section>
@endif
