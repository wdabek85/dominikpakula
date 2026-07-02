@props(['label'])

<span {{ $attributes->merge(['class' => 'border-2 border-black rounded-sm px-2.5 py-1 font-poppins font-semibold text-base leading-tight text-black']) }}>
  {{ $label }}
</span>
