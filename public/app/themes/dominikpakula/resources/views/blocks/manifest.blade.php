@if ($text || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-center">

      {{-- Cytat --}}
      <div>
        <img
          src="{{ Vite::asset('resources/images/quote-mark.png') }}"
          alt=""
          aria-hidden="true"
          class="w-20 lg:w-28 mb-6 select-none pointer-events-none"
        >
        @if ($text)
          <p class="font-poppins text-[28px] lg:text-[38px] leading-[1.25] tracking-[-0.8px] text-black max-w-[520px]">
            {!! nl2br(e($text)) !!}
          </p>
        @endif
      </div>

      {{-- Zdjęcie --}}
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
