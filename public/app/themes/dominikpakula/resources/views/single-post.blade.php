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

      {{-- 2. Body + sticky sidebar --}}
      @include('partials.blog.body')

      {{-- 3. Subscribe --}}
      @include('partials.blog.subscribe')

      {{-- 4. Author bio --}}
      @include('partials.blog.author-bio')

      {{-- 5. Booking CTA --}}
      @include('partials.blog.booking-cta')

      {{-- 6. Related posts --}}
      @include('partials.blog.related-posts')

      {{-- 7. Prev / Next --}}
      @include('partials.blog.prev-next')

      {{-- 8. Browse full blog --}}
      @include('partials.blog.browse-full')

      {{-- 9. Comments --}}
      <?php comments_template(); ?>

    </article>
  @endwhile
@endsection
