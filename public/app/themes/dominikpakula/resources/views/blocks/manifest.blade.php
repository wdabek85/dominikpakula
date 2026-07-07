@if ($text || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16 overflow-hidden">
    <div class="flex flex-col gap-6 lg:block lg:relative lg:h-[620px]">

      {{-- Cudzysłów (grafika) --}}
      <img
        src="{{ Vite::asset('resources/images/quote-mark.png') }}"
        alt=""
        aria-hidden="true"
        class="w-24 lg:w-[420px] select-none pointer-events-none lg:absolute lg:left-0 lg:top-[14%]"
      >

      {{-- Cytat --}}
      @if ($text)
        <p class="font-poppins text-[26px] lg:text-[40px] leading-tight lg:leading-[56px] tracking-[-0.8px] text-black max-w-[466px] lg:absolute lg:left-[15%] lg:top-[5%] lg:w-[466px]">
          {!! nl2br(e($text)) !!}
        </p>
      @endif

      {{-- Duże zdjęcie (prawa) --}}
      @if ($image)
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="w-full rounded-lg object-cover aspect-[664/377] lg:absolute lg:right-0 lg:top-0 lg:w-[46%]"
          loading="lazy"
        >
      @endif

      {{-- Mały portret (środek) --}}
      @if ($avatar)
        <img
          src="{{ $avatar }}"
          alt="{{ $avatarAlt }}"
          class="size-40 lg:size-[215px] rounded-lg object-cover lg:absolute lg:left-[34%] lg:top-[44%]"
          loading="lazy"
        >
      @endif

    </div>
  </section>
@endif
