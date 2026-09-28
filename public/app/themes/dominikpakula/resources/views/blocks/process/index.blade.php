<x-section>

  {{-- Nagłówek: etykieta + tytuł (lewa) + opis (prawa) --}}
  <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
    <div class="flex flex-col gap-2 shrink-0">
      @if ($label)
        <x-eyebrow :label="$label" variant="large" :line="false" />
      @endif

      @if ($title)
        <x-heading>{{ $title }}</x-heading>
      @endif
    </div>

    @if ($description)
      <p class="font-poppins text-sm leading-none text-[#2a2a2b] lg:text-right">
        {!! $description !!}
      </p>
    @endif
  </div>

  {{-- Kroki — schodkowy grid na desktop, kolumna na mobile --}}
  @if ($steps)
    <div class="flex flex-col lg:flex-row gap-6 mb-8">
      @foreach ($steps as $index => $step)
        @php $offset = $index * 48; @endphp
        <div class="flex-1" @if($offset > 0) style="--step-offset: {{ $offset }}px" @endif>
          <div class="lg:mt-[var(--step-offset,0px)]">
            @include('blocks.process.step-card', [
              'number' => $step['number'],
              'title' => $step['title'],
              'description' => $step['description'],
            ])
          </div>
        </div>
      @endforeach
    </div>
  @endif

  {{-- Footer text --}}
  @if ($footer)
    <p class="font-poppins text-sm leading-none text-[#7b7a7c] text-center">
      {!! $footer !!}
    </p>
  @endif

</x-section>
