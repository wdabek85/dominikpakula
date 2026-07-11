@php
  $phone = $contact['phone'] ?? '';
  $phoneFallback = '+48 577 190 949';
  $phoneLink = $contact['phone_link'] ?? '';
  $phoneLinkFallback = '+48577190949';
  $email = $contact['email'] ?? '';
  $emailFallback = 'kontakt@meskistylista.pl';
  $instagram = $social['instagram'] ?? '';
  $instagramHandle = $social['instagram_handle'] ?? 'dpakula_stylist';
  $whatsapp = $social['whatsapp'] ?? '';

  // Każdy kanał: tylko jeśli ma podstawowe dane
  $channels = [];

  if ($phone || $phoneFallback) {
    $channels[] = [
      'icon' => 'phone',
      'label' => 'Zadzwoń',
      'value' => $phone ?: $phoneFallback,
      'href' => 'tel:' . ($phoneLink ?: $phoneLinkFallback),
      'external' => false,
    ];
  }

  if ($whatsapp) {
    $channels[] = [
      'icon' => 'whatsapp',
      'label' => 'WhatsApp',
      'value' => 'Napisz na WhatsAppie',
      'href' => $whatsapp,
      'external' => true,
    ];
  }

  if ($instagram) {
    $channels[] = [
      'icon' => 'instagram',
      'label' => 'Instagram DM',
      'value' => '@' . $instagramHandle,
      'href' => $instagram,
      'external' => true,
    ];
  }

  if ($email || $emailFallback) {
    $channels[] = [
      'icon' => 'envelope',
      'label' => 'Email',
      'value' => $email ?: $emailFallback,
      'href' => 'mailto:' . ($email ?: $emailFallback),
      'external' => false,
    ];
  }

  $colsClass = match (count($channels)) {
    1 => 'lg:grid-cols-1',
    2 => 'lg:grid-cols-2',
    3 => 'lg:grid-cols-3',
    default => 'lg:grid-cols-4',
  };
@endphp

<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

  {{-- Nagłówek sekcji --}}
  @if ($channelsHeading || $channelsSubtitle)
    <div class="flex flex-col gap-3 mb-8 lg:mb-10 text-center max-w-[640px] mx-auto">
      @if ($channelsHeading)
        <h2 class="font-poppins font-semibold text-2xl lg:text-3xl leading-tight text-[#19121e]">
          {{ $channelsHeading }}
        </h2>
      @endif
      @if ($channelsSubtitle)
        <p class="font-poppins text-base text-[#19121e]/70 leading-relaxed">
          {{ $channelsSubtitle }}
        </p>
      @endif
    </div>
  @endif

  {{-- Kafelki --}}
  @if (! empty($channels))
    <div class="grid grid-cols-1 sm:grid-cols-2 {{ $colsClass }} gap-4">
      @foreach ($channels as $ch)
        <a
          href="{{ $ch['href'] }}"
          @if ($ch['external']) target="_blank" rel="noopener" @endif
          class="group flex flex-col gap-3 bg-[#f1f1f1] rounded-[8px] p-6 transition-all duration-300 ease-out hover:-translate-y-1 hover:shadow-xl hover:bg-white hover:ring-1 hover:ring-[#19121e]/10"
        >
          {{-- Ikona --}}
          <div class="size-12 rounded-full bg-white border border-[#19121e]/10 flex items-center justify-center text-[#19121e] group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-colors duration-300">
            @switch($ch['icon'])
              @case('phone')
                <x-icons.phone class="size-5" />
                @break
              @case('whatsapp')
                <x-icons.whatsapp class="size-5" />
                @break
              @case('instagram')
                <x-icons.instagram class="size-5" />
                @break
              @case('envelope')
                <x-icons.envelope class="size-5" />
                @break
            @endswitch
          </div>

          {{-- Label + value --}}
          <div class="flex flex-col gap-1 mt-2">
            <span class="font-poppins font-semibold text-base text-[#19121e]">
              {{ $ch['label'] }}
            </span>
            <span class="font-poppins text-sm text-[#19121e]/60 break-all">
              {{ $ch['value'] }}
            </span>
          </div>

          {{-- Arrow w prawym dolnym --}}
          <div class="flex items-center justify-end mt-auto pt-2 text-[#19121e]/40 group-hover:text-primary transition-colors">
            <x-icons.arrow-up-right class="size-5 transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1" />
          </div>
        </a>
      @endforeach
    </div>
  @endif

</section>
