<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

  {{-- Nagłówek --}}
  @if ($stepsHeading || $stepsSubtitle)
    <div class="flex flex-col gap-3 mb-10 lg:mb-12 text-center max-w-[720px] mx-auto">
      @if ($stepsHeading)
        <h2 class="font-poppins font-semibold text-2xl lg:text-3xl leading-tight text-[#19121e]">
          {{ $stepsHeading }}
        </h2>
      @endif
      @if ($stepsSubtitle)
        <p class="font-poppins text-base text-[#19121e]/70 leading-relaxed">
          {{ $stepsSubtitle }}
        </p>
      @endif
    </div>
  @endif

  {{-- Kroki --}}
  <ol class="list-none p-0 m-0 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 relative">

    {{-- Linia łącząca (tylko desktop, na poziomie środka kółek 64/2=32px) --}}
    <div class="hidden md:block absolute top-[32px] left-[16%] right-[16%] h-px bg-[#19121e]/15 z-0" aria-hidden="true"></div>

    @foreach ($steps as $step)
      <li class="flex flex-col items-center text-center gap-4 relative">

        {{-- Numer w kółku --}}
        <div class="relative z-10 flex w-16 h-16 shrink-0 aspect-square items-center justify-center rounded-full bg-primary text-white font-poppins font-semibold text-xl leading-none shadow-[0_4px_20px_-2px_rgba(40,36,53,0.25)]">
          {{ $step['number'] }}
        </div>

        {{-- Tytuł + opis --}}
        <div class="flex flex-col gap-2 max-w-[320px]">
          <h3 class="font-poppins font-semibold text-lg lg:text-xl leading-tight text-[#19121e]">
            {{ $step['title'] }}
          </h3>
          <p class="font-poppins text-sm lg:text-base leading-relaxed text-[#19121e]/70">
            {{ $step['text'] }}
          </p>
        </div>

      </li>
    @endforeach

  </ol>

</section>
