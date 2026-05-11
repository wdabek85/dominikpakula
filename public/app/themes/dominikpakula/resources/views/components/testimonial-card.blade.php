@props([
  'quote' => '',
  'author' => '',
  'service' => '',
])

<article class="flex flex-col gap-4 h-full">

  {{-- Duży cudzysłów ozdobny --}}
  <span class="block font-serif text-7xl lg:text-8xl leading-[0.8] text-primary select-none -mb-6 lg:-mb-8" aria-hidden="true">&ldquo;</span>

  {{-- Quote --}}
  @if ($quote)
    <blockquote class="font-poppins font-light text-base lg:text-lg leading-relaxed text-black flex-1 pl-6 lg:pl-8">
      {{ $quote }}
    </blockquote>
  @endif

  {{-- Author --}}
  @if ($author || $service)
    <div class="font-poppins font-light text-sm pl-6 lg:pl-8">
      @if ($author)
        <p class="text-black">&mdash; {{ $author }}</p>
      @endif
      @if ($service)
        <p class="text-black/60">{{ $service }}</p>
      @endif
    </div>
  @endif

</article>
