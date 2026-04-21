<div class="py-6">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-4">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Treść WYSIWYG --}}
  @if ($content)
    <div class="prose max-w-none
      prose-p:font-poppins prose-p:text-base prose-p:leading-relaxed prose-p:text-black
      prose-li:font-poppins prose-li:text-base prose-li:leading-relaxed prose-li:text-black prose-li:font-semibold
      prose-ul:list-disc prose-ul:pl-6
      prose-a:text-black prose-a:underline
    ">
      {!! $content !!}
    </div>
  @endif

  {{-- Banner prezentowy --}}
  <div class="mt-4">
    <x-gift-banner />
  </div>

</div>
