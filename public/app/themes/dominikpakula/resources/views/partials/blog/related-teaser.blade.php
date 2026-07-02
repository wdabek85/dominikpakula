{{-- Czytaj też — 1 karta w sidebarze (samo typo) --}}
<a href="{{ $teaserPost['url'] }}" class="group flex flex-col gap-3 pb-8 border-b border-black/10">
  <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Czytaj też</span>

  <h4 class="font-serif text-base leading-snug text-black group-hover:text-primary transition-colors">
    {{ $teaserPost['title'] }}
  </h4>

  <p class="font-metro text-[10px] uppercase tracking-[2px] text-black/50">
    {{ $teaserPost['readingTime'] }} min czytania
  </p>
</a>
