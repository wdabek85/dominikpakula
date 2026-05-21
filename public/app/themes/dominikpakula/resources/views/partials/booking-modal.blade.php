{{-- Booking Modal --}}
<div
  id="booking-modal"
  class="fixed inset-0 z-[60] hidden"
  aria-modal="true"
  role="dialog"
  aria-label="Rezerwacja rozmowy"
>
  {{-- Overlay --}}
  <div class="absolute inset-0 bg-black/60" data-booking-close></div>

  {{-- Modal --}}
  <div class="absolute inset-4 lg:inset-auto lg:top-1/2 lg:left-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2 lg:w-full lg:max-w-lg bg-white rounded-lg shadow-2xl flex flex-col max-h-[calc(100vh-2rem)] overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
      <div class="flex items-center gap-3">
        <button
          id="booking-back"
          class="hidden text-gray-400 hover:text-black transition-colors"
          aria-label="Wróć do poprzedniego kroku"
          data-booking-back
        >
          <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </button>
        <h2 class="font-poppins font-semibold text-lg text-black" id="booking-modal-title">Zarezerwuj rozmowę</h2>
      </div>
      <button data-booking-close class="text-gray-400 hover:text-black transition-colors" aria-label="Zamknij">
        <x-icons.x-mark class="size-6" />
      </button>
    </div>

    {{-- Step indicator with labels --}}
    <div class="flex items-center justify-between px-6 py-3 border-b border-gray-50 shrink-0">
      <div class="flex items-center gap-1.5" data-step-indicator="1">
        <span data-step-dot="1" class="size-6 rounded-full bg-primary text-white flex items-center justify-center font-poppins text-xs font-medium transition-colors">1</span>
        <span class="font-poppins text-xs text-black hidden sm:inline" data-step-label="1">Usługa</span>
      </div>
      <div class="flex-1 h-px bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-1.5" data-step-indicator="2">
        <span data-step-dot="2" class="size-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-poppins text-xs font-medium transition-colors">2</span>
        <span class="font-poppins text-xs text-gray-400 hidden sm:inline" data-step-label="2">Termin</span>
      </div>
      <div class="flex-1 h-px bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-1.5" data-step-indicator="3">
        <span data-step-dot="3" class="size-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-poppins text-xs font-medium transition-colors">3</span>
        <span class="font-poppins text-xs text-gray-400 hidden sm:inline" data-step-label="3">Dane</span>
      </div>
      <div class="flex-1 h-px bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-1.5" data-step-indicator="4">
        <span data-step-dot="4" class="size-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-poppins text-xs font-medium transition-colors">4</span>
        <span class="font-poppins text-xs text-gray-400 hidden sm:inline" data-step-label="4">Gotowe</span>
      </div>
    </div>

    {{-- Content area --}}
    <div class="flex-1 overflow-y-auto px-6 py-6" id="booking-content">

      {{-- Step 1: Wybór usługi --}}
      <div data-booking-step="1">
        <div class="mb-5">
          <h3 class="font-poppins font-semibold text-base text-black mb-1">Wybierz usługę</h3>
          <p class="font-poppins text-xs text-gray-400">Wybierz usługę, którą chcesz omówić</p>
        </div>
        <div class="flex flex-col gap-2" id="booking-services-list">
          {{-- JS wypełni dynamicznie --}}
        </div>
      </div>

      {{-- Step 2: Kalendarz --}}
      <div data-booking-step="2" class="hidden">
        <div class="mb-5">
          <div class="flex items-center justify-between bg-gray-50 rounded-sm p-3 mb-3">
            <div class="flex flex-col gap-0.5">
              <span class="font-poppins text-[10px] text-gray-400 uppercase tracking-wider">Wybrana usługa</span>
              <span class="font-poppins font-semibold text-sm text-black" id="booking-selected-service"></span>
            </div>
            <button
              type="button"
              class="font-poppins text-xs text-primary underline cursor-pointer"
              id="booking-change-service"
            >
              Zmień
            </button>
          </div>
          <h3 class="font-poppins font-semibold text-base text-black mb-1">Wybierz termin</h3>
          <p class="font-poppins text-xs text-gray-400">Wybierz wolny dzień z kalendarza</p>
        </div>

        <div id="booking-calendar">
          {{-- JS generuje kalendarz --}}
        </div>

        {{-- Legenda --}}
        <div class="flex items-center gap-4 mt-4 pt-4 border-t border-gray-100">
          <div class="flex items-center gap-1.5">
            <span class="size-3 rounded-full border-2 border-primary"></span>
            <span class="font-poppins text-[10px] text-gray-400">Dziś</span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="size-3 rounded-full bg-red-50 border border-red-200"></span>
            <span class="font-poppins text-[10px] text-gray-400">Zajęty</span>
          </div>
          <div class="flex items-center gap-1.5">
            <span class="size-3 rounded-full bg-gray-100"></span>
            <span class="font-poppins text-[10px] text-gray-400">Niedostępny</span>
          </div>
        </div>
      </div>

      {{-- Step 3: Formularz --}}
      <div data-booking-step="3" class="hidden">
        <div class="mb-5">
          <div class="flex items-center gap-2 mb-2">
            <span class="font-poppins text-xs bg-primary text-white rounded-sm px-2 py-0.5" id="booking-confirm-service"></span>
            <span class="font-poppins text-xs bg-gray-100 text-black rounded-sm px-2 py-0.5" id="booking-confirm-date"></span>
          </div>
          <h3 class="font-poppins font-semibold text-base text-black mb-1">Podaj swoje dane</h3>
          <p class="font-poppins text-xs text-gray-400">Potrzebujemy ich żeby potwierdzić termin rozmowy</p>
        </div>

        <form id="booking-form" class="flex flex-col gap-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="booking-first-name" class="block font-poppins text-xs text-gray-500 mb-1">Imię</label>
              <input type="text" id="booking-first-name" name="first_name" required
                class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
                placeholder="Jan">
            </div>
            <div>
              <label for="booking-last-name" class="block font-poppins text-xs text-gray-500 mb-1">Nazwisko</label>
              <input type="text" id="booking-last-name" name="last_name" required
                class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
                placeholder="Kowalski">
            </div>
          </div>

          <div>
            <label for="booking-phone" class="block font-poppins text-xs text-gray-500 mb-1">Telefon</label>
            <input type="tel" id="booking-phone" name="phone" required
              class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
              placeholder="+48 000 000 000">
          </div>

          <div>
            <label for="booking-email" class="block font-poppins text-xs text-gray-500 mb-1">E-mail</label>
            <input type="email" id="booking-email" name="email" required
              class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
              placeholder="jan@email.pl">
          </div>

          <label class="flex items-start gap-2 cursor-pointer">
            <input type="checkbox" id="booking-gdpr" name="gdpr" required
              class="mt-1 size-4 accent-primary shrink-0">
            <span class="font-poppins text-xs text-gray-500 leading-relaxed">
              Wyrażam zgodę na przetwarzanie moich danych osobowych w celu realizacji rezerwacji zgodnie z
              <a href="/polityka-prywatnosci" class="text-primary underline" target="_blank">polityką prywatności</a>.
            </span>
          </label>

          <div id="booking-form-error" class="hidden font-poppins text-xs text-red-500"></div>

          <button type="submit"
            class="w-full bg-primary text-white font-poppins font-medium text-sm rounded-sm px-4 py-3 hover:opacity-90 transition-opacity flex items-center justify-center gap-2 cursor-pointer">
            Zarezerwuj rozmowę
            <x-icons.arrow-right class="size-4" />
          </button>

          <p class="font-poppins text-[10px] text-gray-400 text-center">
            <svg class="size-3 inline-block mr-0.5 -mt-px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            Twoje dane są bezpieczne i nie będą udostępniane osobom trzecim
          </p>
        </form>
      </div>

      {{-- Step 4: Potwierdzenie --}}
      <div data-booking-step="4" class="hidden">
        <div class="flex flex-col items-center gap-4 py-8 text-center">
          <div class="size-16 rounded-full bg-green-50 flex items-center justify-center">
            <svg class="size-8 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
          </div>
          <h3 class="font-poppins font-semibold text-xl text-black">Rozmowa zaplanowana!</h3>
          <p class="font-poppins text-sm text-gray-500 max-w-xs" id="booking-success-message">
            Wysłaliśmy szczegóły rozmowy na Twój adres e-mail. Do usłyszenia!
          </p>
          <div class="flex items-center gap-2 mt-2 text-gray-400">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
            <span class="font-poppins text-xs">Sprawdź swoją skrzynkę e-mail</span>
          </div>
          <button data-booking-close
            class="mt-4 bg-primary text-white font-poppins text-sm rounded-sm px-6 py-2.5 hover:opacity-90 transition-opacity cursor-pointer">
            Zamknij
          </button>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- Floating booking button (all pages except single service) --}}
@if (!is_singular('service') && !is_page('voucher'))
<button
  class="booking-trigger fixed bottom-6 right-6 z-50 bg-primary text-white rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2 pl-5 pr-4 py-3 font-poppins font-medium text-sm cursor-pointer"
  aria-label="Zarezerwuj rozmowę"
>
  <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
  </svg>
  Zarezerwuj rozmowę
</button>
@endif
