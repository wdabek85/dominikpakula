{{-- Subscribe — 2 karty: Newsletter + Instagram (Instagram ma gradient blob) --}}
<section class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Card A: Newsletter --}}
    <div class="flex flex-col gap-5 bg-[#f1f1f1] p-6 lg:p-10 rounded-sm" data-newsletter>
      <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Newsletter</span>
      <h2 class="font-poppins text-[30px] lg:text-4xl leading-tight text-black">
        Nie przegap kolejnego wpisu
      </h2>
      <p class="font-poppins text-base text-black/80 leading-relaxed">
        Raz w miesiącu wysyłam maila z nowymi poradami o stylu i odpowiedziami na najczęstsze pytania. Bez spamu, bez kiczu.
      </p>

      <form id="newsletter-form" class="flex flex-col gap-3 mt-2" novalidate>

        {{-- Honeypot --}}
        <div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;" tabindex="-1">
          <label for="newsletter-website">Nie wypełniaj tego pola</label>
          <input type="text" id="newsletter-website" name="website" autocomplete="off" tabindex="-1">
        </div>

        <div class="flex flex-col sm:flex-row gap-2">
          <label for="newsletter-email" class="sr-only">Twój adres e-mail</label>
          <input
            type="email"
            id="newsletter-email"
            name="email"
            placeholder="Twój adres e-mail"
            class="flex-1 border border-black/20 bg-white px-4 py-3 font-poppins text-base text-black placeholder:text-black/40 outline-none focus:border-primary transition-colors"
            required
            autocomplete="email"
          >
          <button
            type="submit"
            id="newsletter-submit"
            class="bg-primary text-white font-poppins font-medium text-base px-6 py-3 rounded-sm hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 transition-colors disabled:opacity-60 disabled:cursor-not-allowed cursor-pointer"
          >
            Zapisz się
          </button>
        </div>

        {{-- Zgoda RODO — wymagana (marketing) --}}
        <label class="flex items-start gap-2 font-poppins text-xs text-black/70 leading-relaxed cursor-pointer">
          <input
            type="checkbox"
            name="gdpr"
            required
            class="mt-0.5 size-4 shrink-0 accent-primary focus-visible:ring-2 focus-visible:ring-primary"
          >
          <span>Wyrażam zgodę na otrzymywanie newslettera i akceptuję <a href="{{ home_url('/polityka-prywatnosci/') }}" class="underline hover:text-primary transition-colors">politykę prywatności</a>. Wypisujesz się jednym kliknięciem.</span>
        </label>
      </form>

      <p id="newsletter-disclaimer" data-newsletter-disclaimer class="sr-only" aria-hidden="true"></p>
      <p id="newsletter-error" data-newsletter-error class="hidden font-poppins text-sm text-red-600 leading-relaxed" role="alert"></p>
      <p id="newsletter-success" data-newsletter-success class="hidden font-poppins text-sm text-green-700 leading-relaxed" role="status"></p>
    </div>

    {{-- Card B: Instagram (dark + gradient blob) --}}
    <div class="relative flex flex-col gap-5 bg-[#111111] text-white p-6 lg:p-10 rounded-sm overflow-hidden">

      {{-- Gradient blob — pink → purple → orange, heavy blur --}}
      <div
        class="absolute -top-24 -right-24 size-80 rounded-full bg-gradient-to-br from-pink-500 via-purple-500 to-orange-400 opacity-20 blur-3xl pointer-events-none"
        aria-hidden="true"
      ></div>

      <div class="relative z-10 flex flex-col gap-5">
        <span class="font-metro text-xs uppercase tracking-[3px] text-white/60">Instagram</span>
        <h2 class="font-poppins text-[30px] lg:text-4xl leading-tight">
          Codzienne inspiracje stylowe
        </h2>
        <p class="font-poppins text-base text-white/85 leading-relaxed">
          Pokazuję stylizacje na różne okazje, kawałki z mojej szafy, pytania od klientów i kulisy pracy ze stylistą. Krótkie, konkretne, codziennie.
        </p>

        <a
          href="https://www.instagram.com/dpakula_stylist/"
          target="_blank"
          rel="noopener"
          class="group inline-flex items-center gap-2 bg-white text-black font-poppins font-medium text-sm py-3 px-5 rounded-sm w-fit hover:bg-white/90 transition-colors mt-2"
        >
          <x-icons.instagram class="size-5" />
          <span>Śledź @dpakula_stylist</span>
          <x-icons.arrow-right class="size-4 transition-transform group-hover:translate-x-1" />
        </a>
      </div>
    </div>

  </div>
</section>
