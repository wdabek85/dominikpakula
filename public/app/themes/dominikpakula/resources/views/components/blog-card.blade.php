@props([
  'title' => '',
  'excerpt' => '',
  'date' => '',
  'author' => '',
  'authorAvatar' => '',
  'authorRole' => '',
  'category' => '',
  'url' => '#',
  'image' => '',
  'readingTime' => null,
  'withShadow' => false,
])

<article {{ $attributes->class([
  'group flex flex-col gap-4 rounded-[20px] bg-white transition-shadow duration-300',
  'shadow-[1px_1px_20px_0px_rgba(0,0,0,0.1)]' => $withShadow,
]) }}>

  {{-- Obrazek --}}
  @if ($image)
    <a href="{{ $url }}" class="block h-[206px] rounded overflow-hidden" aria-label="{{ $title }}">
      <img
        src="{{ $image }}"
        alt="{{ $title }}"
        class="size-full object-cover transition-transform duration-500 ease-out group-hover:scale-105"
        loading="lazy"
        width="440"
        height="206"
      >
    </a>
  @endif

  {{-- Treść --}}
  <div class="flex flex-col gap-2 px-2.5 pb-4">

    {{-- Meta: kategoria bold + data, lub autor | data --}}
    @if ($category || $author || $date || $readingTime)
      <p class="font-sans text-xs leading-tight text-[#8f8f8f]">
        @if ($category)
          <span class="font-bold text-black uppercase">{{ $category }}</span>@if ($date) <span> {{ $date }}</span>@endif
        @else
          {{ $author }}@if ($author && $date) | @endif{{ $date }}@if (($author || $date) && $readingTime) &middot; @endif{{ $readingTime ? $readingTime . ' min czytania' : '' }}
        @endif
      </p>
    @endif

    @if ($title)
      <h3 class="font-poppins font-semibold text-lg leading-none text-black">
        <a href="{{ $url }}" class="hover:text-primary transition-colors">{{ $title }}</a>
      </h3>
    @endif

    @if ($excerpt)
      <p class="font-sans text-xs leading-tight text-black">
        {{ $excerpt }}
      </p>
    @endif

    {{-- Stopka: autor avatar + imię + rola --}}
    @if ($authorAvatar || ($author && $authorRole))
      <div class="flex items-center gap-2 mt-2">
        @if ($authorAvatar)
          <img
            src="{{ $authorAvatar }}"
            alt=""
            aria-hidden="true"
            class="size-10 rounded-full object-cover shrink-0"
            width="40"
            height="40"
            loading="lazy"
          >
        @endif
        <div class="flex flex-col gap-0.5 leading-tight">
          @if ($author)
            <span class="font-sans text-base text-black">{{ $author }}</span>
          @endif
          @if ($authorRole)
            <span class="font-sans text-sm text-[rgba(128,131,147,0.87)]">{{ $authorRole }}</span>
          @endif
        </div>
      </div>
    @else
      <a
        href="{{ $url }}"
        class="font-poppins font-bold text-xs leading-tight text-[#655098] underline hover:text-[#4a3a78] transition-colors mt-1"
      >
        Czytaj Więcej &gt;
      </a>
    @endif

  </div>

</article>
