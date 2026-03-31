<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">

  <div class="bg-[#d9d9d9] flex flex-col lg:flex-row items-center gap-8 px-5 lg:px-8 py-6">

    {{-- Treść --}}
    <div class="flex flex-col gap-6 flex-1">

      {{-- Nagłówek + opis --}}
      <div class="flex flex-col gap-4 text-center lg:text-left text-black">
        <h2 class="font-poppins font-medium text-4xl leading-[44px] lg:text-[52px] lg:leading-[56px] lg:tracking-[-1.04px]">
          Bądź na Bieżąco
        </h2>
        <p class="font-poppins text-xs leading-[14px] lg:text-sm lg:leading-4">
          Zapisz się do naszego newslettera i jako pierwszy otrzymuj info o nowych kolekcjach, limitowanych dropach i specjalnych promocjach. Dorzucamy też porady dotyczące stylu, żebyś zawsze wyglądał dobrze – bez względu na okazję.
        </p>
      </div>

      {{-- Formularz --}}
      <div class="flex flex-col gap-2 lg:max-w-[735px] items-center lg:items-start">
        <form class="flex flex-col lg:flex-row gap-4 w-full">
          {{-- Input --}}
          <div class="flex flex-col gap-2 lg:w-[328px] w-full">
            <label for="newsletter-email" class="font-poppins font-semibold text-sm leading-4 text-[#8b8b8b]">
              E-mail
            </label>
            <div class="flex items-center gap-2 bg-white border border-white lg:border-white rounded px-4 py-3">
              <svg class="size-[18px] shrink-0 text-[#8b8b8b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
              </svg>
              <input
                type="email"
                id="newsletter-email"
                name="email"
                placeholder="Twój e-mail"
                class="font-poppins text-sm text-[#8b8b8b] bg-transparent outline-none w-full"
                required
              >
            </div>
          </div>

          {{-- Przycisk --}}
          <div class="lg:self-end w-full lg:w-auto">
            <button
              type="submit"
              class="w-full lg:w-auto bg-primary border border-white px-6 py-3 rounded-sm font-poppins font-medium text-base leading-[26px] text-white whitespace-nowrap transition-colors hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
            >
              Zapisz mnie do Newslettera
            </button>
          </div>
        </form>

        {{-- Disclaimer --}}
        <p class="font-poppins text-[10px] leading-3 lg:text-xs lg:leading-[14px] text-black text-center lg:text-left">
          Zapisując się, akceptujesz nasze <a href="#" class="underline">warunki korzystania z usługi</a>.<br>
          Możesz wypisać się w każdej chwili. Zero spamu, tylko konkret.
        </p>
      </div>

    </div>

    {{-- Zdjęcie --}}
    <div class="size-[250px] lg:size-[325px] shrink-0 rounded overflow-hidden bg-[#c0c0c0]">
      {{-- Placeholder — zamienisz na <img> z właściwym zdjęciem --}}
      <img
        src=""
        alt="Newsletter"
        class="size-full object-cover"
        loading="lazy"
        width="325"
        height="325"
      >
    </div>

  </div>

</section>
