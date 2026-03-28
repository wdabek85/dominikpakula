@props([
  'image' => null,
  'youtubeId' => null,
  'heading' => 'Zanim Zaczniemy Poznaj mnie',
  'description' => 'Nazywam się Dominik Pakuła. Pomagam mężczyznom wyglądać tak, jak chcieliby wyglądać — bez rewolucji, bez przebierania i bez gadania o trendach, które nikogo nie obchodzą',
  'buttonText' => 'Poznaj moją historię →',
  'buttonUrl' => '#',
  'videoLabel' => 'Obejrzyj Wideo',
])

<section class="mx-auto max-w-[1440px] relative h-[680px] lg:h-[600px]">
  {{-- Background Image + Overlay --}}
  @if ($image)
    <img
      src="{{ $image }}"
      alt=""
      aria-hidden="true"
      class="absolute inset-0 size-full object-cover object-top"
    >
  @endif
  <div class="absolute inset-0 bg-black/30"></div>

  {{-- Content --}}
  <div class="relative flex flex-col gap-6 justify-end h-full px-4 lg:px-20 py-8 transition-opacity duration-[600ms]">

    {{-- Heading + Description + Button --}}
    <div class="flex flex-col lg:flex-row lg:items-end gap-6 lg:gap-12">
      {{-- Heading --}}
      <h2 class="font-sans font-medium text-[30px] lg:text-[50px] text-white leading-normal shrink-0">
        @if (str_contains($heading, ' '))
          @php
            $words = explode(' ', $heading);
            $mid = (int) ceil(count($words) / 2);
          @endphp
          <span class="lg:block">{{ implode(' ', array_slice($words, 0, $mid)) }}</span>
          <span class="lg:block"> {{ implode(' ', array_slice($words, $mid)) }}</span>
        @else
          {{ $heading }}
        @endif
      </h2>

      {{-- Description --}}
      <p class="font-sans font-light text-base text-white leading-normal flex-1">
        {{ $description }}
      </p>

      {{-- Button --}}
      <a
        href="{{ $buttonUrl }}"
        class="inline-flex items-center justify-center bg-primary border border-white px-8 py-4 font-sans text-sm text-white text-center whitespace-nowrap transition-colors hover:bg-primary/90 w-full lg:w-auto shrink-0"
      >
        {{ $buttonText }}
      </a>
    </div>

    {{-- Video Play --}}
    @if ($youtubeId)
      <div
        class="flex items-center gap-2 cursor-pointer group relative"
        data-youtube-id="{{ $youtubeId }}"
        data-youtube-title="{{ $videoLabel }}"
        role="button"
        tabindex="0"
        aria-label="{{ $videoLabel }}"
      >
        <span class="flex items-center justify-center size-12 rounded-full bg-white text-primary group-hover:scale-110 transition-transform">
          <x-icons.play-circle class="size-8 stroke-primary fill-none" />
        </span>
        <span class="font-sans font-medium text-2xl text-white">
          {{ $videoLabel }}
        </span>
      </div>
    @endif
  </div>
</section>
