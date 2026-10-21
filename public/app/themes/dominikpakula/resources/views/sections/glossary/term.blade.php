{{-- Treść hasła: nadtytuł, H1, lead (zajawka), definicja z edytora. Lewa kolumna single-glossary. --}}
<div class="flex flex-col gap-6">
  <x-eyebrow label="Słowniczek" />

  <h1 class="font-poppins text-[34px] md:text-5xl lg:text-[56px] leading-tight lg:leading-none text-black">
    {{ $title }}
  </h1>

  @if ($lead)
    <p class="font-poppins text-lg lg:text-xl leading-relaxed text-black/80">
      {{ $lead }}
    </p>
  @endif

  @if ($content)
    <div class="prose prose-lg max-w-none
                prose-headings:font-serif prose-headings:font-normal prose-headings:text-black
                prose-h2:text-3xl prose-h2:mt-10 prose-h2:mb-4 prose-h2:leading-tight
                prose-h3:text-2xl prose-h3:mt-8 prose-h3:mb-3
                prose-p:font-poppins prose-p:text-black prose-p:leading-relaxed
                prose-a:text-primary prose-a:underline-offset-[3px]
                prose-strong:font-semibold prose-strong:text-black
                prose-ul:font-poppins prose-ol:font-poppins">
      {!! apply_filters('the_content', $content) !!}
    </div>
  @endif
</div>
