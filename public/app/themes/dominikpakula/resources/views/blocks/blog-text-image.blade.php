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
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-stretch">

      @if ($text)
        <div class="space-y-4 font-poppins text-base leading-relaxed text-black {{ $alignClass }} {{ $imageFirst ? 'lg:order-2' : '' }}">
          {!! $text !!}
        </div>
      @endif

      @if ($image['url'])
        {{-- Na desktopie obraz jest pozycjonowany absolutnie, więc nie wpływa na
             wysokość wiersza gridu — tę wyznacza kolumna z tekstem, a zdjęcie
             dopasowuje się do niej (object-contain, bez przycinania).
             min-h chroni przed mikroskopijnym zdjęciem przy bardzo krótkim tekście.
             Na mobile układ jest stackowany, więc obraz płynie normalnie. --}}
        <figure class="lg:relative lg:h-full lg:min-h-[280px] {{ $imageFirst ? 'lg:order-1' : '' }}">
          <img
            src="{{ $image['url'] }}"
            alt="{{ $image['alt'] }}"
            @if ($image['width']) width="{{ $image['width'] }}" @endif
            @if ($image['height']) height="{{ $image['height'] }}" @endif
            loading="lazy"
            decoding="async"
            class="max-h-[420px] w-auto max-w-full h-auto mx-auto rounded-sm
                   lg:absolute lg:inset-0 lg:size-full lg:max-h-none lg:object-contain lg:object-center"
          >
        </figure>
      @endif

    </div>
  @endif

</section>
