@php
  $email = $contact['email'] ?? '';
  $emailFallback = 'kontakt@meskistylista.pl';
  $phone = $contact['phone'] ?? '';
  $phoneFallback = '+48 884 826 068';
  $phoneLink = $contact['phone_link'] ?? '';
  $phoneLinkFallback = '+48884826068';
  $addressLine1 = $contact['address_line1'] ?? '';
  $addressLine2 = $contact['address_line2'] ?? '';
  $instagramHandle = $social['instagram_handle'] ?? 'dpakula_stylist';

  $gridCols = ! empty($footerMenu)
    ? 'lg:grid-cols-[minmax(180px,_220px)_minmax(160px,_180px)_minmax(180px,_220px)_minmax(140px,_170px)_1fr]'
    : 'lg:grid-cols-[minmax(180px,_220px)_minmax(160px,_180px)_minmax(180px,_220px)_1fr]';
@endphp

<footer class="content-info bg-[#f1f1f1] text-[#19121e]">

  {{-- Główna sekcja stopki --}}
  <div class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 {{ $gridCols }} gap-10 lg:gap-12">

      {{-- Kolumna 1: logo + slogan --}}
      <div class="flex flex-col gap-6">
        <a href="{{ home_url('/') }}" class="shrink-0" aria-label="{{ $siteName ?? get_bloginfo('name') }} — Strona główna">
          @if (has_custom_logo())
            <img
              src="{{ wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') }}"
              alt="{{ $siteName ?? get_bloginfo('name') }}"
              class="h-[40px] w-auto"
            >
          @else
            <span class="font-poppins font-bold text-xl tracking-[0.2em] uppercase text-[#19121e] leading-tight">
              {{ $siteName ?? get_bloginfo('name') }}
            </span>
          @endif
        </a>
        <p class="font-poppins text-xs tracking-[0.3em] uppercase text-[#19121e]/70">
          Osobisty stylista
        </p>
        <p class="font-poppins text-sm leading-relaxed text-[#19121e]">
          Pomagam facetom wyglądać tak, jak chcieliby wyglądać.
        </p>
      </div>

      {{-- Kolumna 2: dane formalne --}}
      <div class="flex flex-col gap-6">
        <p class="font-poppins font-semibold text-base text-[#19121e]">
          Dane formalne
        </p>

        <div class="flex flex-col gap-3 text-sm font-poppins">
          @if ($addressLine1 || $addressLine2)
            <div class="flex items-start gap-2">
              <x-icons.location class="size-4 shrink-0 mt-0.5" />
              <div class="flex flex-col">
                <span>{{ $addressLine1 ?: 'ul. Marszałkowska 1' }}</span>
                <span>{{ $addressLine2 ?: '00-001 Warszawa' }}</span>
              </div>
            </div>
          @else
            <div class="flex items-start gap-2">
              <x-icons.location class="size-4 shrink-0 mt-0.5" />
              <div class="flex flex-col text-[#19121e]/60 italic">
                <span>ul. Przykładowa 1</span>
                <span>00-000 Warszawa</span>
              </div>
            </div>
          @endif

          <div class="flex items-center gap-2">
            <x-icons.document class="size-4 shrink-0" />
            <span>NIP: <span class="text-[#19121e]/60 italic">000-000-00-00</span></span>
          </div>

          <div class="flex items-center gap-2">
            <x-icons.document class="size-4 shrink-0" />
            <span>REGON: <span class="text-[#19121e]/60 italic">000000000</span></span>
          </div>
        </div>
      </div>

      {{-- Kolumna 3: kontakt --}}
      <div class="flex flex-col gap-6">
        <p class="font-poppins font-semibold text-base text-[#19121e]">
          Dane kontaktowe
        </p>

        <div class="flex flex-col gap-4 text-sm font-poppins">
          <div class="flex flex-col gap-2">
            <p class="font-semibold">Zadzwoń:</p>
            <a href="tel:{{ $phoneLink ?: $phoneLinkFallback }}" class="flex items-center gap-2 hover:text-primary transition-colors">
              <x-icons.phone class="size-5 shrink-0" />
              <span>{{ $phone ?: $phoneFallback }}</span>
            </a>
          </div>

          <div class="flex flex-col gap-2">
            <p class="font-semibold">Napisz:</p>
            <a href="mailto:{{ $email ?: $emailFallback }}" class="flex items-center gap-2 hover:text-primary transition-colors">
              <x-icons.envelope class="size-5 shrink-0" />
              <span>{{ $email ?: $emailFallback }}</span>
            </a>
          </div>

          @if (! empty($social['instagram']))
            <div class="flex flex-col gap-2">
              <p class="font-semibold">Obserwuj:</p>
              <a href="{{ $social['instagram'] }}" target="_blank" rel="noopener" class="flex items-center gap-2 hover:text-primary transition-colors">
                <x-icons.instagram class="size-5 shrink-0" />
                <span>{{ '@' . $instagramHandle }}</span>
              </a>
            </div>
          @endif
        </div>
      </div>

      {{-- Kolumna 4: szybka nawigacja (z menu WP "Footer Navigation") --}}
      @if (! empty($footerMenu))
        <div class="flex flex-col gap-6">
          <p class="font-poppins font-semibold text-base text-[#19121e]">
            Nawigacja
          </p>

          <ul class="flex flex-col gap-3 text-sm font-poppins">
            @foreach ($footerMenu as $item)
              <li>
                <a
                  href="{{ $item['url'] }}"
                  @if ($item['target'] !== '_self') target="{{ $item['target'] }}" rel="noopener" @endif
                  class="hover:text-primary transition-colors {{ $item['isCurrent'] ? 'font-semibold' : '' }}"
                >
                  {{ $item['label'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Kolumna 5: usługi (z CPT service przez NavigationComposer) --}}
      @if (! empty($navServices))
        <div class="flex flex-col gap-6">
          <p class="font-poppins font-semibold text-base text-[#19121e]">
            Moje usługi
          </p>

          <ul class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm font-poppins">
            @foreach ($navServices as $service)
              <li>
                <a href="{{ $service['url'] }}" class="flex items-center gap-2 hover:text-primary transition-colors">
                  <x-icons.hanger class="size-4 shrink-0 text-[#19121e]/50" />
                  <span>{{ $service['title'] }}</span>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endif

    </div>
  </div>

  {{-- Dolny pasek copyright --}}
  <div class="bg-white">
    <div class="mx-auto max-w-[1440px] px-4 lg:px-20 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm font-poppins text-[#19121e]">
      <p>
        Copyright © {{ date('Y') }} Dominik Pakuła. Wszelkie prawa zastrzeżone.
      </p>
      <div class="flex items-center gap-6">
        <a href="{{ home_url('/polityka-prywatnosci/') }}" class="hover:text-primary transition-colors">
          Polityka prywatności
        </a>
        <a href="{{ home_url('/regulamin/') }}" class="hover:text-primary transition-colors">
          Regulamin
        </a>
      </div>
    </div>
  </div>

</footer>
