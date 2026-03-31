@extends('layouts.app')

@section('content')
  @include('sections.service.breadcrumbs')

  <article class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">

    {{-- Two-column grid: 7fr left + 3fr right, 40px gap --}}
    <div class="lg:grid lg:grid-cols-[7fr_3fr] lg:gap-10">

      {{-- Lewa kolumna: header (social proof + zdjęcie) --}}
      <div class="lg:row-start-1 lg:col-start-1">
        @include('sections.service.header')
      </div>

      {{-- Sidebar: na mobile pod zdjęciem, na desktop sticky w prawej kolumnie --}}
      <aside class="mt-4 lg:mt-0 lg:row-span-2 lg:col-start-2 lg:row-start-1">
        <div class="lg:sticky lg:top-8">
          @include('sections.service.sidebar')
        </div>
      </aside>

      {{-- Content: Gutenberg bloki (różne per usługę) --}}
      <div class="mt-8 lg:mt-0 lg:col-start-1">
        @php(the_content())
      </div>

    </div>
  </article>

  {{-- Sekcje full-width (wspólne dla wszystkich usług) --}}
  @include('sections.service.testimonials')
  @include('blocks.blog')

  {{-- Sticky bottom bar --}}
  @if ($price)
    <div
      id="sticky-price-bar"
      class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-[0_-4px_12px_rgba(0,0,0,0.08)] translate-y-full transition-transform duration-300"
    >
      <div class="mx-auto max-w-[1440px] px-4 lg:px-20 py-3 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 min-w-0">
          <span class="font-poppins font-semibold text-sm lg:text-base text-black truncate">
            {{ $sidebarTitle }}
          </span>
          <span class="font-poppins text-xl lg:text-2xl leading-none text-primary shrink-0">
            {{ $price }}
          </span>
        </div>

        <a
          href="#"
          class="bg-primary flex items-center gap-2 rounded-sm px-4 lg:px-6 py-2.5 text-white font-poppins text-sm leading-none hover:opacity-90 transition-opacity shrink-0"
        >
          <span>Zarezerwuj Termin</span>
          <x-icons.arrow-right class="size-4" />
        </a>
      </div>
    </div>
  @endif
@endsection
