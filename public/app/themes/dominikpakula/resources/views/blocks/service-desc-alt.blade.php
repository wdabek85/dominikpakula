<div class="py-10 lg:py-14">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-6 lg:mb-8">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Nagłówek --}}
  @if ($heading)
    <h2 class="font-poppins text-xl font-bold leading-snug text-black mb-6 lg:mb-8">
      {{ $heading }}
    </h2>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6 lg:items-start">

    {{-- TAK (lewa kolumna) --}}
    @if (! empty($positive['items']))
      <div class="bg-primary/5 border border-primary/15 rounded-lg p-6 lg:p-7">
        <p class="font-poppins font-semibold text-base text-black mb-5">
          {{ $positive['title'] }}
        </p>
        <ul class="flex flex-col gap-3.5 list-none p-0 m-0">
          @foreach ($positive['items'] as $item)
            <li class="flex items-start gap-3">
              <span class="size-6 shrink-0 mt-0.5 rounded-full bg-primary flex items-center justify-center" aria-hidden="true">
                <x-icons.check class="size-4 text-white" />
              </span>
              <span class="font-poppins text-sm leading-relaxed text-black">{{ $item }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Prawa kolumna: POLECAM (ciemna) + NIE (szara) --}}
    <div class="flex flex-col gap-5 lg:gap-6">

      {{-- POLECAM — ciemna karta z gradientem (styl kafelka Instagram) --}}
      @if (! empty($highlight['items']))
        <div class="relative overflow-hidden rounded-lg bg-[#111111] p-6 lg:p-7 text-white">
          <div
            class="absolute -top-24 -right-24 size-80 rounded-full bg-gradient-to-br from-pink-500 via-purple-500 to-orange-400 opacity-20 blur-3xl pointer-events-none"
            aria-hidden="true"
          ></div>
          <div class="relative z-10">
            <p class="font-poppins font-semibold text-base text-white mb-5">
              {{ $highlight['title'] }}
            </p>
            <ul class="flex flex-col gap-3.5 list-none p-0 m-0">
              @foreach ($highlight['items'] as $item)
                <li class="flex items-start gap-3">
                  <span class="size-6 shrink-0 mt-0.5 rounded-full bg-white/15 flex items-center justify-center" aria-hidden="true">
                    <x-icons.check class="size-4 text-white" />
                  </span>
                  <span class="font-poppins text-sm leading-relaxed text-white/90">{{ $item }}</span>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      @endif

      {{-- NIE --}}
      @if (! empty($negative['items']))
        <div class="bg-[#f1f1f1] border border-black/10 rounded-lg p-6 lg:p-7">
          <p class="font-poppins font-semibold text-base text-black mb-5">
            {{ $negative['title'] }}
          </p>
          <ul class="flex flex-col gap-3.5 list-none p-0 m-0">
            @foreach ($negative['items'] as $item)
              <li class="flex items-start gap-3">
                <span class="size-6 shrink-0 mt-0.5 rounded-full bg-black/10 flex items-center justify-center" aria-hidden="true">
                  <x-icons.x-mark class="size-4 text-black/50" />
                </span>
                <span class="font-poppins text-sm leading-relaxed text-black/70 [&_a]:font-semibold [&_a]:text-black [&_a]:underline [&_a]:underline-offset-2 [&_a]:whitespace-nowrap [&_a]:hover:text-primary [&_a]:transition-colors">
                  @if (! empty($negative['allowHtml']))
                    {!! $item !!}
                  @else
                    {{ $item }}
                  @endif
                </span>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

    </div>

  </div>

</div>
