@props([
  'number' => '',
  'title' => '',
  'description' => '',
])

<div class="bg-[#f1f1f1] flex flex-col gap-2.5 items-end px-4 py-8 rounded">
  <div class="flex flex-col gap-2 w-full">
    @if ($number || $title)
      <p class="font-oswald font-bold text-2xl tracking-[-0.24px] uppercase leading-[1.1]">
        <span class="text-[#655098]">{{ $number }}</span>
        <span class="text-[#02070d]"> {{ $title }}</span>
      </p>
    @endif

    @if ($description)
      <p class="font-work text-xs leading-[1.5] text-[#02070d]">
        {{ $description }}
      </p>
    @endif
  </div>

  @if ($number)
    <span class="font-poppins text-[98px] leading-[80px] text-right text-[rgba(152,152,152,0.2)] w-full select-none" aria-hidden="true">
      {{ $number }}
    </span>
  @endif
</div>
