<div class="py-10 lg:py-14">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-6 lg:mb-8">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Nagłówek --}}
  @if ($heading)
    <h2 class="font-poppins text-xl font-bold leading-snug text-black mb-6 lg:mb-8">
      {{ $heading }}
    </h2>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">

    {{-- TAK --}}
    @if (! empty($positive['items']))
      <div class="bg-primary/5 border border-primary/15 rounded-lg p-6 lg:p-7">
        <p class="font-poppins font-semibold text-base text-black mb-5">
          {{ $positive['title'] }}
        </p>
        <ul class="flex flex-col gap-3.5 list-none p-0 m-0">
          @foreach ($positive['items'] as $item)
            <li class="flex items-start gap-3">
              <span class="size-6 shrink-0 mt-0.5 rounded-full bg-primary flex items-center justify-center" aria-hidden="true">
                <x-icons.check class="size-4 text-white" />
              </span>
              <span class="font-poppins text-sm leading-relaxed text-black">{{ $item }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- NIE --}}
    @if (! empty($negative['items']))
      <div class="bg-[#f1f1f1] border border-black/10 rounded-lg p-6 lg:p-7">
        <p class="font-poppins font-semibold text-base text-black mb-5">
          {{ $negative['title'] }}
        </p>
        <ul class="flex flex-col gap-3.5 list-none p-0 m-0">
          @foreach ($negative['items'] as $item)
            <li class="flex items-start gap-3">
              <span class="size-6 shrink-0 mt-0.5 rounded-full bg-black/10 flex items-center justify-center" aria-hidden="true">
                <x-icons.x-mark class="size-4 text-black/50" />
              </span>
              <span class="font-poppins text-sm leading-relaxed text-black/70">{{ $item }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    @endif

  </div>

</div>
