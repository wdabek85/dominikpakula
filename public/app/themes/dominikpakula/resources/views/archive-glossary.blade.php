{{--
  Archiwum słowniczka (CPT glossary) — /slowniczek/
--}}

@extends('layouts.app')

@section('content')
  @include('sections.glossary.hero')
  @include('sections.glossary.alphabet-nav')
  @include('sections.glossary.letters')
  @include('partials.blog.booking-cta')
@endsection
