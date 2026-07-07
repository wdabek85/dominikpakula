{{-- Blok "Opis Usługi / Video CTA" — zdjęcie + CTA otwierające modal "Poznaj mnie".
     Treść modala: Ustawienia → "Sekcja: Poznaj mnie". Modal globalny w layouts/app. --}}
<div class="py-10 lg:py-14">
  <section class="group relative h-[400px] lg:h-[420px] overflow-hidden rounded-sm">
    {{-- Tło (subtelny zoom na hover) --}}
    <img
      src="{{ Vite::asset('resources/images/video-bg.jpg') }}"
      alt=""
      aria-hidden="true"
      class="absolute inset-0 size-full object-cover object-top transition-transform duration-[600ms] ease-out group-hover:scale-105"
      loading="lazy"
    >
    <div class="absolute inset-0 bg-black/40"></div>

    {{-- Treść: nagłówek po lewej, CTA po prawej (przy dolnej krawędzi) --}}
    <div class="relative flex flex-col justify-end h-full px-5 lg:px-8 py-6">
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 sm:gap-6">
        <h2 class="font-sans font-medium text-[26px] lg:text-[34px] text-white leading-tight max-w-[18ch] shrink">
          Zanim zaczniemy poznaj mnie
        </h2>

        <button
          type="button"
          class="about-trigger group/btn inline-flex items-center justify-center gap-2 shrink-0 w-full sm:w-auto bg-primary border border-white px-6 py-3 font-sans text-sm text-white whitespace-nowrap transition-colors hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer"
          aria-haspopup="dialog"
          aria-controls="about-modal"
        >
          <span>Poznaj mnie</span>
          <x-icons.arrow-right class="size-4 transition-transform group-hover/btn:translate-x-1" />
        </button>
      </div>
    </div>
  </section>
</div>
