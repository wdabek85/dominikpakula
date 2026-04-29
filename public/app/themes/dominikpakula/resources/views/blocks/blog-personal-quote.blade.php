<figure class="not-prose my-10 lg:my-12 max-w-[820px] mx-auto bg-[#f1f1f1] rounded p-6 lg:p-8 flex flex-col sm:flex-row gap-5 lg:gap-6 items-start">

  {{-- Foto Dominika --}}
  <div class="shrink-0 size-[88px] sm:size-[100px] rounded-full overflow-hidden bg-black/10">
    @if ($image)
      <img
        src="{{ $image }}"
        alt="{{ $author }}"
        class="size-full object-cover"
        width="100"
        height="100"
        loading="lazy"
      >
    @else
      <div class="size-full flex items-center justify-center" aria-hidden="true">
        <span class="font-poppins font-semibold text-2xl text-[#19121e]/30">DP</span>
      </div>
    @endif
  </div>

  {{-- Cytat + autor --}}
  <div class="flex flex-col gap-3 flex-1">
    <blockquote class="font-poppins text-base lg:text-lg leading-relaxed italic text-black">
      „{{ $text }}"
    </blockquote>
    <figcaption class="flex items-center gap-2 font-poppins text-sm text-black">
      <span class="font-semibold">{{ $author }}</span>
      @if ($role)
        <span class="text-black/50">·</span>
        <span class="text-black/60">{{ $role }}</span>
      @endif
    </figcaption>
  </div>

</figure>
