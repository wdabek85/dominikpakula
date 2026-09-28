{{-- CTA rezerwacji na końcu treści usługi — ciemna karta, przycisk otwiera modal rezerwacji (.booking-trigger) --}}
<div class="py-10 lg:py-14">
  <div class="relative overflow-hidden rounded-lg bg-primary px-6 py-10 lg:px-12 lg:py-14 text-white">

    <div class="flex flex-col gap-4 lg:gap-5 max-w-2xl">
      @if ($eyebrow)
        <p class="font-metro text-sm uppercase tracking-wider text-white/75">
          {{ $eyebrow }}
        </p>
      @endif

      <h2 class="font-poppins text-2xl lg:text-[28px] font-semibold leading-tight text-white">
        {{ $heading }}
      </h2>

      @if ($text)
        <p class="font-poppins text-base leading-relaxed text-white/85">
          {{ $text }}
        </p>
      @endif
    </div>

    <div class="mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4">
      <x-button
        variant="light"
        size="sm"
        :label="$buttonText"
        class="booking-trigger cursor-pointer"
        :data-service="$service"
      />

      @if ($secondaryText)
        <x-button variant="outline-light" size="sm" :href="$secondaryUrl" :label="$secondaryText" />
      @endif
    </div>

  </div>
</div>
