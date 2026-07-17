@props([
  'title' => '',
  'category' => '',
  'image' => '',
  'link' => '',
  'grid' => false,
])

<article class="relative overflow-hidden group rounded {{ $grid ? 'w-full aspect-[3/4]' : 'shrink-0 w-[240px] h-[380px] lg:w-auto lg:h-[460px] lg:aspect-[3/4]' }}">

  {{-- Link na całą kartę (stretched link) --}}
  @if ($link)
    <a
      href="{{ $link }}"
      class="absolute inset-0 z-20 rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-black"
      aria-label="Zobacz realizację: {{ $title }}"
      data-card-link
    ></a>
  @endif

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
  <div class="relative flex items-end h-full p-4 lg:p-6">
    <div class="flex items-end gap-4 w-full">

      {{-- Tekst --}}
      <div class="flex flex-col gap-1.5 flex-1 min-w-0">
        @if ($category)
          <p class="font-poppins text-sm leading-5 text-white">
            {{ $category }}
          </p>
        @endif

        @if ($title)
          <h3 class="font-serif text-xl lg:text-2xl leading-none text-white">
            {{ $title }}
          </h3>
        @endif
      </div>

      {{-- Strzałka (wizualna — cała karta jest linkiem powyżej) --}}
      @if ($link)
        <span
          class="flex items-center justify-center size-9 rounded-full bg-white text-[#19121e] shrink-0 transition-transform group-hover:scale-110"
          aria-hidden="true"
        >
          <x-icons.arrow-up-right class="size-5" />
        </span>
      @endif

    </div>
  </div>

</article>
