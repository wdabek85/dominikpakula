{{-- Blog hero — cover style, w naszym kontenerze z paddingami jak pozostałe sekcje --}}
<section class="mx-auto max-w-[1440px] px-4 lg:px-20">
  <div class="relative w-full h-[560px] lg:h-[600px] overflow-hidden">

    {{-- Featured image (or dark gradient fallback) --}}
    @if ($heroImageTag)
      {!! $heroImageTag !!}
    @else
      <div class="absolute inset-0 bg-gradient-to-br from-primary via-[#1a1523] to-black" aria-hidden="true"></div>
    @endif

    {{-- Overlays --}}
    <div class="absolute inset-0 bg-black/50 pointer-events-none" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none" aria-hidden="true"></div>

    {{-- Content — bottom-aligned --}}
    <div class="relative flex items-end h-full p-6 lg:p-10">
      <div class="flex flex-col gap-5 max-w-[900px]">

        {{-- Category label (decorative) --}}
        @if ($category)
          <x-eyebrow
            :label="$category['name']"
            color="text-white"
          />
        @endif

        {{-- Title — display serif, normal weight, clamp --}}
        <h1 class="font-serif font-normal text-white leading-[1.05] text-[clamp(2.25rem,5vw,4.5rem)]">
          {{ $title }}
        </h1>

        {{-- Lead — only when editor set a manual excerpt --}}
        @if ($lead)
          <p class="font-poppins text-lg lg:text-xl leading-relaxed text-white/85 max-w-[680px]">
            {{ $lead }}
          </p>
        @endif

        {{-- Meta — author · reading time · date --}}
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 font-metro text-[11px] leading-none tracking-[2px] uppercase text-white/80">
          @if ($author['name'])
            <a href="{{ $author['url'] }}" class="hover:text-white transition-colors">
              {{ $author['name'] }}
            </a>
            <span class="text-white/40" aria-hidden="true">&middot;</span>
          @endif

          <span>{{ $readingTime }} min czytania</span>

          @if ($date)
            <span class="text-white/40" aria-hidden="true">&middot;</span>
            <time datetime="{{ $dateIso }}">{{ $date }}</time>
          @endif
        </div>

      </div>
    </div>
  </div>
</section>
