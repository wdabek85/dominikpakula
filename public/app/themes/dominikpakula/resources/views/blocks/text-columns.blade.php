@if ($heading || $body)
  <section class="not-prose bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-12 lg:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10 items-start">

      {{-- Lewa: nagłówek --}}
      @if ($heading)
        <h2 class="font-poppins text-[26px] lg:text-[30px] leading-tight lg:leading-[38px] text-black">
          {{ $heading }}
        </h2>
      @endif

      {{-- Prawa: treść --}}
      @if ($body)
        <div class="font-poppins text-base leading-5 text-black space-y-5">
          {!! $body !!}
        </div>
      @endif

    </div>
  </section>
@endif
