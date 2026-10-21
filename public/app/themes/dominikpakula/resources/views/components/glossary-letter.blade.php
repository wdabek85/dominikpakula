{{--
  Kafel litery słowniczka: duża litera + lista haseł.
  h-full — w siatce wszystkie kafle w rzędzie mają wysokość najwyższego.
  scroll-mt — kotwica nie chowa się pod przyklejonym paskiem alfabetu.
--}}
@props([
  'letter' => '',
  'id' => '',
  'count' => '',
  'terms' => [],
])

<section
  id="{{ $id }}"
  aria-labelledby="{{ $id }}-heading"
  {{ $attributes->merge(['class' => 'scroll-mt-6 h-full flex flex-col gap-5 bg-[#f2f2f2] rounded-sm p-6 lg:p-8']) }}
>
  <header class="flex items-end justify-between gap-4 pb-4 border-b border-[#19121e]/20">
    <h2 id="{{ $id }}-heading" class="font-serif text-6xl lg:text-7xl leading-none text-primary">
      {{ $letter }}
    </h2>

    @if ($count)
      <span class="font-metro text-xs uppercase tracking-[3px] text-black/70 pb-1">
        {{ $count }}
      </span>
    @endif
  </header>

  @if (! empty($terms))
    <ul class="flex flex-col gap-3">
      @foreach ($terms as $term)
        <li>
          <a
            href="{{ $term['link'] }}"
            class="group inline-flex items-center gap-2 font-poppins text-base lg:text-lg text-black hover:text-primary focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-colors"
          >
            <span class="underline decoration-transparent underline-offset-4 group-hover:decoration-current transition-colors">{{ $term['title'] }}</span>
            <x-icons.arrow-right class="size-4 shrink-0 opacity-0 -translate-x-1 group-hover:opacity-100 group-hover:translate-x-0 group-focus-visible:opacity-100 transition" aria-hidden="true" />
          </a>
        </li>
      @endforeach
    </ul>
  @endif
</section>
