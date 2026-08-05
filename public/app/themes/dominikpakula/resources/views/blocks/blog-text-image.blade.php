{{--
  Tekst + zdjęcie (2 kolumny).
  Nagłówek na całą szerokość u góry — jako zwykły h2/h3 wpada do spisu treści
  (id dokleja `Blog\Filters::add_heading_ids` na filtrze the_content).
  Pozycja zdjęcia i wyrównanie tekstu sterowane z panelu.
--}}
<section class="not-prose my-10 lg:my-12">

  @if ($heading)
    <{{ $headingTag }} class="font-serif font-normal text-black {{ $headingTag === 'h2' ? 'text-3xl' : 'text-2xl' }} leading-tight mb-6 lg:mb-8 {{ $alignClass }}">
      {{ $heading }}
    </{{ $headingTag }}>
  @endif

  @if ($text || $image['url'])
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-start">

      @if ($text)
        <div class="space-y-4 font-poppins text-base leading-relaxed text-black {{ $alignClass }} {{ $imageFirst ? 'lg:order-2' : '' }}">
          {!! $text !!}
        </div>
      @endif

      @if ($image['url'])
        <figure class="{{ $imageFirst ? 'lg:order-1' : '' }}">
          <img
            src="{{ $image['url'] }}"
            alt="{{ $image['alt'] }}"
            @if ($image['width']) width="{{ $image['width'] }}" @endif
            @if ($image['height']) height="{{ $image['height'] }}" @endif
            loading="lazy"
            decoding="async"
            class="w-full h-auto rounded-sm"
          >
        </figure>
      @endif

    </div>
  @endif

</section>
