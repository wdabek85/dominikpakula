<x-section>

  {{-- Nagłówek: etykieta + linia + heading --}}
  <div class="flex flex-col lg:flex-row lg:items-start gap-6 lg:gap-[87px] mb-6">
    @if ($label)
      <x-eyebrow :label="$label" variant="large" class="shrink-0" />
    @endif

    @if ($title)
      <x-heading>{!! $title !!}</x-heading>
    @endif
  </div>

  {{-- Grid kart --}}
  @if ($cards)
    {{-- Tablet w pionie (md): 2 kolumny zamiast jednej --}}
    <div class="grid grid-cols-1 md:grid-cols-2 {{ $gridColumns }} gap-6 mb-6">
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
  @if ($buttonText && $buttonUrl)
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

</x-section>
