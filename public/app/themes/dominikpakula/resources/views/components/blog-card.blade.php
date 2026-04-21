@props([
  'title' => '',
  'excerpt' => '',
  'date' => '',
  'author' => '',
  'url' => '#',
  'image' => '',
  'readingTime' => null,
])

<article class="flex flex-col gap-4 rounded-[20px]">

  {{-- Obrazek --}}
  @if ($image)
    <div class="h-[206px] rounded overflow-hidden">
      <img
        src="{{ $image }}"
        alt="{{ $title }}"
        class="size-full object-cover"
        loading="lazy"
        width="440"
        height="206"
      >
    </div>
  @endif

  {{-- Treść --}}
  <div class="flex flex-col gap-2 px-2.5 pb-4">
    @if ($author || $date || $readingTime)
      <p class="font-sans text-xs leading-tight text-[#8f8f8f]">
        {{ $author }}@if ($author && $date) &middot; @endif{{ $date }}@if (($author || $date) && $readingTime) &middot; @endif{{ $readingTime ? $readingTime . ' min czytania' : '' }}
      </p>
    @endif

    @if ($title)
      <h3 class="font-poppins font-semibold text-lg leading-none text-black">
        {{ $title }}
      </h3>
    @endif

    @if ($excerpt)
      <p class="font-sans text-xs leading-tight text-black">
        {{ $excerpt }}
      </p>
    @endif

    <a
      href="{{ $url }}"
      class="font-poppins font-bold text-xs leading-tight text-[#655098] underline hover:text-[#4a3a78] transition-colors"
    >
      Czytaj Więcej &gt;
    </a>
  </div>

</article>
