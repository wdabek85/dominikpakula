@props([
  'title' => '',
  'category' => '',
  'image' => '',
  'link' => '',
])

<article class="relative shrink-0 w-[280px] h-[480px] lg:w-auto lg:h-[600px] lg:aspect-[3/4] rounded overflow-hidden group">

  {{-- Zdjęcie --}}
  @if ($image)
    <img
      src="{{ $image }}"
      alt="{{ $title }}"
      class="absolute inset-0 size-full object-cover transition-transform duration-500 group-hover:scale-105"
      loading="lazy"
      width="450"
      height="600"
    >
  @endif

  {{-- Gradient overlay --}}
  <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>

  {{-- Content --}}
  <div class="relative flex items-end h-full p-4 lg:p-8">
    <div class="flex items-end gap-6 w-full">

      {{-- Tekst --}}
      <div class="flex flex-col gap-2 flex-1">
        @if ($category)
          <p class="font-poppins text-base leading-5 text-white">
            {{ $category }}
          </p>
        @endif

        @if ($title)
          <h3 class="font-serif text-[30px] lg:text-[32px] leading-none text-white">
            {{ $title }}
          </h3>
        @endif
      </div>

      {{-- Strzałka --}}
      @if ($link)
        <a
          href="{{ $link }}"
          class="flex items-center justify-center size-10 rounded-full bg-white text-[#19121e] shrink-0 transition-transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
          aria-label="Zobacz realizację: {{ $title }}"
        >
          <x-icons.arrow-up-right class="size-6" />
        </a>
      @endif

    </div>
  </div>

</article>
