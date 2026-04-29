<figure class="not-prose my-10 lg:my-12 max-w-[820px] mx-auto">
  <div class="border-y border-black/15 py-8 lg:py-10 px-4 text-center relative">
    {{-- Dekoracyjny cudzysłów --}}
    <span class="block font-serif text-[80px] lg:text-[120px] leading-none text-black/15 select-none mb-2" aria-hidden="true">
      &ldquo;
    </span>

    <blockquote class="font-poppins text-2xl lg:text-[28px] leading-snug font-medium italic text-black">
      {{ $text }}
    </blockquote>

    @if ($attribution)
      <figcaption class="mt-5 font-metro text-xs uppercase tracking-[3px] text-black/60">
        — {{ $attribution }}
      </figcaption>
    @endif
  </div>
</figure>
