@if ($text || $eyebrow)
  <section class="not-prose mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-16">
    <div class="max-w-[860px] border-l-2 border-primary pl-6 lg:pl-10">

      @if ($eyebrow)
        <span class="block font-metro text-xs uppercase tracking-[3px] text-black/60 mb-4 lg:mb-5">{{ $eyebrow }}</span>
      @endif

      @if ($text)
        <p class="font-poppins font-medium text-[26px] lg:text-[38px] leading-[1.2] tracking-tight text-[#19121e]">
          {{ $text }}
        </p>
      @endif

      @if ($attribution)
        <span class="block mt-5 font-poppins text-sm text-black/50">— {{ $attribution }}</span>
      @endif

    </div>
  </section>
@endif
