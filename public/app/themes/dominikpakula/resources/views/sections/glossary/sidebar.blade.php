{{--
  Sidebar hasła: wyszukiwarka (filtr na żywo) + akordeon liter z własnym scrollem.
  Litera bieżącego hasła rozwinięta, samo hasło wyróżnione. Logika: resources/js/components/glossary-sidebar.js
--}}
@if (! empty($sidebarGroups))
  <aside class="flex flex-col gap-4 bg-[#f2f2f2] rounded-sm p-4 lg:p-5" aria-labelledby="glossary-sidebar-heading" data-glossary-sidebar>
    <h2 id="glossary-sidebar-heading" class="sr-only">Wszystkie hasła słowniczka</h2>

    {{-- Wyszukiwarka --}}
    <div class="relative">
      <label for="glossary-search" class="sr-only">Szukaj hasła</label>
      <x-icons.magnifying-glass class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-black/60 pointer-events-none" />
      <input
        id="glossary-search"
        type="search"
        placeholder="Szukaj hasła"
        autocomplete="off"
        class="w-full h-14 pl-12 pr-4 bg-white border border-black/15 rounded-sm font-poppins text-base text-black placeholder:text-black/60 focus:outline-none focus:border-primary focus-visible:ring-2 focus-visible:ring-primary"
        data-glossary-search
      >
    </div>

    {{-- Akordeon liter --}}
    <div class="relative max-h-[640px] overflow-y-auto overscroll-contain pr-1 flex flex-col gap-2 [scrollbar-width:thin]" data-glossary-list>
      @foreach ($sidebarGroups as $group)
        <div class="bg-white rounded-sm" data-glossary-group data-initial-open="{{ $group['open'] ? 'true' : 'false' }}">
          <h3>
            <button
              type="button"
              id="{{ $group['id'] }}-toggle"
              class="w-full flex items-center justify-between gap-4 px-4 py-3 font-poppins text-lg text-left cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-primary {{ $group['open'] ? 'text-accent' : 'text-black' }}"
              aria-expanded="{{ $group['open'] ? 'true' : 'false' }}"
              aria-controls="{{ $group['id'] }}-panel"
              data-glossary-toggle
            >
              <span>{{ $group['letter'] }}</span>
              <x-icons.chevron-down class="size-4 shrink-0 transition-transform {{ $group['open'] ? 'rotate-180' : '' }}" />
            </button>
          </h3>

          <ul
            id="{{ $group['id'] }}-panel"
            class="flex flex-col gap-2 px-4 pb-4"
            aria-labelledby="{{ $group['id'] }}-toggle"
            @unless ($group['open']) hidden @endunless
            data-glossary-panel
          >
            @foreach ($group['terms'] as $term)
              <li data-glossary-term="{{ $term['title'] }}">
                <a
                  href="{{ $term['link'] }}"
                  class="font-poppins text-base transition-colors focus:outline-none focus-visible:underline focus-visible:ring-2 focus-visible:ring-primary {{ $term['current'] ? 'text-accent font-medium' : 'text-black hover:text-primary hover:underline underline-offset-4' }}"
                  @if ($term['current']) aria-current="page" @endif
                >
                  {{ $term['title'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach

      <p class="font-poppins text-sm text-black/70 px-1 py-2" aria-live="polite" hidden data-glossary-empty>
        Brak haseł pasujących do wyszukiwania.
      </p>
    </div>
  </aside>
@endif
