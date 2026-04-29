@extends('layouts.app')

@section('content')
  @include('sections.portfolio.breadcrumbs')

  @while(have_posts()) @php(the_post())
    <article class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">

      {{-- Header: kategoria + tytuł + intro --}}
      <header class="flex flex-col gap-4 max-w-[820px] mb-10 lg:mb-12">
        @if ($category)
          <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">
            {{ $category }}
          </span>
        @endif

        <h1 class="font-poppins font-semibold text-[32px] lg:text-[48px] leading-tight text-black">
          {{ get_the_title() }}
        </h1>

        @if ($intro)
          <p class="font-poppins text-base lg:text-lg leading-relaxed text-black/80">
            {{ $intro }}
          </p>
        @endif
      </header>

      {{-- Galeria — grid 1/2/3 col z fixed aspect ratio + lightbox na klik --}}
      @if (! empty($gallery))
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5" data-lightbox-gallery>
          @foreach ($gallery as $img)
            <a
              href="{{ $img['fullUrl'] }}"
              class="block group rounded overflow-hidden cursor-zoom-in"
              data-lightbox-trigger
              data-lightbox-src="{{ $img['fullUrl'] }}"
              data-lightbox-alt="{{ $img['alt'] }}"
              data-lightbox-caption="{{ $img['caption'] }}"
              aria-label="{{ $img['caption'] ?: $img['alt'] ?: 'Powiększ zdjęcie' }}"
            >
              <div class="aspect-[3/4] overflow-hidden">
                <img
                  src="{{ $img['url'] }}"
                  alt="{{ $img['alt'] }}"
                  class="size-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                  loading="lazy"
                >
              </div>
              @if ($img['caption'])
                <p class="font-poppins text-xs text-black/60 mt-2">
                  {{ $img['caption'] }}
                </p>
              @endif
            </a>
          @endforeach
        </div>
      @else
        <p class="font-poppins text-base text-black/60 text-center py-12">
          Galeria zostanie dodana wkrótce.
        </p>
      @endif

    </article>
  @endwhile
@endsection
