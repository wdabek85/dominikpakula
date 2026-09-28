<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

  {{-- Nagłówek sekcji --}}
  @if ($title || $subtitle)
    <div class="flex flex-col gap-2.5 mb-8">
      @if ($title)
        <h2 class="font-poppins text-[30px] leading-none text-black">
          {!! $title !!}
        </h2>
      @endif

      @if ($subtitle)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $subtitle }}
        </p>
      @endif
    </div>
  @endif

  {{-- Grid: highlight card + service cards. 1 → 2 kolumny (md) → 4 równe od xl
       (przy 1440 to ~300 px na kartę jak w Figmie; sztywne 300 px ucinały ostatnią kartę na tablecie) --}}
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- Highlight card --}}
    @if ($highlightImage)
      @include('blocks.services.highlight-card', [
        'image' => $highlightImage,
        'title' => $highlightTitle,
        'description' => $highlightDescription,
      ])
    @endif

    {{-- Service cards --}}
    @foreach ($cards as $card)
      <div class="w-full">
        <x-service-card
          :category="$card['name']"
          :title="$card['problem']"
          :icon="$card['icon']"
          :description="$card['description']"
          :link-text="$card['linkText']"
          :link-url="$card['linkUrl']"
        />
      </div>
    @endforeach

  </div>

</section>
