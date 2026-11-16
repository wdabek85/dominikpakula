{{-- Gdzie działam — zdanie + linki tekstowe do miast i zakupów online (linkowanie wewnętrzne) --}}
@if ($heading || ! empty($links))
  <x-section aria-labelledby="service-areas-heading">
    <div class="flex flex-col gap-2.5 mb-8 max-w-[720px]">
      @if ($eyebrow)
        <x-eyebrow :label="$eyebrow" />
      @endif

      <x-heading id="service-areas-heading">{{ $heading }}</x-heading>

      @if ($text)
        <p class="font-poppins text-base leading-relaxed text-black">
          {{ $text }}
        </p>
      @endif
    </div>

    <x-link-list :items="$links" cols="3" />
  </x-section>
@endif
