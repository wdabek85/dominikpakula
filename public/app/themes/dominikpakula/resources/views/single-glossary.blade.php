{{--
  Szablon pojedynczego hasła słowniczka (CPT glossary).
  Desktop: treść + sidebar (wyszukiwarka, akordeon liter). Mobile: treść → sidebar → powrót.
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts())
    <?php the_post(); ?>

    <article <?php post_class('single-glossary'); ?>>

      @include('sections.glossary.breadcrumbs')

      <div class="mx-auto max-w-[1440px] px-4 lg:px-20 pt-8 pb-14 lg:pt-14 grid grid-cols-1 lg:grid-cols-[minmax(0,1fr)_375px] gap-10 lg:gap-x-16 lg:items-start">

        <div class="lg:col-start-1 lg:row-start-1">
          @include('sections.glossary.term')
        </div>

        <div class="lg:col-start-2 lg:row-start-1 lg:row-span-2">
          @include('sections.glossary.sidebar')
        </div>

        {{-- Powrót do słowniczka --}}
        <div class="lg:col-start-1 lg:row-start-2 pt-6 border-t border-black/10">
          <a
            href="{{ $glossaryUrl }}"
            class="group inline-flex items-center gap-2 font-poppins text-base text-primary hover:text-primary/80 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-colors"
          >
            <x-icons.arrow-left class="size-4 transition-transform group-hover:-translate-x-1" />
            <span>Wróć do słowniczka</span>
          </a>
        </div>

      </div>

    </article>

    @include('partials.blog.booking-cta')
  @endwhile
@endsection
