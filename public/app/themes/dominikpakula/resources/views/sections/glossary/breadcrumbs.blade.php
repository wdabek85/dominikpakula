{{-- Breadcrumbs słowniczka — pełna szerokość, styl jak poradniki/blog. Ostatni element bez url = bieżąca strona. --}}
@if (! empty($breadcrumbs))
  <div class="bg-[#f2f2f2]">
    <nav
      class="mx-auto max-w-[1440px] px-4 lg:px-20 py-3 overflow-x-auto scrollbar-hide"
      aria-label="Breadcrumbs"
      itemscope
      itemtype="https://schema.org/BreadcrumbList"
    >
      <ol class="flex items-center gap-[3px] whitespace-nowrap">
        @foreach ($breadcrumbs as $crumb)
          <li
            class="flex items-center gap-[3px] shrink-0"
            itemprop="itemListElement"
            itemscope
            itemtype="https://schema.org/ListItem"
          >
            @if ($crumb['url'])
              <a href="{{ $crumb['url'] }}" class="font-poppins text-[10px] text-black hover:underline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary" itemprop="item">
                <span itemprop="name">{{ $crumb['label'] }}</span>
              </a>
            @else
              <span class="font-poppins text-[10px] font-bold text-black" itemprop="name" aria-current="page">{{ $crumb['label'] }}</span>
            @endif
            <meta itemprop="position" content="{{ $loop->iteration }}">

            @unless ($loop->last)
              <x-icons.chevron-right class="size-[11px] text-black" />
            @endunless
          </li>
        @endforeach
      </ol>
    </nav>
  </div>
@endif
