@props([
  'title' => null,
  'subtitle' => null,
  'bg' => 'bg-white',
])

<section class="{{ $bg }} mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">
  @if ($title || $subtitle)
    <div class="flex flex-col gap-2.5 mb-5">
      @if ($title)
        <h2 class="font-poppins text-[30px] leading-none text-black">
          {!! $title !!}
        </h2>
      @endif

      @if ($subtitle)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $subtitle }}
        </p>
      @endif
    </div>
  @endif

  {{ $slot }}
</section>
