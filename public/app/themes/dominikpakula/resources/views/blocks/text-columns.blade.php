@if ($heading || $body)
  <x-section class="not-prose">
    <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr] gap-8 lg:gap-x-20 items-start">

      {{-- Lewa: nagłówek (szerokość = treść) --}}
      @if ($heading)
        <x-heading class="lg:whitespace-nowrap">{{ $heading }}</x-heading>
      @endif

      {{-- Prawa: treść --}}
      @if ($body)
        <div class="font-poppins text-base leading-5 text-black space-y-5">
          {!! $body !!}
        </div>
      @endif

    </div>
  </x-section>
@endif
