{{-- Related posts — 3 cards (x-blog-card) --}}
@if ($relatedPosts)
  <section class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">
    <div class="flex flex-col gap-10">

      {{-- Header --}}
      <div class="flex flex-wrap items-end justify-between gap-4">
        <div class="flex flex-col gap-2">
          <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Czytaj dalej</span>
          <h2 class="font-serif text-3xl lg:text-4xl text-black">Powiązane wpisy</h2>
        </div>

        <a
          href="{{ $blogUrl }}"
          class="hidden lg:inline-flex items-center gap-2 font-poppins text-sm font-medium text-primary hover:underline"
        >
          Wszystkie wpisy
          <x-icons.arrow-right class="size-4" />
        </a>
      </div>

      {{-- Cards --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($relatedPosts as $rp)
          <x-blog-card
            :title="$rp['title']"
            :excerpt="$rp['excerpt']"
            :date="$rp['date']"
            :author="$rp['author']"
            :url="$rp['url']"
            :image="$rp['image']"
            :reading-time="$rp['readingTime']"
          />
        @endforeach
      </div>

    </div>
  </section>
@endif
