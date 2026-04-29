<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">
  <div class="bg-[#f1f1f1] rounded-[12px] p-6 lg:p-12">
    <div class="flex flex-col lg:flex-row items-center lg:items-start gap-8 lg:gap-12">

      {{-- Zdjęcie Dominika --}}
      <div class="shrink-0 size-[180px] lg:size-[220px] rounded-full overflow-hidden bg-[#e7e7e7]">
        @if ($introImage)
          <img
            src="{{ $introImage['url'] }}"
            alt="{{ $introImage['alt'] ?? 'Dominik Pakuła' }}"
            class="size-full object-cover"
            loading="lazy"
            width="220"
            height="220"
          >
        @else
          <div class="size-full flex items-center justify-center" aria-hidden="true">
            <span class="font-poppins font-semibold text-5xl text-[#19121e]/30">DP</span>
          </div>
        @endif
      </div>

      {{-- Tekst --}}
      <div class="flex flex-col gap-4 lg:gap-5 text-center lg:text-left flex-1">
        @if ($introBadge)
          <span class="inline-flex w-fit self-center lg:self-start items-center gap-2 px-3 py-1 rounded-full bg-white border border-[#19121e]/15 font-poppins text-xs uppercase tracking-wider text-[#19121e]">
            <span class="size-2 rounded-full bg-green-500 animate-pulse" aria-hidden="true"></span>
            {{ $introBadge }}
          </span>
        @endif

        @if ($introHeading)
          <h2 class="font-poppins font-semibold text-2xl lg:text-[32px] leading-tight text-[#19121e]">
            {{ $introHeading }}
          </h2>
        @endif

        @if ($introText)
          <p class="font-poppins text-base lg:text-lg leading-relaxed text-[#19121e]/85">
            {!! nl2br(e($introText)) !!}
          </p>
        @endif

        {{-- Podpis --}}
        <div class="flex items-center justify-center lg:justify-start gap-2 mt-2 font-poppins text-sm text-[#19121e]/60">
          <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
          </svg>
          <span>Dominik Pakuła</span>
        </div>
      </div>

    </div>
  </div>
</section>
