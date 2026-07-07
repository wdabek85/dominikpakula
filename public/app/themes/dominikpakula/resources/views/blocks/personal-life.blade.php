@if ($heading || $body || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 items-center">

      {{-- Zdjęcie --}}
      @if ($image)
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="w-full rounded-lg object-cover aspect-[4/3]"
          loading="lazy"
        >
      @endif

      {{-- Tekst --}}
      <div class="flex flex-col gap-4">
        @if ($heading)
          <h2 class="font-poppins text-[26px] lg:text-[30px] leading-tight text-black">
            {{ $heading }}
          </h2>
        @endif
        @if ($body)
          <div class="font-poppins text-base leading-relaxed text-black space-y-4">
            {!! $body !!}
          </div>
        @endif
      </div>

    </div>
  </section>
@endif
