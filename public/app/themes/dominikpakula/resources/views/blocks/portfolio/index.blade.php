<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14 overflow-hidden">

  {{-- Nagłówek --}}
  @if ($title || $subtitle)
    <div class="flex flex-col gap-2.5 mb-5 lg:mb-8">
      @if ($title)
        <h2 class="font-serif text-[32px] leading-none text-[#19121e]">
          {{ $title }}
        </h2>
      @endif

      @if ($subtitle)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $subtitle }}
        </p>
      @endif
    </div>
  @endif

  {{-- Slider z portfolio --}}
  @if ($items)
    <div class="-mr-4 lg:-mr-20 overflow-hidden" data-slider-wrapper>

      {{-- Slider --}}
      <div
        class="flex gap-6 lg:gap-10 overflow-x-auto snap-x snap-mandatory pb-4 pr-4 lg:pr-20 scrollbar-hide select-none"
        role="list"
        aria-label="Realizacje portfolio"
        data-drag-scroll
        data-slider
      >
        @foreach ($items as $item)
          <div class="snap-start shrink-0" role="listitem">
            <x-portfolio-card
              :title="$item['title']"
              :category="$item['category']"
              :image="$item['image']"
              :link="$item['link']"
            />
          </div>
        @endforeach
      </div>

    </div>

    {{-- Strzałki nawigacji — desktop, pod sliderem --}}
    <div class="hidden lg:flex items-center justify-center gap-4 mt-8">
      <button
        class="flex items-center justify-center size-12 rounded-full border border-[#19121e] text-[#19121e] transition-all hover:bg-[#19121e] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary disabled:opacity-30 disabled:pointer-events-none"
        data-slider-prev
        aria-label="Poprzednia realizacja"
        type="button"
      >
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
      </button>

      <button
        class="flex items-center justify-center size-12 rounded-full border border-[#19121e] text-[#19121e] transition-all hover:bg-[#19121e] hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-primary disabled:opacity-30 disabled:pointer-events-none"
        data-slider-next
        aria-label="Następna realizacja"
        type="button"
      >
        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>
  @endif

</section>
