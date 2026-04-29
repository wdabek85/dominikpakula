<section class="not-prose py-8 lg:py-12">

  {{-- Header sekcji: tytuł + kreska + opis (wycentrowane) --}}
  @if ($title || $description)
    <div class="flex flex-col items-center gap-4 max-w-[720px] mx-auto mb-8 lg:mb-10 text-center">
      @if ($title)
        <h2 class="font-poppins font-bold text-2xl lg:text-[28px] leading-tight text-black">
          {{ $title }}
        </h2>
        <span class="block h-px w-[60px] bg-black/40" aria-hidden="true"></span>
      @endif
      @if ($description)
        <p class="font-poppins text-sm lg:text-base leading-relaxed text-black/80">
          {{ $description }}
        </p>
      @endif
    </div>
  @endif

  {{-- Galeria — wybór layoutu --}}
  @if (! empty($items))
    <div data-lightbox-gallery>

      @if ($layout === 'split' && count($items) >= 2)
        {{-- SPLIT: pierwszy item duży po lewej, reszta w grid 2x2 po prawej (matched heights) --}}
        @php
          $featured = $items[0];
          $rest = array_slice($items, 1, 4);
        @endphp
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5">
          {{-- Lewa: featured (model) z aspect-[4/5] --}}
          <div>
            @include('blocks.partials.lookbook-item', ['item' => $featured, 'aspect' => 'aspect-[4/5]'])
          </div>
          {{-- Prawa: ten sam aspect-[4/5] na containerze => identyczna wysokość; wewnątrz 2x2 grid stretched --}}
          <div class="lg:aspect-[4/5] grid grid-cols-2 grid-rows-2 gap-4 lg:gap-5">
            @foreach ($rest as $item)
              @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => null, 'fillHeight' => true])
            @endforeach
          </div>
        </div>

      @elseif ($layout === 'grid-4')
        {{-- GRID 4 kolumny --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5">
          @foreach ($items as $item)
            @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => 'aspect-[3/4]'])
          @endforeach
        </div>

      @else
        {{-- GRID 3 kolumny (default) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
          @foreach ($items as $item)
            @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => 'aspect-[3/4]'])
          @endforeach
        </div>
      @endif

    </div>
  @endif

</section>
