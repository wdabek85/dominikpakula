@php
  $email = $contact['email'] ?? '';
  $emailFallback = 'kontakt@meskistylista.pl';
  $phone = $contact['phone'] ?? '';
  $phoneFallback = '+48 577 190 949';
  $phoneLink = $contact['phone_link'] ?? '';
  $phoneLinkFallback = '+48577190949';
  $addressLine1 = $contact['address_line1'] ?? '';
  $addressLine2 = $contact['address_line2'] ?? '';
@endphp

<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-6 lg:py-8">
  <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8 lg:gap-12 text-[#19121e]">

    {{-- Lewa: adres --}}
    <div class="flex flex-col gap-6">
      <div class="flex items-start gap-2">
        <x-icons.location class="size-4 shrink-0 mt-0.5" />
        <div class="flex flex-col font-poppins text-sm leading-tight">
          <span>{{ $addressLine1 ?: 'Kraków' }}</span>
          @if ($addressLine2)
            <span>{{ $addressLine2 }}</span>
          @endif
        </div>
      </div>
    </div>

    {{-- Środek: telefon --}}
    <div class="flex flex-col gap-3 font-poppins">
      <p class="font-semibold text-sm">Zadzwoń:</p>
      <a href="tel:{{ $phoneLink ?: $phoneLinkFallback }}" class="flex items-center gap-2 text-sm hover:text-primary transition-colors">
        <x-icons.phone class="size-5 shrink-0" />
        <span>{{ $phone ?: $phoneFallback }}</span>
      </a>
    </div>

    {{-- Prawa: email --}}
    <div class="flex flex-col gap-3 font-poppins">
      <p class="font-semibold text-sm">Napisz:</p>
      <a href="mailto:{{ $email ?: $emailFallback }}" class="flex items-center gap-2 text-sm hover:text-primary transition-colors">
        <x-icons.envelope class="size-5 shrink-0" />
        <span>{{ $email ?: $emailFallback }}</span>
      </a>
    </div>

  </div>
</section>
