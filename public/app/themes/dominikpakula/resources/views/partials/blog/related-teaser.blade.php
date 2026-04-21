{{-- Czytaj też — 1 karta w sidebarze --}}
<a href="{{ $teaserPost['url'] }}" class="group flex flex-col gap-3 pb-8 border-b border-black/10">
  <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Czytaj też</span>

  @if ($teaserPost['image'])
    <div class="aspect-[16/9] overflow-hidden rounded-sm">
      <img
        src="{{ $teaserPost['image'] }}"
        alt=""
        class="size-full object-cover transition-transform duration-500 group-hover:scale-105"
        loading="lazy"
        width="400"
        height="225"
      >
    </div>
  @endif

  <h4 class="font-serif text-base leading-snug text-black group-hover:text-primary transition-colors">
    {{ $teaserPost['title'] }}
  </h4>

  <p class="font-metro text-[10px] uppercase tracking-[2px] text-black/50">
    {{ $teaserPost['readingTime'] }} min czytania
  </p>
</a>
