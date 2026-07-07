<section class="mx-auto max-w-[1440px] relative h-[520px] lg:h-[672px]">
  {{-- Background Image + Overlay --}}
  @if ($heroImage)
    <img
      src="{{ $heroImage['url'] }}"
      alt="{{ $heroImage['alt'] ?? '' }}"
      class="absolute inset-0 size-full object-cover object-top"
    >
  @endif
  <div class="absolute inset-0 bg-black/50"></div>

  {{-- Content --}}
  <div class="relative flex items-end h-full px-4 lg:px-20 py-12 lg:py-20">
    <div class="flex flex-col lg:flex-row lg:items-end w-full gap-8">

      {{-- Left: Text + CTA --}}
      <div class="flex flex-col gap-5 flex-1">
        @if ($heroTitle)
          <h1 class="font-poppins text-[30px] lg:text-[36px] text-white leading-normal">
            {{ $heroTitle }}
          </h1>
        @endif

        @if ($heroDescription)
          <p class="hidden lg:block font-poppins text-base text-white leading-normal">
            {{ $heroDescription }}
          </p>
        @endif

        @if ($heroButtonText && $heroButtonUrl)
          <div>
            <x-button
              :label="$heroButtonText"
              :href="$heroButtonUrl"
              variant="primary"
              size="lg"
              icon="right"
              class="w-full lg:w-auto border-white whitespace-nowrap text-sm lg:text-base px-4 lg:px-6"
              :iconSvg="'<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\' stroke=\'currentColor\' class=\'size-6\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3\' /></svg>'"
            />
          </div>
        @endif
      </div>

      {{-- Right: Service Card (desktop only) --}}
      @if ($heroCardTitle)
        <div class="hidden lg:flex flex-col gap-4 w-[230px] shrink-0 backdrop-blur-[10px] bg-white/20 rounded-[5px] shadow-[1px_1px_20px_0px_rgba(0,0,0,0.1)] pt-2.5 pb-5 px-2.5">
          @if ($heroCardImage)
            <img
              src="{{ $heroCardImage['url'] }}"
              alt="{{ $heroCardImage['alt'] ?? '' }}"
              class="w-full h-[155px] object-cover rounded-[5px]"
            >
          @endif

          <div class="flex flex-col gap-2 px-2.5">
            <p class="font-poppins font-bold text-lg leading-7 text-white">
              {{ $heroCardTitle }}
            </p>

            @if ($heroCardLinkText && $heroCardLinkUrl)
              <a
                href="{{ $heroCardLinkUrl }}"
                class="inline-flex items-center gap-1.5 border border-white rounded px-2.5 py-0.5 font-poppins text-sm text-white leading-6 hover:bg-white/10 transition-colors w-fit"
              >
                {{ $heroCardLinkText }}
                <x-icons.arrow-right class="size-4" />
              </a>
            @endif
          </div>
        </div>
      @endif

    </div>
  </div>
</section>
