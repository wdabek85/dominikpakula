<div class="py-10 lg:py-14">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-6 lg:mb-8">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Layout: 2 kolumny desktop, 1 mobile --}}
  <div class="flex flex-col lg:flex-row lg:gap-12">

    {{-- Lewa: opis --}}
    @if ($description)
      <div class="lg:flex-1 mb-6 lg:mb-0">
        <p class="font-poppins text-base leading-relaxed text-black">
          {{ $description }}
        </p>
      </div>
    @endif

    {{-- Prawa: timeline --}}
    @if ($steps)
      <div class="lg:flex-1 flex flex-col">
        @foreach ($steps as $index => $step)
          <div class="flex gap-10 items-stretch">

            {{-- Halo + solidny krążek z numerem kroku (styl jak halo+check w service-what) --}}
            <div class="flex flex-col items-center shrink-0 w-12">
              <div class="size-12 shrink-0 rounded-full bg-primary/10 flex items-center justify-center" aria-hidden="true">
                <div class="size-9 rounded-full bg-primary flex items-center justify-center">
                  <span class="font-poppins font-bold text-white text-base leading-none">{{ $loop->iteration }}</span>
                </div>
              </div>

              @if (! $loop->last)
                <div class="flex-1 w-0 border-l-2 border-solid border-black/20 my-4"></div>
              @endif
            </div>

            {{-- Treść kroku --}}
            <div class="flex flex-col gap-2 flex-1 min-w-0 pb-8 {{ $loop->last ? 'pb-0' : '' }}">
              @if ($step['stepLabel'])
                <p class="font-poppins text-sm font-medium leading-snug text-black/60">
                  {{ $step['stepLabel'] }}
                </p>
              @endif
              @if ($step['title'])
                <p class="font-poppins text-base font-bold leading-snug text-black">
                  {{ $step['title'] }}
                </p>
              @endif

              @if ($step['description'])
                <p class="font-poppins text-sm leading-relaxed text-black">
                  {{ $step['description'] }}
                </p>
              @endif
            </div>

          </div>
        @endforeach
      </div>
    @endif

  </div>

</div>
