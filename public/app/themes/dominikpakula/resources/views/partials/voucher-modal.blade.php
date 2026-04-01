{{-- Voucher Modal --}}
<div
  id="voucher-modal"
  class="fixed inset-0 z-[60] hidden"
  aria-modal="true"
  role="dialog"
  aria-label="Zamów voucher"
>
  {{-- Overlay --}}
  <div class="absolute inset-0 bg-black/60" data-voucher-close></div>

  {{-- Modal --}}
  <div class="absolute inset-4 lg:inset-auto lg:top-1/2 lg:left-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2 lg:w-full lg:max-w-lg bg-white rounded-lg shadow-2xl flex flex-col max-h-[calc(100vh-2rem)] overflow-hidden">

    {{-- Header — voucher accent (#282435) --}}
    <div class="flex items-center justify-between px-6 py-4 bg-[#282435] shrink-0 rounded-t-lg">
      <div class="flex items-center gap-3">
        <button
          id="voucher-back"
          class="hidden text-white/60 hover:text-white transition-colors"
          aria-label="Wróć"
          data-voucher-back
        >
          <svg class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
          </svg>
        </button>
        <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
        </svg>
        <h2 class="font-poppins font-semibold text-lg text-white">Kup voucher</h2>
      </div>
      <button data-voucher-close class="text-white/60 hover:text-white transition-colors" aria-label="Zamknij">
        <x-icons.x-mark class="size-6" />
      </button>
    </div>

    {{-- Step indicator --}}
    <div class="flex items-center justify-between px-6 py-3 border-b border-gray-50 shrink-0">
      <div class="flex items-center gap-1.5" data-vstep-indicator="1">
        <span data-vstep-dot="1" class="size-6 rounded-full bg-[#282435] text-white flex items-center justify-center font-poppins text-xs font-medium transition-colors">1</span>
        <span class="font-poppins text-xs text-black hidden sm:inline" data-vstep-label="1">Usługa</span>
      </div>
      <div class="flex-1 h-px bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-1.5" data-vstep-indicator="2">
        <span data-vstep-dot="2" class="size-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-poppins text-xs font-medium transition-colors">2</span>
        <span class="font-poppins text-xs text-gray-400 hidden sm:inline" data-vstep-label="2">Obdarowany</span>
      </div>
      <div class="flex-1 h-px bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-1.5" data-vstep-indicator="3">
        <span data-vstep-dot="3" class="size-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-poppins text-xs font-medium transition-colors">3</span>
        <span class="font-poppins text-xs text-gray-400 hidden sm:inline" data-vstep-label="3">Twoje dane</span>
      </div>
      <div class="flex-1 h-px bg-gray-200 mx-2"></div>
      <div class="flex items-center gap-1.5" data-vstep-indicator="4">
        <span data-vstep-dot="4" class="size-6 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-poppins text-xs font-medium transition-colors">4</span>
        <span class="font-poppins text-xs text-gray-400 hidden sm:inline" data-vstep-label="4">Gotowe</span>
      </div>
    </div>

    {{-- Content --}}
    <div class="flex-1 overflow-y-auto px-6 py-6" id="voucher-content">

      {{-- Step 1: Wybór usługi --}}
      <div data-voucher-step="1">
        <div class="mb-5">
          <h3 class="font-poppins font-semibold text-base text-black mb-1">Na jaką usługę voucher?</h3>
          <p class="font-poppins text-xs text-gray-400">Wybierz usługę którą chcesz podarować</p>
        </div>
        <div class="flex flex-col gap-2" id="voucher-services-list">
          {{-- JS wypełni --}}
        </div>
      </div>

      {{-- Step 2: Dane obdarowanego --}}
      <div data-voucher-step="2" class="hidden">
        <div class="mb-5">
          <div class="flex items-center justify-between bg-gray-50 rounded-sm p-3 mb-3">
            <div class="flex flex-col gap-0.5">
              <span class="font-poppins text-[10px] text-gray-400 uppercase tracking-wider">Voucher na</span>
              <span class="font-poppins font-semibold text-sm text-black" id="voucher-selected-service"></span>
            </div>
            <button type="button" class="font-poppins text-xs text-[#282435] underline cursor-pointer" id="voucher-change-service">Zmień</button>
          </div>
          <h3 class="font-poppins font-semibold text-base text-black mb-1">Dane obdarowanej osoby</h3>
          <p class="font-poppins text-xs text-gray-400">Dla kogo jest ten prezent?</p>
        </div>

        <div class="flex flex-col gap-4" id="voucher-recipient-form">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="voucher-recipient-first" class="block font-poppins text-xs text-gray-500 mb-1">Imię *</label>
              <input type="text" id="voucher-recipient-first" required
                class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
                placeholder="Imię obdarowanego">
            </div>
            <div>
              <label for="voucher-recipient-last" class="block font-poppins text-xs text-gray-500 mb-1">Nazwisko</label>
              <input type="text" id="voucher-recipient-last"
                class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
                placeholder="Nazwisko (opcjonalnie)">
            </div>
          </div>
          <div>
            <label for="voucher-recipient-email" class="block font-poppins text-xs text-gray-500 mb-1">E-mail obdarowanego (opcjonalnie)</label>
            <input type="email" id="voucher-recipient-email"
              class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
              placeholder="Jeśli chcesz, żebyśmy wysłali info">
          </div>

          <button type="button" id="voucher-to-step3"
            class="w-full bg-[#282435] text-white font-poppins font-medium text-sm rounded-sm px-4 py-3 hover:opacity-90 transition-opacity flex items-center justify-center gap-2 cursor-pointer">
            Dalej — Twoje dane
            <x-icons.arrow-right class="size-4" />
          </button>
        </div>
      </div>

      {{-- Step 3: Dane zamawiającego --}}
      <div data-voucher-step="3" class="hidden">
        <div class="mb-5">
          <h3 class="font-poppins font-semibold text-base text-black mb-1">Twoje dane kontaktowe</h3>
          <p class="font-poppins text-xs text-gray-400">Wyślemy Ci instrukcję zakupu i szczegóły vouchera</p>
        </div>

        <form id="voucher-form" class="flex flex-col gap-4">
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label for="voucher-buyer-first" class="block font-poppins text-xs text-gray-500 mb-1">Imię *</label>
              <input type="text" id="voucher-buyer-first" required
                class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
                placeholder="Twoje imię">
            </div>
            <div>
              <label for="voucher-buyer-last" class="block font-poppins text-xs text-gray-500 mb-1">Nazwisko *</label>
              <input type="text" id="voucher-buyer-last" required
                class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
                placeholder="Twoje nazwisko">
            </div>
          </div>

          <div>
            <label for="voucher-buyer-email" class="block font-poppins text-xs text-gray-500 mb-1">E-mail *</label>
            <input type="email" id="voucher-buyer-email" required
              class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
              placeholder="twoj@email.pl">
          </div>

          <div>
            <label for="voucher-buyer-phone" class="block font-poppins text-xs text-gray-500 mb-1">Telefon *</label>
            <input type="tel" id="voucher-buyer-phone" required
              class="w-full border border-gray-200 rounded-sm px-3 py-2.5 font-poppins text-sm text-black placeholder:text-gray-400 focus:border-primary focus:outline-none transition-colors"
              placeholder="+48 000 000 000">
          </div>

          <label class="flex items-start gap-2 cursor-pointer">
            <input type="checkbox" id="voucher-gdpr" required
              class="mt-1 size-4 accent-primary shrink-0">
            <span class="font-poppins text-xs text-gray-500 leading-relaxed">
              Wyrażam zgodę na przetwarzanie moich danych osobowych zgodnie z
              <a href="/polityka-prywatnosci" class="text-primary underline" target="_blank">polityką prywatności</a>.
            </span>
          </label>

          <div id="voucher-form-error" class="hidden font-poppins text-xs text-red-500"></div>

          <button type="submit"
            class="w-full bg-[#282435] text-white font-poppins font-medium text-sm rounded-sm px-4 py-3 hover:opacity-90 transition-opacity flex items-center justify-center gap-2 cursor-pointer">
            Zamów voucher
            <x-icons.arrow-right class="size-4" />
          </button>

          <p class="font-poppins text-[10px] text-gray-400 text-center">
            <svg class="size-3 inline-block mr-0.5 -mt-px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
            Nie pobieramy płatności online — skontaktujemy się z instrukcją
          </p>
        </form>
      </div>

      {{-- Step 4: Potwierdzenie --}}
      <div data-voucher-step="4" class="hidden">
        <div class="flex flex-col items-center gap-4 py-8 text-center">
          <div class="size-16 rounded-full bg-[#282435]/10 flex items-center justify-center">
            <svg class="size-8 text-[#282435]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
            </svg>
          </div>
          <h3 class="font-poppins font-semibold text-xl text-black">Zamówienie przyjęte!</h3>
          <p class="font-poppins text-sm text-gray-500 max-w-xs" id="voucher-success-message">
            Wysłaliśmy instrukcję zakupu vouchera na Twój adres e-mail. Skontaktujemy się w ciągu 24h.
          </p>
          <div class="flex items-center gap-2 mt-2 text-gray-400">
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
            <span class="font-poppins text-xs">Sprawdź swoją skrzynkę e-mail</span>
          </div>
          <button data-voucher-close
            class="mt-4 bg-[#282435] text-white font-poppins text-sm rounded-sm px-6 py-2.5 hover:opacity-90 transition-opacity cursor-pointer">
            Zamknij
          </button>
        </div>
      </div>

    </div>
  </div>
</div>
