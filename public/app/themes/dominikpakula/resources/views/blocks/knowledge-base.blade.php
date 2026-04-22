<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:pt-0 lg:pb-12">
  <div class="flex flex-col lg:flex-row lg:gap-10 lg:items-end">

    {{-- Lewa: najnowszy wpis blogowy --}}
    @if ($latestPost)
      <a
        href="{{ $latestPost['url'] }}"
        class="relative flex flex-col gap-2.5 justify-end p-4 h-[367px] lg:flex-1 overflow-hidden group mb-6 lg:mb-0"
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

        <h3 class="relative font-poppins font-semibold text-2xl leading-[26px] lg:text-[30px] lg:leading-[38px] text-black z-10">
          {{ $latestPost['title'] }}
        </h3>
        <span class="relative font-sans font-bold text-xs leading-[14px] text-[#4158f2] z-10">
          Czytaj  Więcej >
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
        <a href="{{ home_url('/poradniki/') }}" class="font-sans font-bold text-base leading-[18px] text-[#4158f2]">
          Zobacz  Więcej >
        </a>
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
                <span class="font-sans font-bold text-xs leading-[14px] text-[#4158f2]">
                  Czytaj  Więcej >
                </span>
              </div>
            </a>
          @endforeach
        </div>
      @endif

    </div>

  </div>
</section>
