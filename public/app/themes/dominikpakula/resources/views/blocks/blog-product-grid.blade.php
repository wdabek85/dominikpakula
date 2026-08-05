{{--
  Siatka produktów — nagłówek + wstęp + dowolna liczba zdjęć z repeatera.
  Desktop zawsze 3 kolumny, tablet 2, mobile 1. Nagłówek jako zwykły h2/h3,
  więc trafia do spisu treści wpisu.
  Zdjęcie z linkiem = cała kafelka klikalna (stretched link).
--}}
<section class="not-prose my-10 lg:my-12">

  @if ($heading || $text)
    <div class="max-w-[720px] mx-auto mb-8 lg:mb-10 {{ $alignClass }}">
      @if ($heading)
        <{{ $headingTag }} class="font-serif font-normal text-black {{ $headingTag === 'h2' ? 'text-3xl' : 'text-2xl' }} leading-tight">
          {{ $heading }}
        </{{ $headingTag }}>
      @endif

      @if ($text)
        <div class="space-y-4 font-poppins text-base leading-relaxed text-black/80 {{ $heading ? 'mt-4 lg:mt-5' : '' }}">
          {!! $text !!}
        </div>
      @endif
    </div>
  @endif

  @if (! empty($items))
    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5 list-none p-0 m-0">
      @foreach ($items as $item)
        <li class="relative group">
          <div class="aspect-[3/4] bg-[#f1f1f1] rounded-sm overflow-hidden flex items-center justify-center">
            <img
              src="{{ $item['src'] }}"
              alt="{{ $item['alt'] }}"
              @if ($item['width']) width="{{ $item['width'] }}" @endif
              @if ($item['height']) height="{{ $item['height'] }}" @endif
              loading="lazy"
              decoding="async"
              class="size-full object-contain transition-transform duration-500 ease-out group-hover:scale-105"
            >
          </div>

          @if ($item['name'])
            <p class="font-poppins text-sm text-black mt-3 {{ $item['url'] ? 'group-hover:text-primary transition-colors' : '' }}">
              {{ $item['name'] }}
            </p>
          @endif

          @if ($item['url'])
            {{-- Stretched link: jeden cel fokusa na całą kafelkę --}}
            <a
              href="{{ $item['url'] }}"
              target="_blank"
              rel="noopener nofollow"
              class="absolute inset-0 z-10 rounded-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary"
              aria-label="{{ $item['name'] ? 'Zobacz w sklepie: ' . $item['name'] : 'Zobacz produkt w sklepie' }}"
            ></a>
          @endif
        </li>
      @endforeach
    </ul>
  @endif

</section>
