<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:pt-0 lg:pb-12">
  <div class="flex flex-col lg:flex-row lg:gap-10 lg:items-end">

    {{-- Lewa: najnowszy wpis blogowy --}}
    @if ($latestPost)
      <a
        href="{{ $latestPost['url'] }}"
        class="relative flex flex-col gap-2.5 justify-end p-4 h-[367px] lg:flex-1 overflow-hidden group mb-6 lg:mb-0 rounded-sm"
      >
        @if ($latestPost['image'])
          <img
            src="{{ $latestPost['image'] }}"
            alt=""
            class="absolute inset-0 size-full object-cover"
            loading="lazy"
          >
        @else
          <div class="absolute inset-0 bg-gray-200" aria-hidden="true"></div>
        @endif

        {{-- Dark gradient overlay (jak w service hero) — czytelność białego tekstu --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/50 to-black/20 pointer-events-none"></div>

        <h3 class="relative font-poppins font-semibold text-2xl leading-[26px] lg:text-[30px] lg:leading-[38px] text-white z-10">
          {{ $latestPost['title'] }}
        </h3>
        <span class="relative font-sans font-bold text-xs leading-[14px] text-accent z-10 group-hover:underline">
          Czytaj Więcej &rarr;
        </span>
      </a>
    @endif

    {{-- Prawa: poradniki --}}
    <div class="lg:w-[375px] shrink-0 flex flex-col gap-4">

      {{-- Nagłówek --}}
      <div class="flex items-center gap-4">
        <h3 class="font-sans font-medium text-[30px] leading-[38px] text-[#1d1d1d]">
          Poradniki
        </h3>
        @if ($guides)
          <a href="{{ home_url('/poradniki/') }}" class="font-sans font-bold text-base leading-[18px] text-accent hover:underline">
            Zobacz Więcej &rarr;
          </a>
        @endif
      </div>

      {{-- Lista poradników --}}
      @if ($guides)
        <div class="flex flex-col gap-2">
          @foreach ($guides as $guide)
            <a href="{{ $guide['url'] }}" class="flex gap-2 items-start group">
              @if ($guide['image'])
                <div class="w-[160px] h-[86px] rounded-[2px] overflow-hidden shrink-0">
                  <img
                    src="{{ $guide['image'] }}"
                    alt=""
                    class="size-full object-cover"
                    width="160"
                    height="86"
                    loading="lazy"
                  >
                </div>
              @else
                <div class="w-[160px] h-[86px] rounded-[2px] bg-gray-100 shrink-0"></div>
              @endif

              <div class="flex flex-col gap-2 min-w-0 flex-1">
                <p class="font-sans font-medium text-base leading-[18px] text-black group-hover:text-primary transition-colors">
                  {{ $guide['title'] }}
                </p>
                @if (!empty($guide['excerpt']))
                  <p class="font-sans text-xs leading-snug text-gray-500 line-clamp-2">
                    {{ $guide['excerpt'] }}
                  </p>
                @endif
                <span class="font-sans font-bold text-xs leading-[14px] text-accent group-hover:underline">
                  Czytaj Więcej &rarr;
                </span>
              </div>
            </a>
          @endforeach
        </div>
      @else
        {{-- Pusty stan — jeszcze brak poradników, ale w drodze --}}
        <div class="flex flex-col items-center gap-2 text-center bg-[#f1f1f1] rounded-sm px-5 py-8">
          <span class="flex items-center justify-center size-12 rounded-full bg-white text-primary mb-1 shrink-0">
            <x-icons.document class="size-6" />
          </span>
          <p class="font-sans font-medium text-base leading-tight text-black">
            Poradniki są już w drodze
          </p>
          <p class="font-sans text-sm leading-relaxed text-black/60">
            Jeszcze nic tu nie ma, ale wkrótce pojawią się pierwsze praktyczne poradniki o stylu.
          </p>
        </div>
      @endif

    </div>

  </div>
</section>
