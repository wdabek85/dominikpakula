{{--
  Grupa linków w stopce: nagłówek + lista.

  heading: tytuł grupy
  items:   [['label' => …, 'url' => …, 'target' => '_self'|'_blank', 'isCurrent' => bool], …]
--}}
@props([
  'heading' => '',
  'items' => [],
])

@if (! empty($items))
  <nav {{ $attributes->merge(['class' => 'flex flex-col gap-6 min-w-0']) }} @if ($heading) aria-label="{{ $heading }}" @endif>
    @if ($heading)
      <p class="font-poppins font-semibold text-base text-[#19121e]">
        {{ $heading }}
      </p>
    @endif

    <ul class="flex flex-col gap-3 text-sm font-poppins">
      @foreach ($items as $item)
        <li>
          <a
            href="{{ $item['url'] }}"
            @if (($item['target'] ?? '_self') !== '_self') target="{{ $item['target'] }}" rel="noopener" @endif
            @if (! empty($item['isCurrent'])) aria-current="page" @endif
            class="rounded-sm hover:text-primary transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-primary {{ ! empty($item['isCurrent']) ? 'font-semibold' : '' }}"
          >
            {{ $item['label'] }}
          </a>
        </li>
      @endforeach
    </ul>
  </nav>
@endif
