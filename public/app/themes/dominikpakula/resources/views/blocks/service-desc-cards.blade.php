{{--
  Dla kogo — wariant C (karty).
  Te same dane co `blocks.service-desc` (ServiceDescBlockComposer, pola `desc_*`),
  inny układ: trzy karty obok siebie, pierwsza (sekcja "Tak") wyróżniona kolorem.
--}}
<div class="py-10 lg:py-14">

  {{-- Badge "Dla kogo" --}}
  @if ($label)
    <div class="mb-6 lg:mb-8">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Nagłówek sekcji --}}
  @if ($heading)
    <h2 class="font-poppins text-lg font-bold leading-normal text-black max-w-[560px] mb-5 lg:mb-6">
      {{ $heading }}
    </h2>
  @endif

  {{-- Siatka: dwie kolumny (Tak + Polecam), a ostatnia sekcja („Raczej nie”)
       pełną szerokością pod spodem. `gap-px` na tle black/10 rysuje separatory. --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-px bg-black/10 border border-black/10 rounded overflow-hidden">

    @foreach ($sections as $i => $section)
      <article class="flex flex-col gap-4 p-6 lg:p-7 {{ $i === 0 ? 'bg-primary text-white' : 'bg-white' }} {{ $i === count($sections) - 1 ? 'md:col-span-2' : '' }}">

        @if ($section['eyebrow'])
          <span class="font-metro text-xs uppercase tracking-[3px] {{ $i === 0 ? 'text-white/60' : 'text-black/50' }}">
            {{ $section['eyebrow'] }}
          </span>
        @endif

        @if ($section['title'])
          <h3 class="font-serif text-xl lg:text-2xl font-normal leading-snug {{ $i === 0 ? 'text-white' : 'text-black' }}">
            {{ $section['title'] }}
          </h3>
        @endif

        @if (! empty($section['items']))
          <ul class="flex flex-col gap-2.5 list-none p-0 m-0">
            @foreach ($section['items'] as $item)
              <li class="flex gap-2.5 font-poppins text-sm leading-relaxed {{ $i === 0 ? 'text-white/85' : 'text-black/75' }}">
                <span class="shrink-0 select-none {{ $i === 0 ? 'text-white/40' : 'text-black/30' }}" aria-hidden="true">&mdash;</span>
                <span class="desc-card-item">
                  @if ($section['allow_html'])
                    {!! $item !!}
                  @else
                    {{ $item }}
                  @endif
                </span>
              </li>
            @endforeach
          </ul>
        @endif

        {{-- CTA tylko w karcie wyróżnionej (jak w referencji) --}}
        @if ($i === 0)
          <button
            type="button"
            class="booking-trigger mt-auto pt-2 inline-flex items-center gap-2 font-poppins text-sm font-medium text-white hover:gap-3 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary transition-all cursor-pointer w-fit"
          >
            <span>Umów bezpłatną konsultację</span>
            <x-icons.arrow-right class="size-4" />
          </button>
        @endif

      </article>
    @endforeach

  </div>
</div>
