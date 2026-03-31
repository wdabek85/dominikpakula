<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-4">
  <div class="flex flex-col gap-5">

    {{-- Breadcrumb --}}
    @if ($breadcrumb)
      <nav class="font-poppins text-[10px] leading-3 text-black" aria-label="Breadcrumb">
        <a href="{{ home_url('/') }}" class="hover:underline">Strona główna</a>
        <span> / </span>
        <span class="font-bold">{{ $breadcrumb }}</span>
      </nav>
    @endif

    {{-- Tytuł + opis --}}
    <div class="flex flex-col gap-2.5">
      @if ($headerTitle)
        <h1 class="font-poppins text-5xl lg:text-[56px] leading-none text-black">
          {{ $headerTitle }}
        </h1>
      @endif

      @if ($headerDescription)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $headerDescription }}
        </p>
      @endif
    </div>

  </div>
</section>
