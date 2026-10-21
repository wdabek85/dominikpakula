{{--
  Nagłówek podstrony: breadcrumb tekstowy + H1 + opis (bez obrazka).
  Używany przez blok acf/page-header (Baza Wiedzy, Blog, Kontakt…) i archiwum słowniczka.
--}}
@props([
  'breadcrumb' => '',
  'title' => '',
  'description' => '',
])

<section {{ $attributes->merge(['class' => 'not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-4']) }}>
  <div class="flex flex-col gap-5">

    {{-- Breadcrumb --}}
    @if ($breadcrumb)
      <nav class="font-poppins text-[10px] leading-3 text-black" aria-label="Breadcrumb">
        <a href="{{ home_url('/') }}" class="hover:underline">Strona główna</a>
        <span> / </span>
        <span class="font-bold">{{ $breadcrumb }}</span>
      </nav>
    @endif

    {{-- Tytuł + opis --}}
    <div class="flex flex-col gap-2.5">
      @if ($title)
        <h1 class="font-poppins text-[34px] md:text-5xl lg:text-[56px] leading-tight lg:leading-none text-black">
          {{ $title }}
        </h1>
      @endif

      @if ($description)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $description }}
        </p>
      @endif
    </div>

  </div>
</section>
