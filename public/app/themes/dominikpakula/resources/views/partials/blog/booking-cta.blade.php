{{-- Booking CTA — dark, center-aligned, wire to .booking-trigger modal --}}
<section class="bg-primary text-white">
  <div class="mx-auto max-w-[1440px] px-4 lg:px-20 py-16 lg:py-24 flex flex-col items-center gap-5 text-center">

    <span class="font-metro text-xs uppercase tracking-[3px] text-white/60">
      Porozmawiajmy
    </span>

    <h2 class="font-poppins text-[30px] lg:text-5xl leading-tight max-w-[640px]">
      Chcesz indywidualnej porady?
    </h2>

    <p class="font-poppins text-lg text-white/85 leading-relaxed max-w-[540px]">
      Umów konsultację i omówmy Twój styl — bez zobowiązań, w dogodnym terminie.
    </p>

    <button
      type="button"
      class="booking-trigger inline-flex items-center gap-2 bg-white text-black font-poppins font-medium text-base px-8 py-4 rounded-sm hover:bg-white/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-primary transition-colors cursor-pointer mt-2"
    >
      <span>Zarezerwuj rozmowę</span>
      <x-icons.arrow-right class="size-5" />
    </button>

  </div>
</section>
