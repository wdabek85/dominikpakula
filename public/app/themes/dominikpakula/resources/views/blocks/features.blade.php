<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">

  {{-- Nagłówek --}}
  @if ($title || $description)
    <div class="flex flex-col gap-2.5 mb-8">
      @if ($title)
        <h2 class="font-serif text-[32px] leading-none text-primary">
          {{ $title }}
        </h2>
      @endif

      @if ($description)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $description }}
        </p>
      @endif
    </div>
  @endif

  {{-- Grid kart --}}
  @if ($cards)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($cards), 4) }} gap-10">
      @foreach ($cards as $card)
        <div class="border border-[#c9c9c9] rounded-lg p-8 flex flex-col gap-6">
          {{-- Ikona --}}
          @if ($card['icon'])
            <img
              src="{{ $card['icon'] }}"
              alt="{{ $card['iconAlt'] }}"
              class="size-12"
              width="48"
              height="48"
            >
          @else
            <div class="size-12" aria-hidden="true"></div>
          @endif

          {{-- Tytuł --}}
          @if ($card['title'])
            <p class="font-poppins text-xl leading-6 text-black">
              {{ $card['title'] }}
            </p>
          @endif

          {{-- Opis --}}
          @if ($card['description'])
            <p class="font-poppins text-base leading-5 text-black">
              {{ $card['description'] }}
            </p>
          @endif
        </div>
      @endforeach
    </div>
  @endif

</section>
