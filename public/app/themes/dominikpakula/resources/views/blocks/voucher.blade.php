<section class="bg-[#eff2f7]">
  <div class="mx-auto max-w-[1440px] px-4 lg:px-20 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

    {{-- Zdjęcie lewa — desktop na początku, mobile na końcu --}}
    @if ($imageLeft)
      <div class="order-3 lg:order-1 h-[250px] lg:h-auto lg:self-stretch shrink-0 lg:w-[280px] overflow-hidden">
        <img
          src="{{ $imageLeft }}"
          alt="{{ $imageLeftAlt }}"
          class="size-full object-cover object-top"
          loading="lazy"
          width="280"
          height="300"
        >
      </div>
    @endif

    {{-- Treść — środek --}}
    <div class="order-2 flex-1 flex flex-col gap-8 py-8 lg:py-10 lg:max-w-[516px]">
      <div class="flex flex-col gap-4">
        @if ($title)
          <h2 class="font-poppins text-4xl leading-[38px] text-black">
            {{ $title }}
          </h2>
        @endif

        @if ($description)
          <p class="font-sans text-sm leading-4 text-[#1d1d1d]">
            {{ $description }}
          </p>
        @endif
      </div>

      @if ($buttonText)
        <div>
          @if (is_page('voucher'))
            <button
              class="voucher-trigger bg-primary text-white font-poppins font-medium text-base rounded-sm px-6 py-3 hover:opacity-90 transition-opacity flex items-center gap-2 cursor-pointer"
            >
              {{ $buttonText }}
              <x-icons.arrow-right class="size-5" />
            </button>
          @else
            <x-button
              :label="$buttonText"
              :href="$buttonUrl"
              variant="primary"
              size="lg"
            />
          @endif
        </div>
      @endif
    </div>

    {{-- Voucher obrazek — mobile na początku, desktop na końcu --}}
    @if ($imageRight)
      <div class="order-1 lg:order-3 h-[250px] lg:h-[250px] shrink-0 lg:w-[280px]">
        <img
          src="{{ $imageRight }}"
          alt="{{ $imageRightAlt }}"
          class="size-full object-contain"
          loading="lazy"
          width="312"
          height="325"
        >
      </div>
    @endif

  </div>
</section>
