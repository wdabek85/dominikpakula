@if ($heading || $eyebrow || ! empty($logos) || ! empty($links))
  <x-section class="not-prose">

    {{-- Nagłówek --}}
    @if ($eyebrow || $heading || $lead)
      <div class="flex flex-col gap-3 mb-8 lg:mb-12 text-center max-w-[720px] mx-auto">
        @if ($eyebrow)
          <x-eyebrow :label="$eyebrow" align="center" />
        @endif
        @if ($heading)
          <x-heading>{{ $heading }}</x-heading>
        @endif
        @if ($lead)
          <p class="font-poppins text-base text-[#19121e]/70 leading-relaxed">
            {{ $lead }}
          </p>
        @endif
      </div>
    @endif

    {{-- Logotypy --}}
    @if (! empty($logos))
      <ul class="list-none p-0 m-0 grid grid-cols-2 md:grid-cols-4 gap-x-12 lg:gap-x-16 gap-y-12 items-center max-w-[900px] mx-auto">
        @foreach ($logos as $logo)
          <li class="group flex items-center justify-center">
            @if ($logo['link'])
              <a
                href="{{ $logo['link'] }}"
                target="_blank"
                rel="noopener"
                class="flex items-center justify-center rounded-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
                aria-label="{{ $logo['name'] ?: 'Marka' }}"
              >
                <img
                  src="{{ $logo['url'] }}"
                  alt="{{ $logo['alt'] ?: ($logo['name'] ?: 'Logo marki') }}"
                  @if ($logo['width']) width="{{ $logo['width'] }}" @endif
                  @if ($logo['height']) height="{{ $logo['height'] }}" @endif
                  class="max-h-10 lg:max-h-12 w-auto object-contain opacity-60 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0"
                  loading="lazy"
                >
              </a>
            @else
              <img
                src="{{ $logo['url'] }}"
                alt="{{ $logo['alt'] ?: ($logo['name'] ?: 'Logo marki') }}"
                @if ($logo['width']) width="{{ $logo['width'] }}" @endif
                @if ($logo['height']) height="{{ $logo['height'] }}" @endif
                class="max-h-10 lg:max-h-12 w-auto object-contain opacity-60 grayscale transition duration-300 group-hover:opacity-100 group-hover:grayscale-0"
                loading="lazy"
              >
            @endif
          </li>
        @endforeach
      </ul>
    @endif

    {{-- Linki pod logotypami (np. „Zobacz realizacje”) --}}
    @if (! empty($links))
      <div class="mt-10 lg:mt-12 flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-4">
        @foreach ($links as $index => $link)
          <x-button :variant="$index === 0 ? 'primary' : 'secondary'" size="sm" :href="$link['url']" :label="$link['label']" />
        @endforeach
      </div>
    @endif

  </x-section>
@endif
