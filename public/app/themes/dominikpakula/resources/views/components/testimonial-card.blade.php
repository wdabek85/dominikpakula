@props([
  'quote' => '',
  'author' => '',
  'service' => '',
  'mediaType' => 'image',
  'image' => '',
  'videoUrl' => '',
])

<article class="flex flex-col gap-6 shrink-0 w-[85vw] sm:w-[380px] lg:w-[600px]">

  {{-- Media --}}
  <div class="relative h-[240px] lg:h-[320px] rounded overflow-hidden">
    @if ($image)
      <img
        src="{{ $image }}"
        alt="{{ $author }}"
        class="absolute inset-0 size-full object-cover"
        loading="lazy"
        width="600"
        height="320"
      >
    @endif

    @if ($mediaType === 'video' && $videoUrl)
      <button
        class="absolute bottom-8 left-8 flex items-center justify-center size-8 rounded-full bg-white text-primary transition-transform hover:scale-110 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
        data-testimonial-video="{{ $videoUrl }}"
        aria-label="Odtwórz opinię wideo — {{ $author }}"
        type="button"
      >
        <x-icons.play-circle class="size-5" />
      </button>
    @endif
  </div>

  {{-- Quote + Author --}}
  <div class="flex flex-col gap-2">
    @if ($quote)
      <blockquote class="font-poppins font-light text-lg leading-normal text-black">
        {{ $quote }}
      </blockquote>
    @endif

    @if ($author || $service)
      <p class="font-poppins font-light text-sm text-black">
        {{ $author }}@if ($service) — {{ $service }}@endif
      </p>
    @endif
  </div>

</article>
