{{--
  Archiwum realizacji (CPT portfolio) — /realizacje/
--}}

@extends('layouts.app')

@section('content')
  <section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

    {{-- Nagłówek --}}
    <header class="mb-8 lg:mb-12">
      <nav class="font-poppins text-[10px] leading-3 text-black mb-4" aria-label="Breadcrumb">
        <a href="{{ home_url('/') }}" class="hover:underline">Strona główna</a>
        <span> / </span>
        <span class="font-bold">Realizacje</span>
      </nav>
      <h1 class="font-poppins text-4xl lg:text-[52px] leading-tight text-black">
        Realizacje
      </h1>
    </header>

    {{-- Grid realizacji --}}
    @if (! empty($items))
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach ($items as $item)
          <x-portfolio-card
            :grid="true"
            :title="$item['title']"
            :category="$item['category']"
            :image="$item['image']"
            :link="$item['link']"
          />
        @endforeach
      </div>

      {!! $paginationHtml !!}
    @else
      <p class="font-poppins text-base text-black/60 text-center py-10">
        Wkrótce pojawią się tu pierwsze realizacje.
      </p>
    @endif

  </section>
@endsection
