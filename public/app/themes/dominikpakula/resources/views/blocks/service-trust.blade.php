<div class="py-10 lg:py-14">

  <div class="grid grid-cols-1 lg:grid-cols-[240px_1fr]">

    {{-- Lewa karta: szare tło z grafiką + tekst --}}
    <div class="relative rounded-t-sm lg:rounded-t-none lg:rounded-l-sm overflow-hidden bg-[#f2f2f2] min-h-[280px] lg:h-[385px]">
      @if ($leftImage['url'])
        <img
          src="{{ $leftImage['url'] }}"
          alt="{{ $leftImage['alt'] }}"
          class="absolute inset-0 size-full object-cover"
          loading="lazy"
          @if ($leftImage['width']) width="{{ $leftImage['width'] }}" @endif
          @if ($leftImage['height']) height="{{ $leftImage['height'] }}" @endif
        >
      @endif

      @if ($leftText)
        <div class="absolute inset-0 flex flex-col justify-end p-5">
          <p class="font-poppins text-xs leading-relaxed text-black">
            {!! nl2br(e($leftText)) !!}
          </p>
        </div>
      @endif
    </div>

    {{-- Prawa karta: pełne foto + ciemny overlay + tekst biały --}}
    <div class="relative rounded-b-sm lg:rounded-b-none lg:rounded-r-sm overflow-hidden min-h-[280px] lg:h-[385px]">
      @if ($rightImage['url'])
        <img
          src="{{ $rightImage['url'] }}"
          alt="{{ $rightImage['alt'] }}"
          class="absolute inset-0 size-full object-cover"
          loading="lazy"
          @if ($rightImage['width']) width="{{ $rightImage['width'] }}" @endif
          @if ($rightImage['height']) height="{{ $rightImage['height'] }}" @endif
        >
      @endif

      <div class="absolute inset-0 bg-black/20" aria-hidden="true"></div>

      @if ($rightText)
        <div class="absolute inset-0 flex flex-col justify-end p-5">
          <p class="font-poppins text-sm leading-relaxed text-white">
            {!! nl2br(e($rightText)) !!}
          </p>
        </div>
      @endif
    </div>

  </div>

</div>
