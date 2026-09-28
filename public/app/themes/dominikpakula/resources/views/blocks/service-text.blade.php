{{-- Tekst w kolumnie usługi. attached = nagłówek + wstęp do bloku poniżej (mniejszy odstęp pod spodem) --}}
@if ($heading || $body || $imageHtml)
  <div class="{{ $attached ? 'pt-10 lg:pt-14 -mb-4 lg:-mb-6' : 'py-10 lg:py-14' }}">

    {{-- Badge --}}
    @if ($label)
      <div class="mb-6 lg:mb-8">
        <x-badge :label="$label" />
      </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8 lg:gap-10">

      {{-- Tekst --}}
      <div class="flex-1 min-w-0">
        @if ($heading)
          <h2 class="font-poppins text-xl font-bold leading-snug text-black {{ $body ? 'mb-4 lg:mb-5' : '' }}">
            {{ $heading }}
          </h2>
        @endif

        @if ($body)
          <div class="prose max-w-none font-poppins text-base leading-relaxed text-black prose-p:my-3 prose-strong:text-black prose-a:font-semibold prose-a:text-black prose-a:underline-offset-2 hover:prose-a:text-primary">
            {!! $body !!}
          </div>
        @endif

        @if ($buttonText)
          <div class="mt-6">
            @if ($buttonUrl)
              <x-button variant="secondary" size="sm" :href="$buttonUrl" :label="$buttonText" />
            @else
              <x-button
                variant="primary"
                size="sm"
                :label="$buttonText"
                class="booking-trigger cursor-pointer"
                :data-service="$bookingService"
              />
            @endif
          </div>
        @endif
      </div>

      {{-- Zdjęcie --}}
      @if ($imageHtml)
        <div class="w-full aspect-[4/5] lg:w-[260px] shrink-0 rounded-sm overflow-hidden bg-[#f1f1f1]">
          {!! $imageHtml !!}
        </div>
      @endif

    </div>

  </div>
@elseif ($block['preview'] ?? false)
  <x-block-placeholder
    title="Tekst (usługa)"
    hint="Pusto — dodaj nagłówek H2 i treść w panelu po prawej."
  />
@endif
