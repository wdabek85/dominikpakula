@extends('layouts.app')

@section('content')
  @while(have_posts())
    <?php the_post(); ?>

    <article <?php post_class('page-content'); ?>>

      {{-- Treść. Bloki (np. własny nagłówek usera) renderują się w pełnej szerokości i są
           nietknięte (`not-prose` + brak zawężania sekcji). Tylko luźny tekst (akapity, listy,
           nagłówki wklejone w edytorze) dostaje czytelną szerokość i typografię prose. --}}
      <div class="page-content prose prose-lg max-w-none
                  [&>*:not(section)]:mx-auto [&>*:not(section)]:max-w-[820px]
                  [&>*:not(section)]:px-4 sm:[&>*:not(section)]:px-6
                  [&>*:not(section):first-child]:pt-10 lg:[&>*:not(section):first-child]:pt-14
                  [&>*:not(section):last-child]:pb-14 lg:[&>*:not(section):last-child]:pb-20
                  prose-headings:font-poppins prose-headings:font-medium prose-headings:text-black
                  prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-3 prose-h2:leading-tight
                  prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-2
                  prose-p:font-poppins prose-p:text-black prose-p:leading-relaxed
                  prose-a:text-primary prose-a:underline-offset-[3px]
                  prose-strong:font-semibold prose-strong:text-black
                  prose-ul:font-poppins prose-ol:font-poppins prose-li:text-black prose-li:marker:text-black/50
                  prose-blockquote:font-poppins prose-blockquote:not-italic prose-blockquote:text-black
                  prose-blockquote:border-l-4 prose-blockquote:border-primary
                  prose-img:rounded-sm prose-table:text-sm
                  [&_.wp-block-table]:!mx-auto [&_.wp-block-table]:!max-w-[820px] [&_.wp-block-table]:!w-full
                  [&_.wp-block-table]:overflow-x-auto [&_.wp-block-table]:px-4 sm:[&_.wp-block-table]:px-6
                  [&_table]:!w-full [&_table]:my-6">
        <?php the_content(); ?>
      </div>

      {{-- Paginacja treści (dla stron z <!--nextpage-->) --}}
      <div class="mx-auto max-w-[820px] px-4 sm:px-6">
        <?php wp_link_pages([
          'before' => '<nav class="mt-8 flex flex-wrap items-center gap-2 font-poppins text-sm" aria-label="Strony">',
          'after' => '</nav>',
        ]); ?>
      </div>

    </article>
  @endwhile
@endsection
