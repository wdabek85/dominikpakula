<div class="py-6">

  {{-- Badge + nagłówek --}}
  <div class="flex flex-col gap-2 items-start mb-6">
    @if ($label)
      <x-badge :label="$label" />
    @endif

    @if ($title)
      <h3 class="font-sans font-bold text-2xl leading-normal text-black">
        {{ $title }}
      </h3>
    @endif
  </div>

  {{-- Lista elementów: 2 kolumny desktop, 1 mobile --}}
  @if ($items)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      @foreach ($items as $item)
        <div class="flex gap-2 items-start">
          {{-- Ikona --}}
          @if ($item['icon'])
            <img
              src="{{ $item['icon'] }}"
              alt="{{ $item['iconAlt'] }}"
              class="size-6 shrink-0"
              width="24"
              height="24"
            >
          @else
            <div class="size-6 shrink-0"></div>
          @endif

          {{-- Tekst --}}
          <p class="font-sans text-lg leading-normal text-black">
            <span class="font-medium">{{ $item['title'] }}</span>
            @if ($item['description'])
              <span class="font-normal"> {{ $item['description'] }}</span>
            @endif
          </p>
        </div>
      @endforeach
    </div>
  @endif

</div>
