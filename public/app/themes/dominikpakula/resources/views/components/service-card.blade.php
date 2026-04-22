@props([
  'variant' => 'default',
  'category' => '',
  'title' => '',
  'icon' => null,
  'description' => '',
  'price' => '',
  'linkText' => 'Dowiedz się więcej',
  'linkUrl' => '#',
])

<div class="group bg-[#f1f1f1] flex flex-col rounded p-4 h-full transition-[transform,box-shadow] duration-300 ease-out hover:-translate-y-1 hover:shadow-xl {{ $variant === 'default' ? 'gap-[120px]' : 'gap-2.5' }}">

  @if ($variant === 'default')
    {{-- Variant: default --}}
    <div class="flex flex-col">
      @if ($category)
        <div class="border-b border-black/50 py-2">
          <span class="font-metro text-sm leading-4 text-[#19121e]">
            {{ $category }}
          </span>
        </div>
      @endif

      @if ($title)
        <div class="py-4">
          <h3 class="font-metro text-lg leading-[22px] text-[#19121e]">
            {{ $title }}
          </h3>
        </div>
      @endif
    </div>

    <div class="flex flex-col gap-[18px]">
      @if ($icon)
        <img
          src="{{ $icon['url'] }}"
          alt=""
          aria-hidden="true"
          class="size-20 object-cover opacity-30 transition-opacity duration-300 group-hover:opacity-100"
        >
      @endif

      @if ($description)
        <p class="font-metro text-xs leading-[14px] text-[#19121e]">
          {{ $description }}
        </p>
      @endif

      <a
        href="{{ $linkUrl }}"
        class="inline-flex items-center gap-2 border border-black rounded-sm px-2.5 py-0.5 font-poppins text-xs leading-[14px] text-[#19121e] hover:bg-black/5 transition-colors w-fit"
      >
        {{ $linkText }}
        <x-icons.arrow-long-right class="w-8 h-auto transition-transform duration-300 group-hover:translate-x-1" />
      </a>
    </div>

  @elseif ($variant === 'detailed')
    {{-- Variant: detailed (podstrona oferty) --}}
    <div class="flex flex-col">
      @if ($category)
        <div class="border-b border-black/50 py-2.5">
          <span class="font-metro text-sm leading-none text-[#19121e]">
            {{ $category }}
          </span>
        </div>
      @endif

      @if ($title)
        <div class="py-5">
          <h3 class="font-metro text-lg leading-none text-[#19121e]">
            {{ $title }}
          </h3>
        </div>
      @endif
    </div>

    <div class="flex flex-col gap-[18px]">
      @if ($icon)
        <img
          src="{{ $icon['url'] }}"
          alt=""
          aria-hidden="true"
          class="size-20 object-cover opacity-30 transition-opacity duration-300 group-hover:opacity-100"
        >
      @endif

      @if ($description)
        <p class="font-metro text-xs leading-none text-[#19121e]">
          {{ $description }}
        </p>
      @endif

      @if ($price)
        <p class="font-poppins text-[32px] leading-none text-[#19121e]">
          {{ $price }}
        </p>
      @endif

      <a
        href="{{ $linkUrl }}"
        class="inline-flex items-center gap-1.5 border border-[#19121e] rounded-sm px-2.5 py-0.5 font-poppins text-xs text-[#19121e] hover:bg-black/5 transition-colors w-fit"
      >
        {{ $linkText }}
        <x-icons.arrow-long-right class="w-8 h-auto transition-transform duration-300 group-hover:translate-x-1" />
      </a>
    </div>

  @else
    {{-- Variant: compact --}}
    <div class="flex items-start justify-between border-b border-black/50 py-5">
      @if ($title)
        <h3 class="font-metro text-lg leading-none text-[#19121e]">
          {{ $title }}
        </h3>
      @endif

      @if ($icon)
        <img
          src="{{ $icon['url'] }}"
          alt=""
          aria-hidden="true"
          class="size-[50px] object-cover opacity-30 shrink-0 transition-opacity duration-300 group-hover:opacity-100"
        >
      @endif
    </div>

    <div class="flex flex-col gap-3">
      @if ($description)
        <p class="font-metro text-xs leading-none text-[#19121e]">
          {{ $description }}
        </p>
      @endif

      @if ($price)
        <p class="font-poppins text-2xl leading-8 text-[#19121e]">
          {{ $price }}
        </p>
      @endif

      <a
        href="{{ $linkUrl }}"
        class="inline-flex items-center gap-1.5 border border-[#19121e] rounded-sm px-2.5 py-0.5 font-poppins text-xs text-[#19121e] hover:bg-black/5 transition-colors w-fit"
      >
        {{ $linkText }}
        <x-icons.arrow-long-right class="w-8 h-auto transition-transform duration-300 group-hover:translate-x-1" />
      </a>
    </div>
  @endif

</div>
