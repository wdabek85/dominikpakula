{{-- Browse full blog — category chips + "Wszystkie wpisy" CTA --}}
<x-section>
  <div class="flex flex-col items-center gap-6 text-center">

    <x-eyebrow label="Więcej do przeczytania" align="center" />

    <x-heading>Przeglądaj cały blog</x-heading>

    <p class="font-poppins text-base text-black/80 leading-relaxed max-w-[560px]">
      Zacznij od kategorii, która Cię interesuje, albo zobacz wszystkie wpisy po kolei.
    </p>

    @if ($categoriesTop)
      <div class="flex flex-wrap items-center justify-center gap-2 mt-2">
        @foreach ($categoriesTop as $cat)
          <a
            href="{{ $cat['url'] }}"
            @class([
              'inline-flex items-center gap-2 font-poppins text-sm rounded-full px-4 py-2 border transition-colors',
              'bg-primary text-white border-primary hover:bg-primary/90' => $cat['isCurrent'],
              'bg-white text-black border-black/20 hover:border-primary' => ! $cat['isCurrent'],
            ])
          >
            <span>{{ $cat['name'] }}</span>
            <span @class([
              'font-poppins text-xs',
              'text-white/70' => $cat['isCurrent'],
              'text-black/50' => ! $cat['isCurrent'],
            ])>
              {{ $cat['count'] }}
            </span>
          </a>
        @endforeach
      </div>
    @endif

    <a
      href="{{ $blogUrl }}"
      class="mt-6 inline-flex items-center gap-2 bg-primary text-white font-poppins font-medium text-base px-8 py-4 rounded-sm hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 transition-colors"
    >
      <span>Zobacz wszystkie wpisy</span>
      <x-icons.arrow-right class="size-5" />
    </a>

  </div>
</x-section>
