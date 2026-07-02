{{--
  Template Name: Poradnik — Single Guide
  Description: Dedykowany szablon dla pojedynczego poradnika (CPT guide).
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts())
    <?php the_post(); ?>

    <article <?php post_class('single-guide'); ?>>

      {{-- 0. Breadcrumbs --}}
      @include('partials.guide.breadcrumbs')

      {{-- 1. Hero --}}
      @include('partials.guide.hero')

      {{-- 2. Body + sticky sidebar (TOC + share) --}}
      @include('partials.guide.body')

      {{-- 3. Chipsy kategorii --}}
      @if (! empty($categories))
        <section class="mx-auto max-w-[1440px] px-4 lg:px-20 pb-6">
          <div class="flex flex-wrap items-center gap-2 pt-6 border-t border-black/10">
            <span class="font-metro text-xs uppercase tracking-[3px] text-black/60 mr-2">Kategorie</span>
            @foreach ($categories as $cat)
              <a
                href="{{ $cat['url'] }}"
                class="inline-flex items-center px-2.5 py-1 rounded-[2px] border border-[#19121e] font-sans text-[15px] uppercase whitespace-nowrap text-[#19121e] hover:bg-black/5 transition-colors"
              >
                {{ $cat['name'] }}
              </a>
            @endforeach
          </div>
        </section>
      @endif

      {{-- 4. Powiązane poradniki --}}
      @include('partials.guide.related')

      {{-- 5. Newsletter + Instagram (współdzielony z blogiem) --}}
      @include('partials.blog.subscribe')

      {{-- 6. Powrót do poradników --}}
      <section class="mx-auto max-w-[1440px] px-4 lg:px-20 pb-14">
        <a
          href="{{ $guidesUrl }}"
          class="group inline-flex items-center gap-2 font-poppins text-base text-primary hover:text-primary/80 transition-colors"
        >
          <x-icons.arrow-left class="size-4 transition-transform group-hover:-translate-x-1" />
          <span>Wróć do wszystkich poradników</span>
        </a>
      </section>

    </article>
  @endwhile
@endsection
