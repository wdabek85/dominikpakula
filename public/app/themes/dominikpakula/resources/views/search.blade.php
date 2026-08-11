@extends('layouts.app')

@section('content')
  @if (! have_posts())
    @include('sections.not-found.hero', [
      'heading' => 'Nic nie znalazłem',
      'lead' => 'Dla frazy „' . get_search_query() . '" nie mam żadnych wyników. Spróbuj innego słowa albo zacznij od usług.',
    ])
    @include('sections.not-found.services')
  @else
    @include('partials.page-header')
  @endif

  @while(have_posts()) @php(the_post())
    @include('partials.content-search')
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection
