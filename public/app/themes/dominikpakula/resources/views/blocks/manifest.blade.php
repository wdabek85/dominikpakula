@if ($text || $eyebrow)
  <section class="not-prose mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-20">
    <div class="bg-[#f1f1f1] rounded-lg px-6 py-14 lg:px-16 lg:py-20 flex flex-col items-center gap-5 lg:gap-6 text-center">

      @if ($eyebrow)
        <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">{{ $eyebrow }}</span>
      @endif

      @if ($text)
        <p class="font-poppins font-medium text-3xl lg:text-[46px] leading-[1.15] tracking-tight text-[#19121e] max-w-[900px]">
          {{ $text }}
        </p>
      @endif

      @if ($attribution)
        <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">— {{ $attribution }}</span>
      @endif

    </div>
  </section>
@endif
