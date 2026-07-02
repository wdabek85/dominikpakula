@props([
  'image' => null,
  'youtubeId' => null,
  'heading' => 'Zanim Zaczniemy Poznaj mnie',
  'description' => 'Nazywam się Dominik Pakuła. Pomagam mężczyznom wyglądać tak, jak chcieliby wyglądać — bez rewolucji, bez przebierania i bez gadania o trendach, które nikogo nie obchodzą',
  'buttonText' => 'Poznaj moją historię →',
  'buttonUrl' => '',
  'videoLabel' => 'Obejrzyj Wideo',
  'variant' => 'hero',
])

@php
  $isContained = $variant === 'contained';

  $sectionClasses = $isContained
    ? 'relative h-[480px] lg:h-[420px] overflow-hidden rounded-sm'
    : 'mx-auto max-w-[1440px] relative h-[680px] lg:h-[600px]';

  $contentPadding = $isContained ? 'px-5 lg:px-6 py-6' : 'px-4 lg:px-20 py-8';
  $contentGap = $isContained ? 'gap-4 lg:gap-6' : 'gap-6';
  $rowGap = $isContained ? 'gap-4 lg:gap-8' : 'gap-6 lg:gap-12';

  $headingClasses = $isContained
    ? 'font-sans font-medium text-[26px] lg:text-[34px] text-white leading-tight shrink-0'
    : 'font-sans font-medium text-[30px] lg:text-[50px] text-white leading-normal shrink-0';

  $descriptionClasses = $isContained
    ? 'font-sans font-light text-sm text-white leading-normal flex-1'
    : 'font-sans font-light text-base text-white leading-normal flex-1';

  $buttonClasses = $isContained
    ? 'inline-flex items-center justify-center bg-primary border border-white px-6 py-3 font-sans text-sm text-white text-center whitespace-nowrap transition-colors hover:bg-primary/90 shrink-0'
    : 'inline-flex items-center justify-center bg-primary border border-white px-8 py-4 font-sans text-sm text-white text-center whitespace-nowrap transition-colors hover:bg-primary/90 w-full lg:w-auto shrink-0';

  $playButtonSize = $isContained ? 'size-10' : 'size-12';
  $playIconSize = $isContained ? 'size-6' : 'size-8';
  $playLabelSize = $isContained ? 'text-xl' : 'text-2xl';
@endphp

<section class="{{ $sectionClasses }}">
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
  <div class="relative flex flex-col {{ $contentGap }} justify-end h-full {{ $contentPadding }} transition-opacity duration-[600ms]">

    @if ($isContained)
      {{-- Contained: nagłówek na górze (justify-end pcha do dołu), w dolnym rzędzie play (lewa) + CTA button (prawa) --}}
      <h2 class="{{ $headingClasses }}">
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

      <div class="flex items-center justify-between gap-4 flex-wrap">
        @if ($youtubeId)
          <div
            class="flex items-center gap-2 cursor-pointer group relative"
            data-youtube-id="{{ $youtubeId }}"
            data-youtube-title="{{ $videoLabel }}"
            role="button"
            tabindex="0"
            aria-label="{{ $videoLabel }}"
          >
            <span class="flex items-center justify-center {{ $playButtonSize }} rounded-full bg-white text-primary group-hover:scale-110 transition-transform">
              <x-icons.play-circle class="{{ $playIconSize }} stroke-primary fill-none" />
            </span>
            <span class="font-sans font-medium {{ $playLabelSize }} text-white">
              {{ $videoLabel }}
            </span>
          </div>
        @else
          <span aria-hidden="true"></span>
        @endif

        @if ($buttonText && $buttonUrl)
          <a href="{{ $buttonUrl }}" class="{{ $buttonClasses }}">
            {{ $buttonText }}
          </a>
        @endif
      </div>
    @else
      {{-- Hero (homepage): heading + description + button w jednym rzędzie, play poniżej --}}
      <div class="flex flex-col lg:flex-row lg:items-end {{ $rowGap }}">
        <h2 class="{{ $headingClasses }}">
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

        @if ($description)
          <p class="{{ $descriptionClasses }}">
            {{ $description }}
          </p>
        @endif

        @if ($buttonText && $buttonUrl)
          <a href="{{ $buttonUrl }}" class="{{ $buttonClasses }}">
            {{ $buttonText }}
          </a>
        @endif
      </div>

      @if ($youtubeId)
        <div
          class="flex items-center gap-2 cursor-pointer group relative"
          data-youtube-id="{{ $youtubeId }}"
          data-youtube-title="{{ $videoLabel }}"
          role="button"
          tabindex="0"
          aria-label="{{ $videoLabel }}"
        >
          <span class="flex items-center justify-center {{ $playButtonSize }} rounded-full bg-white text-primary group-hover:scale-110 transition-transform">
            <x-icons.play-circle class="{{ $playIconSize }} stroke-primary fill-none" />
          </span>
          <span class="font-sans font-medium {{ $playLabelSize }} text-white">
            {{ $videoLabel }}
          </span>
        </div>
      @endif
    @endif

  </div>
</section>
