<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

  {{-- Pasek filtrów (chipsy kategorii) --}}
  @if (! empty($categories))
    @php
      $baseUrl = remove_query_arg(['category', 'paged'], add_query_arg(null, null));
      $catUrl = fn ($slug) => $slug !== '' ? add_query_arg('category', $slug, $baseUrl) : $baseUrl;
    @endphp

    <div class="flex flex-wrap gap-1.5 mb-10">
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
  @endif

  {{-- Grid poradników --}}
  @if (! empty($guides))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach ($guides as $guide)
        <x-blog-card
          :title="$guide['title']"
          :excerpt="$guide['excerpt']"
          :date="$guide['date']"
          :url="$guide['url']"
          :image="$guide['image']"
        />
      @endforeach
    </div>

    {!! $paginationHtml !!}
  @elseif ($currentCategory !== '')
    {{-- Filtr nic nie zwrócił --}}
    <p class="font-poppins text-base text-black/60 text-center py-10">
      Brak poradników w tej kategorii.
    </p>
  @else
    {{-- Pusty stan — jeszcze nic tu nie ma + zachęta do newslettera --}}
    <div class="flex flex-col items-center gap-6 text-center bg-[#f1f1f1] rounded-sm px-6 py-12 lg:px-10 lg:py-16">

      <span class="flex items-center justify-center size-16 rounded-full bg-white text-primary shrink-0">
        <x-icons.document class="size-8" />
      </span>

      <div class="flex flex-col gap-3 max-w-[560px]">
        <h2 class="font-poppins text-2xl lg:text-3xl leading-tight text-black">
          Poradniki są już w drodze
        </h2>
        <p class="font-poppins text-base text-black/70 leading-relaxed">
          Jeszcze nic tu nie ma, ale już wkrótce pojawi się mnóstwo praktycznych poradników o stylu, doborze garderoby i budowaniu własnego looku. Zapisz się do newslettera, żeby nie przegapić żadnego z nich.
        </p>
      </div>

      <a
        href="#newsletter-form"
        class="group inline-flex items-center gap-2 bg-primary text-white font-poppins font-medium text-base px-6 py-3 rounded-sm hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 transition-colors"
      >
        <x-icons.envelope class="size-5" />
        <span>Zapisz się do newslettera</span>
        <x-icons.arrow-right class="size-4 transition-transform group-hover:translate-x-1" />
      </a>

    </div>
  @endif

</section>
