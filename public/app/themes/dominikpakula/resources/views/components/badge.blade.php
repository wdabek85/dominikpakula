{{-- Badge sekcji w kolumnie usługi. as="h2" gdy badge jest jedynym nagłówkiem bloku (hierarchia nagłówków). --}}
@props(['label', 'as' => 'span'])

<{{ $as }} {{ $attributes->merge(['class' => 'inline-block border-2 border-black rounded-sm px-2.5 py-1 font-poppins font-semibold text-base leading-tight text-black']) }}>
  {{ $label }}
</{{ $as }}>
