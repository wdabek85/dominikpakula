{{-- Prev / Next nav — 2 karty grid; empty placeholder gdy brak --}}
@if ($prevPost || $nextPost)
  <section class="mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

      @if ($prevPost)
        <a
          href="{{ $prevPost['url'] }}"
          class="group flex flex-col gap-2 p-6 bg-[#f9f9f9] hover:bg-[#efefef] rounded-sm transition-colors"
        >
          <span class="inline-flex items-center gap-2 font-metro text-xs uppercase tracking-[3px] text-black/60">
            <x-icons.arrow-left class="size-4" />
            Poprzedni
          </span>
          <span class="font-serif text-lg text-black group-hover:text-primary transition-colors">
            {{ $prevPost['title'] }}
          </span>
        </a>
      @else
        <div aria-hidden="true"></div>
      @endif

      @if ($nextPost)
        <a
          href="{{ $nextPost['url'] }}"
          class="group flex flex-col gap-2 p-6 bg-[#f9f9f9] hover:bg-[#efefef] rounded-sm transition-colors md:items-end md:text-right"
        >
          <span class="inline-flex items-center gap-2 font-metro text-xs uppercase tracking-[3px] text-black/60">
            Następny
            <x-icons.arrow-right class="size-4" />
          </span>
          <span class="font-serif text-lg text-black group-hover:text-primary transition-colors">
            {{ $nextPost['title'] }}
          </span>
        </a>
      @else
        <div aria-hidden="true"></div>
      @endif

    </div>
  </section>
@endif
