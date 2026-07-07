{{-- Blok "Opis Usługi / Video CTA" — zdjęcie + CTA otwierające modal "Poznaj mnie".
     Treść modala: Ustawienia → "Sekcja: Poznaj mnie". Modal globalny w layouts/app. --}}
<div class="py-10 lg:py-14">
  <section class="relative h-[400px] lg:h-[420px] overflow-hidden rounded-sm">
    {{-- Tło --}}
    <img
      src="{{ Vite::asset('resources/images/video-bg.jpg') }}"
      alt=""
      aria-hidden="true"
      class="absolute inset-0 size-full object-cover object-top"
      loading="lazy"
    >
    <div class="absolute inset-0 bg-black/40"></div>

    {{-- Treść --}}
    <div class="relative flex flex-col justify-end h-full px-5 lg:px-8 py-6 gap-4 lg:gap-6">
      <h2 class="font-sans font-medium text-[26px] lg:text-[34px] text-white leading-tight max-w-[16ch]">
        Zanim zaczniemy poznaj mnie
      </h2>

      <button
        type="button"
        class="about-trigger inline-flex items-center justify-center w-fit bg-primary border border-white px-6 py-3 font-sans text-sm text-white transition-colors hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-white cursor-pointer"
        aria-haspopup="dialog"
        aria-controls="about-modal"
      >
        Poznaj mnie
      </button>
    </div>
  </section>
</div>
