<div class="flex flex-col gap-4">

  {{-- Trustpilot (hardcode) --}}
  <div class="flex items-center gap-3 text-xs text-black">
    <span class="font-bold">Excellent</span>
    <span>
      <span class="font-bold">4.8</span> out of 5
    </span>
    <span class="font-bold">Trustpilot</span>
  </div>

  {{-- Tytuł + opis (ACF) --}}
  <div class="flex flex-col gap-2">
    <h1 class="font-poppins text-2xl leading-none text-primary">
      {{ $sidebarTitle }}
    </h1>

    @if ($sidebarDescription)
      <p class="font-metro text-xs leading-none text-primary">
        {{ $sidebarDescription }}
      </p>
    @endif
  </div>

  {{-- CTA banners (hardcode) --}}
  <div class="flex flex-col gap-2">
    <div class="bg-[#dbdbdb] flex items-center rounded-sm px-3 py-2">
      <p class="font-poppins text-[10px] text-black">
        Umów się na konsultacje
        <span class="text-[#655098]"> - </span>
        <a href="#" class="text-[#655098] underline">Jak to działa?</a>
      </p>
    </div>

    @if ($contact['sidebar_phone'])
      <div class="bg-[#dbdbdb] flex items-center rounded-sm px-3 py-2">
        <p class="text-[10px]">
          <span class="font-sans font-semibold text-black">Zarezerwuj Termin Telefonicznie</span>
          <a href="tel:{{ $contact['sidebar_phone_link'] ?: $contact['sidebar_phone'] }}" class="font-sans text-[#655098] underline ml-2">{{ $contact['sidebar_phone'] }}</a>
        </p>
      </div>
    @endif
  </div>

  {{-- Price box --}}
  @if ($price)
    <div class="border border-black/50 flex flex-col gap-3 p-3" data-price-section>

      {{-- Top bar (hardcode) --}}
      <div class="flex items-center justify-between pb-3 border-b border-black/50">
        <div class="flex items-center gap-1">
          <svg class="size-3 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
          </svg>
          <span class="font-metro text-[10px] text-black underline">30-dniowa gwarancja zwrotu pieniędzy</span>
        </div>
        <div class="flex items-center gap-1">
          <x-icons.phone class="size-3 text-black" />
          <span class="font-metro text-[10px] text-black underline">Umów się na konsultacje</span>
        </div>
      </div>

      {{-- Cena (ACF) + CTA (hardcode) --}}
      <div class="flex gap-6 items-start">
        <span class="font-poppins text-[32px] leading-none text-primary shrink-0">
          {{ $price }}
        </span>

        <div class="flex flex-col gap-2 flex-1">
          <button
            class="booking-trigger bg-primary flex items-center justify-between rounded-sm px-4 py-2 text-white font-poppins text-sm leading-none hover:opacity-90 transition-opacity cursor-pointer w-full"
            data-service="{{ $sidebarTitle }}"
          >
            <span>Zarezerwuj Termin</span>
            <x-icons.arrow-right class="size-4" />
          </button>

          <div class="flex items-start gap-1">
            <svg class="size-2.5 text-black shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
              <circle cx="12" cy="12" r="10" />
              <path d="M12 8h.01M11 12h1v4h1" />
            </svg>
            <span class="font-sans text-[10px] text-black leading-normal">Cena zawiera 23% VAT, nie obejmuje kosztów przejazdów</span>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- W cenie znajdziesz (checklista) --}}
  @if (! empty($includedItems))
    <div class="flex flex-col gap-3 bg-[#f1f1f1] rounded p-4">
      @if ($includedHeading)
        <p class="font-poppins font-semibold text-sm text-black">
          {{ $includedHeading }}
        </p>
      @endif
      <ul class="flex flex-col gap-2 list-none p-0 m-0">
        @foreach ($includedItems as $item)
          <li class="flex items-start gap-2">
            <span class="text-primary shrink-0 mt-0.5" aria-hidden="true">
              <x-icons.check class="size-4 stroke-2" />
            </span>
            <span class="font-poppins text-xs leading-relaxed text-black">{{ $item }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Linki (hardcode) --}}
  <div class="flex items-center justify-between">
    <a href="{{ home_url('/voucher/') }}" class="flex items-center gap-0.5 text-[#655098] text-[10px] underline font-sans">
      <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
      </svg>
      Kup dla kogoś
    </a>

    <a href="#" class="flex items-center gap-0.5 text-[#655098] text-[10px] underline font-sans">
      <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
      </svg>
      Sprawdź Regulamin Oferty
    </a>
  </div>

  {{-- Testimonial snippet (auto-pulled najnowsza opinia) --}}
  @if (! empty($sidebarTestimonial))
    <div class="bg-[#f1f1f1] rounded p-4 flex flex-col gap-3">
      <span class="font-metro text-[10px] uppercase tracking-[3px] text-black/60">
        Opinia klienta
      </span>
      @if ($sidebarTestimonial['quote'])
        <blockquote class="font-poppins text-xs leading-relaxed text-black line-clamp-5 italic">
          „{{ $sidebarTestimonial['quote'] }}"
        </blockquote>
      @endif
      <div class="flex items-center gap-2.5 mt-1">
        @if ($sidebarTestimonial['image'])
          <img
            src="{{ $sidebarTestimonial['image'] }}"
            alt=""
            aria-hidden="true"
            class="size-9 rounded-full object-cover shrink-0"
            width="36"
            height="36"
            loading="lazy"
          >
        @else
          <div class="size-9 rounded-full bg-black/10 shrink-0" aria-hidden="true"></div>
        @endif
        <div class="flex flex-col leading-tight">
          <span class="font-poppins font-semibold text-xs text-black">{{ $sidebarTestimonial['author'] }}</span>
          @if ($sidebarTestimonial['service'])
            <span class="font-poppins text-[10px] text-black/60">{{ $sidebarTestimonial['service'] }}</span>
          @endif
        </div>
      </div>
    </div>
  @endif

  {{-- Related services (cross-sell) --}}
  @if (! empty($relatedServices))
    <div class="flex flex-col gap-3">
      <p class="font-poppins font-semibold text-sm text-black">
        Sprawdź też inne usługi
      </p>
      <div class="flex flex-col gap-2">
        @foreach ($relatedServices as $service)
          <a
            href="{{ $service['url'] }}"
            class="flex items-center gap-3 group bg-[#f1f1f1] hover:bg-[#e7e7e7] rounded p-2 transition-colors"
          >
            @if ($service['image'])
              <div class="size-12 rounded overflow-hidden shrink-0">
                <img
                  src="{{ $service['image'] }}"
                  alt=""
                  aria-hidden="true"
                  class="size-full object-cover"
                  width="48"
                  height="48"
                  loading="lazy"
                >
              </div>
            @else
              <div class="size-12 rounded bg-black/10 shrink-0" aria-hidden="true"></div>
            @endif
            <span class="font-poppins font-medium text-xs leading-snug text-black group-hover:text-primary transition-colors flex-1 min-w-0">
              {{ $service['title'] }}
            </span>
            <x-icons.arrow-right class="size-4 text-black/40 group-hover:text-primary group-hover:translate-x-0.5 transition-all shrink-0" />
          </a>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Tagi (ACF) --}}
  @if ($tags)
    <div class="flex flex-col gap-2">
      <p class="font-metro text-sm leading-none text-black">Powiązane Tematy Bloga:</p>
      <div class="flex flex-wrap gap-1">
        @foreach ($tags as $tag)
          <span class="bg-primary text-white font-poppins text-xs leading-none rounded-sm px-2 py-1">
            {{ is_array($tag) ? ($tag['label'] ?? '') : $tag }}
          </span>
        @endforeach
      </div>
    </div>
  @endif

</div>
