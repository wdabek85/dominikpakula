<div class="py-10 lg:py-14">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-6 lg:mb-8">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Szara karta --}}
  <div class="bg-[#f2f2f2] flex flex-col lg:flex-row rounded overflow-hidden">

    {{-- Lewa: treść + benefity --}}
    <div class="flex-1 flex flex-col gap-8 p-4 lg:pl-6 lg:py-10">

      {{-- Nagłówek + opis --}}
      @if ($title || $description)
        <div class="flex flex-col gap-2">
          @if ($title)
            <h3 class="font-poppins text-lg font-bold leading-normal text-black">
              {{ $title }}
            </h3>
          @endif

          @if ($description)
            <div class="font-poppins text-xs font-medium leading-normal text-black prose prose-sm max-w-none prose-strong:font-bold">
              {!! $description !!}
            </div>
          @endif
        </div>
      @endif

      {{-- Benefity grid 2x2 desktop, 1 col mobile --}}
      @if ($benefits)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          @foreach ($benefits as $benefit)
            <div class="flex gap-2 items-start">
              {{-- Ikona --}}
              <div class="bg-black rounded-full p-2.5 shrink-0">
                @if ($benefit['icon'])
                  <img
                    src="{{ $benefit['icon'] }}"
                    alt="{{ $benefit['iconAlt'] }}"
                    class="size-6 brightness-0 invert"
                    width="24"
                    height="24"
                  >
                @else
                  <div class="size-6" aria-hidden="true"></div>
                @endif
              </div>

              {{-- Tekst --}}
              <div class="flex flex-col gap-2">
                <p class="font-poppins text-sm font-semibold leading-[14px] text-black">
                  {{ $benefit['title'] }}
                </p>
                <p class="font-poppins text-xs leading-[12px] text-black">
                  {{ $benefit['description'] }}
                </p>
              </div>
            </div>
          @endforeach
        </div>
      @endif

    </div>

    {{-- Prawa: zdjęcie --}}
    @if ($image)
      <div class="relative w-full h-[280px] lg:w-[228px] lg:h-auto lg:self-stretch shrink-0">
        <img
          src="{{ $image }}"
          alt="{{ $imageAlt }}"
          class="absolute inset-0 size-full object-cover lg:rounded-l"
          loading="lazy"
          width="228"
          height="356"
        >
        <div class="absolute inset-0 bg-black/20 lg:rounded-l"></div>

        {{-- Podpis --}}
        @if ($imageCaption)
          <p class="absolute bottom-4 left-5 right-5 font-poppins text-[11px] font-medium leading-normal text-white">
            {{ $imageCaption }}
          </p>
        @endif
      </div>
    @endif

  </div>

</div>
