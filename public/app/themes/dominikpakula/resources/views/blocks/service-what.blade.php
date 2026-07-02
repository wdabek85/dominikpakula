<div class="py-10 lg:py-14">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-6 lg:mb-8">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Nagłówek --}}
  @if ($title)
    <h3 class="font-poppins text-xl font-bold leading-snug text-black mb-6 lg:mb-8">
      {{ $title }}
    </h3>
  @endif

  {{-- Lista elementów: 2 kolumny desktop, 1 mobile --}}
  @if ($items)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      @foreach ($items as $item)
        <div class="flex gap-2 items-start">
          {{-- Halo + solidny krążek z białym ptaszkiem (zamiast wgrywanej ikony) --}}
          <div class="size-12 shrink-0 rounded-full bg-primary/10 flex items-center justify-center" aria-hidden="true">
            <div class="size-9 rounded-full bg-primary flex items-center justify-center">
              <x-icons.check class="size-5 text-white" />
            </div>
          </div>

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
