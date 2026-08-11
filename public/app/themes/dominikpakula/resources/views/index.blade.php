@extends('layouts.app')

@section('content')
  @if (! have_posts())
    @include('sections.not-found.hero', [
      'heading' => 'Nie ma tu jeszcze nic do pokazania',
      'lead' => 'Ta lista jest pusta. Zajrzyj na bloga albo zacznij od usług.',
    ])
    @include('sections.not-found.services')
  @else
    @include('partials.page-header')
  @endif

  @while(have_posts()) @php(the_post())
    @includeFirst(['partials.content-' . get_post_type(), 'partials.content'])
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection
