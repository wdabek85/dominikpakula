{{--
  Szkielet układu lookbooka — wyłącznie do podglądu pustego bloku w edytorze.
  Odwzorowuje ten sam grid co `blocks.lookbook-section`, żeby edytor od razu
  widział wybrany layout (i stronę, po której stanie duże zdjęcie).

  Zmienne: $layout ('grid-3' | 'grid-4' | 'split'), $featuredFirst (bool).
--}}
@php
  $box = 'block rounded bg-black/10';
@endphp

@if ($layout === 'split')

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
    <span class="{{ $box }} aspect-[4/5] {{ $featuredFirst ? '' : 'lg:order-2' }}"></span>
    <div class="lg:aspect-[4/5] grid grid-cols-2 grid-rows-2 gap-3 {{ $featuredFirst ? '' : 'lg:order-1' }}">
      @for ($i = 0; $i < 4; $i++)
        <span class="{{ $box }} min-h-[64px] h-full"></span>
      @endfor
    </div>
  </div>

@elseif ($layout === 'grid-6')

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
    <div class="flex flex-col gap-3">
      <span class="{{ $box }} aspect-square"></span>
      <div class="grid grid-cols-2 gap-3">
        <span class="{{ $box }} aspect-[3/4]"></span>
        <span class="{{ $box }} aspect-[3/4]"></span>
      </div>
    </div>
    <div class="flex flex-col gap-3">
      <div class="grid grid-cols-2 gap-3">
        <span class="{{ $box }} aspect-[3/4]"></span>
        <span class="{{ $box }} aspect-[3/4]"></span>
      </div>
      <span class="{{ $box }} aspect-square"></span>
    </div>
  </div>

@elseif ($layout === 'grid-4')

  <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
    @for ($i = 0; $i < 4; $i++)
      <span class="{{ $box }} aspect-[3/4]"></span>
    @endfor
  </div>

@else

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
    @for ($i = 0; $i < 3; $i++)
      <span class="{{ $box }} aspect-[3/4]"></span>
    @endfor
  </div>

@endif
