<section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20">
  <div class="flex flex-col lg:flex-row lg:items-center lg:gap-20 pt-12 lg:pt-0">

    {{-- Lewa: tekst --}}
    <div class="flex flex-col gap-4 lg:gap-4 lg:flex-1 mb-8 lg:mb-0">

      {{-- Breadcrumb --}}
      @if ($breadcrumb)
        <nav class="font-poppins text-[10px] leading-3 text-black" aria-label="Breadcrumb">
          <a href="{{ home_url('/') }}" class="hover:underline">Strona główna</a>
          <span> / </span>
          <span class="font-bold">{{ $breadcrumb }}</span>
        </nav>
      @endif

      {{-- Tytuł + opis --}}
      <div class="flex flex-col gap-2.5">
        @if ($title)
          <h1 class="font-poppins text-[52px] leading-[56px] tracking-tight text-black">
            {{ $title }}
          </h1>
        @endif

        @if ($description)
          <p class="font-poppins text-base leading-5 text-black">
            {{ $description }}
          </p>
        @endif
      </div>
    </div>

    {{-- Prawa: dwa zdjęcia --}}
    <div class="flex flex-col lg:flex-row lg:flex-1">

      {{-- Lewe zdjęcie --}}
      @if ($imageLeft)
        <div class="relative w-full lg:w-[238px] h-[478px] shrink-0 rounded-l-sm overflow-hidden">
          <img
            src="{{ $imageLeft }}"
            alt="{{ $imageLeftAlt }}"
            class="absolute inset-0 size-full object-cover"
            width="238"
            height="478"
          >

          {{-- Ikonka + --}}
          <div class="absolute top-4 left-5 bg-white rounded-full p-1.5">
            <svg class="size-5 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
          </div>

          {{-- Podpis --}}
          @if ($captionLeft)
            <p class="absolute bottom-4 left-5 right-5 font-poppins font-medium text-sm leading-4 text-black">
              {{ $captionLeft }}
            </p>
          @endif
        </div>
      @endif

      {{-- Prawe zdjęcie --}}
      @if ($imageRight)
        <div class="relative w-full lg:flex-1 h-[478px] rounded-r-sm overflow-hidden">
          <img
            src="{{ $imageRight }}"
            alt="{{ $imageRightAlt }}"
            class="absolute inset-0 size-full object-cover"
            loading="lazy"
            width="400"
            height="478"
          >

          {{-- Podpis --}}
          @if ($captionRight)
            <p class="absolute bottom-4 left-5 right-5 font-poppins font-medium text-sm leading-4 text-black">
              {{ $captionRight }}
            </p>
          @endif
        </div>
      @endif

    </div>

  </div>
</section>
