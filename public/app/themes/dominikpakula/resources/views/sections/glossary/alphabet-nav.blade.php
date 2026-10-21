{{--
  Pasek alfabetu — jeden rząd, nie wychodzi poza kontener.
  Gdy litery się nie mieszczą, przewija się strzałkami (slider-arrows.js, krok = szerokość widoku);
  gdy się mieszczą, strzałki są ukryte. Litery bez haseł są nieaktywne (span, nie link).
--}}
@if (! empty($letters))
  <nav class="bg-white border-y border-black/10" aria-label="Alfabet słowniczka">
    <div class="mx-auto max-w-[1440px] px-4 lg:px-20 py-3 flex items-center gap-2" data-slider-root>

      <div class="shrink-0" data-slider-arrows>
        <button
          type="button"
          class="flex items-center justify-center size-10 rounded-full border border-[#19121e] text-[#19121e] transition-colors hover:bg-[#19121e] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary disabled:opacity-30 disabled:pointer-events-none cursor-pointer"
          aria-label="Poprzednie litery"
          data-slider-prev
        >
          <x-icons.arrow-left class="size-4" />
        </button>
      </div>

      <ul class="flex-1 min-w-0 flex items-center gap-1 overflow-x-auto scrollbar-hide scroll-smooth" data-slider data-slider-step="page">
        @foreach ($letters as $item)
          <li class="shrink-0">
            @if ($item['active'])
              <a
                href="#{{ $item['id'] }}"
                class="inline-flex items-center justify-center size-10 rounded-[2px] border border-[#19121e] font-poppins text-sm text-[#19121e] hover:bg-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-primary transition-colors"
              >
                {{ $item['letter'] }}
              </a>
            @else
              <span
                class="inline-flex items-center justify-center size-10 font-poppins text-sm text-black/25 select-none"
                aria-disabled="true"
              >
                {{ $item['letter'] }}
              </span>
            @endif
          </li>
        @endforeach
      </ul>

      <div class="shrink-0" data-slider-arrows>
        <button
          type="button"
          class="flex items-center justify-center size-10 rounded-full border border-[#19121e] text-[#19121e] transition-colors hover:bg-[#19121e] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary disabled:opacity-30 disabled:pointer-events-none cursor-pointer"
          aria-label="Następne litery"
          data-slider-next
        >
          <x-icons.arrow-right class="size-4" />
        </button>
      </div>

    </div>
  </nav>
@endif
