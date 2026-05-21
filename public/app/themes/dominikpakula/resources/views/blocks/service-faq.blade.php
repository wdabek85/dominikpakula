<div class="py-10 lg:py-14">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-4">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Opis --}}
  @if ($description)
    <p class="font-poppins text-base leading-relaxed text-black mb-4">
      {{ $description }}
    </p>
  @endif

  {{-- Accordion --}}
  @if ($items)
    <div class="border-b border-black" data-faq-accordion>
      @foreach ($items as $item)
        <div class="border-t border-black" data-faq-item>
          {{-- Pytanie --}}
          <button
            class="w-full flex items-center justify-between gap-6 py-5 text-left cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
            aria-expanded="false"
            data-faq-trigger
          >
            <span class="font-poppins font-bold text-base leading-snug text-black">
              {{ $item['question'] }}
            </span>
            <x-icons.chevron-down class="size-6 text-black shrink-0 transition-transform duration-300" />
          </button>

          {{-- Odpowiedź --}}
          <div
            class="overflow-hidden max-h-0 transition-[max-height] duration-300 ease-in-out"
            data-faq-content
          >
            <p class="font-poppins text-sm leading-relaxed text-black pb-6 max-w-3xl">
              {{ $item['answer'] }}
            </p>
          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>
