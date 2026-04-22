<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-6 lg:py-12">

  {{-- Pasek filtrów --}}
  @if (! empty($categories) || ! empty($seasons))
    @php
      $baseUrl = remove_query_arg(['category', 'season', 'paged'], add_query_arg(null, null));
      $catUrl = function ($slug) use ($currentSeason, $baseUrl) {
        $args = [];
        if ($slug !== '') $args['category'] = $slug;
        if ($currentSeason !== '') $args['season'] = $currentSeason;
        return $args ? add_query_arg($args, $baseUrl) : $baseUrl;
      };
      $seasonUrl = function ($slug) use ($currentCategory, $baseUrl) {
        $args = [];
        if ($currentCategory !== '') $args['category'] = $currentCategory;
        if ($slug !== '') $args['season'] = $slug;
        return $args ? add_query_arg($args, $baseUrl) : $baseUrl;
      };
    @endphp

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-10">

      {{-- Lewa: chipsy kategorii --}}
      <div class="flex flex-wrap gap-1.5">
        <a
          href="{{ $catUrl('') }}"
          class="inline-flex items-center px-2.5 py-1 rounded-[2px] border border-[#19121e] font-sans text-[15px] uppercase whitespace-nowrap transition-colors {{ $currentCategory === '' ? 'bg-[#19121e] text-white' : 'text-[#19121e] hover:bg-black/5' }}"
        >
          Pokaż wszystkie
        </a>
        @foreach ($categories as $cat)
          <a
            href="{{ $catUrl($cat['slug']) }}"
            class="inline-flex items-center px-2.5 py-1 rounded-[2px] border border-[#19121e] font-sans text-[15px] uppercase whitespace-nowrap transition-colors {{ $currentCategory === $cat['slug'] ? 'bg-[#19121e] text-white' : 'text-[#19121e] hover:bg-black/5' }}"
          >
            {{ $cat['name'] }}
          </a>
        @endforeach
      </div>

      {{-- Prawa: dropdown sezon --}}
      @if (! empty($seasons))
        <details class="relative shrink-0 group">
          <summary class="list-none [&::-webkit-details-marker]:hidden cursor-pointer inline-flex items-center gap-1.5 px-2.5 py-1 rounded-[2px] border border-[#19121e] font-sans text-[15px] uppercase whitespace-nowrap text-[#19121e] hover:bg-black/5 transition-colors">
            {{ $currentSeason !== '' ? collect($seasons)->firstWhere('slug', $currentSeason)['name'] ?? 'Sezon' : 'Sezon' }}
            <x-icons.chevron-down class="size-4 stroke-2 transition-transform group-open:rotate-180" />
          </summary>
          <ul class="absolute right-0 top-full mt-1 z-10 w-max bg-white border border-[#19121e] rounded-[2px] shadow-lg py-1">
            <li>
              <a
                href="{{ $seasonUrl('') }}"
                class="block px-3 py-2 font-sans text-sm uppercase whitespace-nowrap {{ $currentSeason === '' ? 'bg-[#19121e] text-white' : 'text-[#19121e] hover:bg-black/5' }} transition-colors"
              >
                Wszystkie sezony
              </a>
            </li>
            @foreach ($seasons as $season)
              <li>
                <a
                  href="{{ $seasonUrl($season['slug']) }}"
                  class="block px-3 py-2 font-sans text-sm uppercase whitespace-nowrap {{ $currentSeason === $season['slug'] ? 'bg-[#19121e] text-white' : 'text-[#19121e] hover:bg-black/5' }} transition-colors"
                >
                  {{ $season['name'] }}
                </a>
              </li>
            @endforeach
          </ul>
        </details>
      @endif

    </div>
  @endif

  {{-- Grid wpisów --}}
  @if (! empty($posts))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach ($posts as $post)
        <x-blog-card
          :title="$post['title']"
          :excerpt="$post['excerpt']"
          :date="$post['date']"
          :category="$post['category']"
          :author="$post['author']"
          :authorAvatar="$post['authorAvatar']"
          :authorRole="$post['authorRole']"
          :url="$post['url']"
          :image="$post['image']"
        />
      @endforeach
    </div>

    {!! $paginationHtml !!}
  @else
    <p class="font-poppins text-base text-black/60 text-center py-10">
      @if ($currentCategory !== '' || $currentSeason !== '')
        Brak wpisów spełniających wybrane filtry.
      @else
        Wkrótce pojawią się tu pierwsze wpisy.
      @endif
    </p>
  @endif

</section>
