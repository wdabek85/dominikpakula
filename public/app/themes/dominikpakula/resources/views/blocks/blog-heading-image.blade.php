{{--
  Nagłówek + jedno zdjęcie pod spodem.
  Nagłówek jako zwykły h2/h3 — trafia do spisu treści wpisu.
  Podpis pod zdjęciem opcjonalny (figcaption).
--}}
<section class="not-prose my-10 lg:my-12">

  @if ($heading)
    <{{ $headingTag }} class="font-serif font-normal text-black {{ $headingTag === 'h2' ? 'text-3xl' : 'text-2xl' }} leading-tight mb-6 lg:mb-8 {{ $alignClass }}">
      {{ $heading }}
    </{{ $headingTag }}>
  @endif

  @if ($image['url'])
    {{-- Węższe niż kolumna tekstu i wycentrowane — zdjęcie ma być akcentem,
         nie banerem na całą szerokość. --}}
    <figure class="max-w-[620px] mx-auto">
      <img
        src="{{ $image['url'] }}"
        alt="{{ $image['alt'] }}"
        @if ($image['width']) width="{{ $image['width'] }}" @endif
        @if ($image['height']) height="{{ $image['height'] }}" @endif
        loading="lazy"
        decoding="async"
        class="w-full h-auto rounded-sm"
      >

      @if ($caption)
        <figcaption class="font-poppins text-sm text-black/60 mt-3 text-center">
          {{ $caption }}
        </figcaption>
      @endif
    </figure>
  @endif

</section>
