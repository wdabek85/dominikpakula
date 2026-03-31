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
@endsection
