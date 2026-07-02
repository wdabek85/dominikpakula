{{-- Body: grid 2-col desktop (content + sticky sidebar), single-col mobile --}}
<section class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">
  <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16">

    {{-- Sticky sidebar — po lewej na desktop --}}
    <aside class="hidden lg:block lg:col-span-4 xl:col-span-3 lg:order-first">
      @include('partials.guide.sidebar')
    </aside>

    {{-- Main content column --}}
    <div class="lg:col-span-8 xl:col-span-9 min-w-0">

      {{-- Mobile TOC (details, open by default) — blog-toc.js odsłania gdy są nagłówki --}}
      <details id="blog-toc-mobile-wrapper" class="hidden lg:hidden mb-8 border border-black/10 rounded-sm" open>
        <summary class="cursor-pointer font-metro text-xs uppercase tracking-[3px] text-black/70 p-4 select-none">
          Spis treści
        </summary>
        <div class="p-4 pt-0">
          <nav data-toc-target="mobile" aria-label="Spis treści"></nav>
        </div>
      </details>

      {{-- Content (prose + editorial overrides) — .post-content wymagane przez blog-toc.js --}}
      <div class="post-content prose prose-lg max-w-none
                  prose-headings:font-serif prose-headings:font-normal prose-headings:text-black
                  prose-h2:text-3xl prose-h2:mt-12 prose-h2:mb-4 prose-h2:leading-tight
                  prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-3
                  prose-p:font-poppins prose-p:text-black prose-p:leading-relaxed
                  prose-a:text-primary prose-a:underline-offset-[3px]
                  prose-strong:font-semibold prose-strong:text-black
                  prose-blockquote:font-serif prose-blockquote:not-italic prose-blockquote:text-black
                  prose-blockquote:border-l-4 prose-blockquote:border-primary
                  prose-ul:font-poppins prose-ol:font-poppins
                  prose-img:rounded-sm">
        {!! apply_filters('the_content', $content) !!}
      </div>

      {{-- Mobile share (sidebarowy nie jest widoczny na mobile) --}}
      <div class="mt-10 lg:hidden">
        @include('partials.guide.share')
      </div>

    </div>

  </div>
</section>
