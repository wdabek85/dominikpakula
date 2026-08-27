{{--
  Delikatne CTA w treści wpisu.

  Świadomie lżejsze od `blog-callout` (szare tło + kolorowa ramka + ikona) i od
  `blog-pullquote` (wyróżniona myśl) — to ma być cichy zaczep w toku czytania,
  nie baner. Stąd sam hairline 60px u góry, ten sam motyw co nagłówek lookbooka.
--}}
@if ($isEmpty)

  @if ($isPreview)
    <x-block-placeholder
      title="Delikatne CTA"
      hint="Pusto — dodaj tekst zachęty i link (np. do zakładki Usługi) w panelu po prawej."
    >
      <div class="flex flex-col items-center gap-3">
        <span class="block h-px w-[60px] bg-black/25"></span>
        <span class="block h-3 w-3/4 rounded bg-black/10"></span>
        <span class="block h-3 w-2/3 rounded bg-black/10"></span>
        <span class="block h-3 w-24 rounded bg-black/20 mt-2"></span>
      </div>
    </x-block-placeholder>
  @endif

@else

<aside class="not-prose my-10 lg:my-14 max-w-[720px] mx-auto text-center">

  {{-- Hairline — ten sam motyw co w nagłówku lookbooka --}}
  <span class="block h-px w-[60px] mx-auto bg-black/25" aria-hidden="true"></span>

  @if ($text)
    <p class="font-serif text-lg lg:text-xl leading-relaxed text-black/80 mt-6 lg:mt-8">
      {{ $text }}
    </p>
  @endif

  @if ($url)
    <a
      href="{{ $url }}"
      @if ($target === '_blank')
        target="_blank"
        rel="noopener"
      @endif
      class="group inline-flex items-center gap-3 mt-6 lg:mt-7 font-metro text-xs uppercase tracking-[3px] text-black hover:text-primary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 transition-colors duration-200"
    >
      <span class="border-b border-transparent group-hover:border-current pb-1">
        {{ $label }}
      </span>
      <x-icons.arrow-long-right
        class="w-6 h-auto shrink-0 transition-transform duration-300 group-hover:translate-x-1"
        aria-hidden="true"
      />
    </a>
  @endif

</aside>

@endif
