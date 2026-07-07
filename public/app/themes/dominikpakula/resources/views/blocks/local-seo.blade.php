@if (! empty($items))
  <section class="py-10 lg:py-14">

    {{-- Nagłówek --}}
    @if ($eyebrow || $heading)
      <div class="flex flex-col gap-3 mb-8 lg:mb-10">
        @if ($eyebrow)
          <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">{{ $eyebrow }}</span>
        @endif
        @if ($heading)
          <h2 class="font-poppins font-medium text-[30px] lg:text-4xl leading-tight text-[#19121e]">
            {{ $heading }}
          </h2>
        @endif
      </div>
    @endif

    {{-- Siatka kart --}}
    <ul class="list-none p-0 m-0 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
      @foreach ($items as $item)
        <li>
          <a
            href="{{ $item['url'] }}"
            class="group flex flex-col h-full border border-[#e2e2e2] rounded-sm overflow-hidden transition-colors hover:border-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
          >
            {{-- Zdjęcie --}}
            <div class="relative aspect-[16/10] overflow-hidden bg-gray-100">
              @if ($item['image'])
                <img
                  src="{{ $item['image']['url'] }}"
                  alt="{{ $item['image']['alt'] ?: $item['title'] }}"
                  @if (! empty($item['image']['width'])) width="{{ $item['image']['width'] }}" @endif
                  @if (! empty($item['image']['height'])) height="{{ $item['image']['height'] }}" @endif
                  class="absolute inset-0 size-full object-cover transition-transform duration-[600ms] ease-out group-hover:scale-105"
                  loading="lazy"
                >
              @endif
            </div>

            {{-- Treść --}}
            <div class="flex flex-col gap-3 p-5 flex-1">
              <h3 class="font-poppins font-medium text-lg leading-snug text-[#19121e]">
                {{ $item['title'] }}
              </h3>
              <span class="mt-auto inline-flex items-center gap-2 font-poppins text-sm text-primary">
                Dowiedz się więcej
                <x-icons.arrow-right class="size-4 transition-transform group-hover:translate-x-1" />
              </span>
            </div>
          </a>
        </li>
      @endforeach
    </ul>

  </section>
@endif
