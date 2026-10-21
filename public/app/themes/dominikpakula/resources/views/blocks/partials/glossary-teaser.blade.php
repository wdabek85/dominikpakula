{{-- Kafel „Słowniczek” pod listą poradników w bloku Baza Wiedzy (acf/knowledge-base). --}}
@if (! empty($glossary))
  <div class="flex flex-col gap-3 bg-[#f1f1f1] rounded-sm p-5 mt-2">
    <div class="flex items-center justify-between gap-4">
      <h3 class="font-sans font-medium text-2xl leading-tight text-[#1d1d1d]">
        Słowniczek
      </h3>
      <span class="font-metro text-xs uppercase tracking-[3px] text-black/70 whitespace-nowrap">
        {{ $glossary['count'] }}
      </span>
    </div>

    <p class="font-sans text-sm leading-relaxed text-black/70">
      Nie wiesz, czym są brogsy albo poszetka? Pojęcia z męskiej mody i stylizacji wyjaśnione prostym językiem.
    </p>

    @if (! empty($glossary['terms']))
      <ul class="flex flex-wrap gap-2" aria-label="Przykładowe hasła">
        @foreach ($glossary['terms'] as $term)
          <li>
            <a
              href="{{ $term['url'] }}"
              class="inline-flex items-center px-2.5 py-1 rounded-[2px] border border-[#19121e] bg-white font-sans text-sm text-[#19121e] hover:bg-[#19121e] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary transition-colors"
            >
              {{ $term['title'] }}
            </a>
          </li>
        @endforeach
      </ul>
    @endif

    <a href="{{ $glossary['url'] }}" class="self-start font-sans font-bold text-base leading-[18px] text-accent hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-primary">
      Otwórz słowniczek &rarr;
    </a>
  </div>
@endif
