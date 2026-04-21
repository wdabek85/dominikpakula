{{-- Sticky sidebar — TOC + Czytaj też + Share --}}
<div class="sticky top-24 flex flex-col gap-8">

  @include('partials.blog.toc')

  @if ($teaserPost)
    @include('partials.blog.related-teaser')
  @endif

  @include('partials.blog.share')

</div>
