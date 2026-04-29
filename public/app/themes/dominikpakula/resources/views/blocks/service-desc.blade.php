<div class="py-4">

  {{-- Badge "Dla kogo" — POZA szarym tłem --}}
  @if ($label)
    <div class="mb-3">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Szara sekcja: heading + 3 sekcje --}}
  <section class="bg-[#f1f1f1] rounded p-4 lg:p-6">

    {{-- Nagłówek sekcji --}}
    @if ($heading)
      <h2 class="font-poppins text-lg font-bold leading-normal text-black max-w-[560px] mb-4 lg:mb-5">
        {{ $heading }}
      </h2>
    @endif

    {{-- 3 sekcje stackowane (editorial), z dużymi numerami jako visual filler --}}
    <div class="flex flex-col">
      @foreach ($sections as $i => $section)
        <div class="grid grid-cols-1 lg:grid-cols-[120px_1fr] gap-3 lg:gap-5 py-4 {{ $i === 0 ? 'pt-0' : '' }} {{ $i !== count($sections) - 1 ? 'border-b border-black/10' : 'pb-0' }}">

          {{-- Lewa: duży numer + eyebrow --}}
          <div class="flex flex-row lg:flex-col items-start gap-3 lg:gap-1.5">
            <span class="font-metro font-bold text-[40px] lg:text-[52px] leading-none text-black/15 select-none" aria-hidden="true">
              {{ $section['number'] }}
            </span>
            <div class="flex items-center gap-2 lg:mt-1 pt-1.5 lg:pt-0">
              <span class="font-metro text-xs uppercase tracking-[3px] text-black whitespace-nowrap">
                {{ $section['eyebrow'] }}
              </span>
              <span class="hidden lg:block h-px w-5 bg-black/40" aria-hidden="true"></span>
            </div>
          </div>

          {{-- Prawa: tytuł + lista --}}
          <div class="flex flex-col gap-2">
            <p class="font-poppins text-sm font-semibold leading-[14px] text-black">
              {{ $section['title'] }}
            </p>
            <ul class="flex flex-col gap-1.5 list-none p-0 m-0">
              @foreach ($section['items'] as $item)
                <li class="flex items-start gap-2">
                  <span class="font-metro text-xs text-black/40 shrink-0 leading-[12px] mt-1" aria-hidden="true">—</span>
                  <span class="font-poppins text-xs leading-relaxed text-black">{{ $item }}</span>
                </li>
              @endforeach
            </ul>
          </div>

        </div>
      @endforeach
    </div>

  </section>

  {{-- Banner prezentowy — POZA szarym tłem, pod sekcją --}}
  <div class="mt-4">
    <x-gift-banner />
  </div>

</div>
