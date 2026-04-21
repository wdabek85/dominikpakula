<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">

  <div class="flex flex-col lg:flex-row lg:items-start gap-8 lg:gap-20">

    {{-- Lewa kolumna — dane kontaktowe --}}
    <div class="flex flex-col gap-6 flex-1">

      {{-- Nagłówek --}}
      <div class="flex flex-col gap-4 text-[#01000d]">
        <p class="font-poppins font-medium text-lg leading-[22px]">Kontakt</p>
        <div class="flex flex-col gap-2">
          <h2 class="font-poppins font-medium text-5xl leading-[48px] tracking-[-0.96px]">
            Masz do mnie jakieś pytania?
          </h2>
          <p class="font-poppins text-base leading-5">
            Napisz, zadzwoń albo wypełnij formularz — odezwę się w ciągu 24 godzin
          </p>
        </div>
      </div>

      {{-- Dane kontaktowe --}}
      <div class="flex flex-col gap-6 text-[#01000d]">

        {{-- Email --}}
        @if ($contact['email'])
          <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1">
              <svg class="size-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
              </svg>
              <span class="font-poppins text-base leading-5">E-mail:</span>
            </div>
            <a href="mailto:{{ $contact['email'] }}" class="font-poppins text-sm leading-4 hover:underline">{{ $contact['email'] }}</a>
          </div>
        @endif

        {{-- Telefon --}}
        @if ($contact['phone'])
          <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1">
              <svg class="size-5 shrink-0" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 013-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 01-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 006.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 011.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 01-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5z" clip-rule="evenodd" />
              </svg>
              <span class="font-poppins text-base leading-5">Telefon</span>
            </div>
            <a href="tel:{{ $contact['phone_link'] ?: $contact['phone'] }}" class="font-poppins text-sm leading-4 hover:underline">{{ $contact['phone'] }}</a>
          </div>
        @endif

        {{-- Adres --}}
        @if ($contact['address_line1'] || $contact['address_line2'])
          <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1">
              <svg class="size-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
              </svg>
              <span class="font-poppins text-base leading-5">Adres:</span>
            </div>
            <p class="font-poppins text-sm leading-4">
              {!! esc_html($contact['address_line1']) !!}@if ($contact['address_line1'] && $contact['address_line2'])<br>@endif
              {!! esc_html($contact['address_line2']) !!}
            </p>
          </div>
        @endif

      </div>
    </div>

    {{-- Prawa kolumna — formularz --}}
    <div class="flex flex-col gap-4 flex-1">
      <form id="contact-form" class="flex flex-col gap-2" novalidate>

        {{-- Honeypot — ukryte dla ludzi, widoczne dla botów --}}
        <div aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;" tabindex="-1">
          <label for="contact-website">Nie wypełniaj tego pola</label>
          <input type="text" id="contact-website" name="website" autocomplete="off" tabindex="-1">
        </div>

        {{-- Imię --}}
        <div class="flex flex-col gap-2">
          <label for="contact-name" class="font-poppins font-semibold text-sm leading-4 text-[#8b8b8b]">Imie</label>
          <input
            type="text"
            id="contact-name"
            name="name"
            placeholder="Twoje Imie"
            class="w-full border border-[#e2e2e2] px-4 py-3 font-poppins font-medium text-base leading-[26px] text-[#8b8b8b] placeholder:text-[#8b8b8b] outline-none focus:border-primary transition-colors"
            required
            autocomplete="given-name"
          >
        </div>

        {{-- Email --}}
        <div class="flex flex-col gap-2">
          <label for="contact-email" class="font-poppins font-semibold text-sm leading-4 text-[#8b8b8b]">E-mail</label>
          <div class="flex items-center gap-2 border border-[#e2e2e2] px-4 py-3 focus-within:border-primary transition-colors">
            <svg class="size-6 shrink-0 text-[#8b8b8b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
            </svg>
            <input
              type="email"
              id="contact-email"
              name="email"
              placeholder="Twój adres e-mail"
              class="w-full font-poppins font-medium text-base leading-[26px] text-[#8b8b8b] placeholder:text-[#8b8b8b] bg-transparent outline-none"
              required
              autocomplete="email"
            >
          </div>
        </div>

        {{-- Wiadomość --}}
        <div class="flex flex-col gap-2">
          <label for="contact-message" class="font-poppins font-semibold text-sm leading-4 text-[#8b8b8b]">Wiadomość</label>
          <textarea
            id="contact-message"
            name="message"
            placeholder="Wprowadź tekst swojej wiadomości.."
            rows="3"
            class="w-full border border-[#e2e2e2] px-4 py-3 font-poppins text-sm leading-4 text-[#8b8b8b] placeholder:text-[#8b8b8b] outline-none resize-none focus:border-primary transition-colors"
            required
          ></textarea>
        </div>

        {{-- GDPR --}}
        <label class="flex items-start gap-2 mt-2 cursor-pointer">
          <input
            type="checkbox"
            id="contact-gdpr"
            name="gdpr"
            class="mt-0.5 size-4 shrink-0 accent-primary"
            required
          >
          <span class="font-poppins text-xs leading-[14px] text-[#01000d]">
            Wyrażam zgodę na przetwarzanie moich danych osobowych zgodnie z
            <a href="{{ home_url('/polityka-prywatnosci/') }}" class="underline">polityką prywatności</a>.*
          </span>
        </label>

        {{-- Komunikaty --}}
        <p id="contact-form-error" class="hidden font-poppins text-sm text-red-600 mt-2" role="alert"></p>
        <p id="contact-form-success" class="hidden font-poppins text-sm text-green-700 mt-2" role="status"></p>

      </form>

      {{-- Disclaimer --}}
      <p class="font-poppins text-xs leading-[14px] text-[#01000d]">
        Odpowiadam w ciągu 24 godzin. Zero spamu, tylko konkret.
      </p>

      {{-- Przycisk --}}
      <button
        type="submit"
        form="contact-form"
        id="contact-form-submit"
        class="w-full bg-primary border border-white px-6 py-4 rounded-sm font-poppins font-medium text-base leading-[26px] text-white transition-colors hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary disabled:opacity-60 disabled:cursor-not-allowed"
      >
        Wyślij
      </button>
    </div>

  </div>

</section>
