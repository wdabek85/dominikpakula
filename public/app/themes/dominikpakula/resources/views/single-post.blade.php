{{--
  Template Name: Blog — Single Post
  Description: Dedykowany szablon dla pojedynczego wpisu bloga.
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts())
    <?php the_post(); ?>

    <article <?php post_class('single-post'); ?>>

      {{-- 0. Breadcrumbs (pełnoszerokościowy pasek nad hero) --}}
      @include('partials.blog.breadcrumbs')

      {{-- 1. Hero --}}
      @include('partials.blog.hero')

      {{-- 2. Body + sticky sidebar (na dole kolumny treści: podpis autora) --}}
      @include('partials.blog.body')

      {{-- 3. Subscribe --}}
      @include('partials.blog.subscribe')

      {{-- 4. Booking CTA --}}
      @include('partials.blog.booking-cta')

      {{-- 5. Related posts --}}
      @include('partials.blog.related-posts')

      {{-- 6. Prev / Next --}}
      @include('partials.blog.prev-next')

      {{-- 7. Browse full blog --}}
      @include('partials.blog.browse-full')

      {{-- 8. Comments --}}
      <?php comments_template(); ?>

    </article>
  @endwhile
@endsection
