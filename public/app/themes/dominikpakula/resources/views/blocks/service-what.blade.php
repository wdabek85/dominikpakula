<div class="py-6">

  {{-- Badge + nagłówek --}}
  <div class="flex flex-col gap-2 items-start mb-6">
    @if ($label)
      <x-badge :label="$label" />
    @endif

    @if ($title)
      <h3 class="font-poppins text-xl font-bold leading-snug text-black">
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
              class="size-12 shrink-0 object-contain"
              width="48"
              height="48"
            >
          @else
            <div class="size-12 shrink-0" aria-hidden="true"></div>
          @endif

          {{-- Tekst --}}
          <p class="font-poppins text-base leading-relaxed text-black">
            <span class="font-semibold">{{ $item['title'] }}</span>
            @if ($item['description'])
              <span> {{ $item['description'] }}</span>
            @endif
          </p>
        </div>
      @endforeach
    </div>
  @endif

</div>
