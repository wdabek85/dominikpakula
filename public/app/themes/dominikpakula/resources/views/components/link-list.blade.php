{{--
  Siatka linków tekstowych w obramowanych kafelkach ze strzałką (styl kart local-seo, bez zdjęć).

  items: [['label' => …, 'url' => …], …]
  cols:  liczba kolumn od lg (2 | 3)
--}}
@props([
  'items' => [],
  'cols' => 2,
])

@php
  $grid = (int) $cols === 3 ? 'sm:grid-cols-2 lg:grid-cols-3' : 'sm:grid-cols-2';
@endphp

@if (! empty($items))
  <ul {{ $attributes->merge(['class' => "list-none p-0 m-0 grid grid-cols-1 {$grid} gap-3 lg:gap-4"]) }}>
    @foreach ($items as $item)
      <li>
        <a
          href="{{ $item['url'] }}"
          class="group flex items-center justify-between gap-4 h-full border border-[#e2e2e2] rounded-sm px-5 py-4 font-poppins text-sm lg:text-base text-[#19121e] transition-colors hover:border-primary hover:text-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
        >
          <span>{{ $item['label'] }}</span>
          <x-icons.arrow-right class="size-4 shrink-0 text-primary transition-transform group-hover:translate-x-1" />
        </a>
      </li>
    @endforeach
  </ul>
@endif
