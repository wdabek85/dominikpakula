<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

  {{-- Nagłówek: etykieta + linia + heading --}}
  <div class="flex flex-col lg:flex-row lg:items-start gap-6 lg:gap-[87px] mb-6">
    <div class="flex items-center gap-6 shrink-0">
      @if ($label)
        <span class="font-metro text-2xl leading-none text-[#19121e] tracking-[6px] whitespace-nowrap">
          {{ $label }}
        </span>
      @endif
      <div class="h-px bg-[#19121e] w-[180px] hidden lg:block"></div>
      <div class="h-px bg-[#19121e] flex-1 lg:hidden"></div>
    </div>

    @if ($title)
      <h2 class="font-poppins text-[30px] leading-none text-[#19121e]">
        {!! $title !!}
      </h2>
    @endif
  </div>

  {{-- Grid kart --}}
  @if ($cards)
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
      @foreach ($cards as $card)
        <x-service-card
          :variant="$cardVariant"
          :category="$cardVariant === 'detailed' ? 'Specjalna oferta' : ''"
          :title="$card['title']"
          :icon="$card['icon']"
          :description="$card['description']"
          :price="$card['price']"
          :link-text="$card['linkText']"
          :link-url="$card['linkUrl']"
        />
      @endforeach
    </div>
  @endif

  {{-- CTA --}}
  @if ($buttonText)
    <div class="flex justify-center lg:justify-start">
      <x-button
        :label="$buttonText"
        :href="$buttonUrl"
        variant="primary"
        size="lg"
        icon="right"
        class="w-full lg:w-auto"
      />
    </div>
  @endif

</section>
