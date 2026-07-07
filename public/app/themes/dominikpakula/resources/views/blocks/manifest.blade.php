@if ($text || $image)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16">
    <div class="flex flex-col gap-6 lg:block lg:relative lg:aspect-[1280/760]">

      {{-- Cudzysłów (grafika) --}}
      <img
        src="{{ Vite::asset('resources/images/quote-mark.png') }}"
        alt=""
        aria-hidden="true"
        class="w-28 lg:w-[35%] select-none pointer-events-none lg:absolute lg:left-[1%] lg:top-[13%]"
      >

      {{-- Cytat --}}
      @if ($text)
        <p class="font-poppins text-[26px] lg:text-[34px] xl:text-[40px] leading-tight xl:leading-[56px] tracking-[-0.8px] text-black max-w-[466px] lg:absolute lg:left-[18%] lg:top-[6%] lg:w-[37%]">
          {!! nl2br(e($text)) !!}
        </p>
      @endif

      {{-- Duże zdjęcie (prawa, flush) --}}
      @if ($image)
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="w-full rounded-lg object-cover aspect-[664/377] lg:absolute lg:right-0 lg:top-0 lg:w-[50%]"
          loading="lazy"
        >
      @endif

      {{-- Mały portret (moduł cudzysłowu, nachodzi na duże zdjęcie) --}}
      @if ($avatar)
        <img
          src="{{ $avatar }}"
          alt="{{ $avatarAlt }}"
          class="w-40 lg:w-[16.5%] aspect-square rounded-lg object-cover lg:absolute lg:left-[35%] lg:top-[42%] lg:z-10"
          loading="lazy"
        >
      @endif

    </div>
  </section>
@endif
