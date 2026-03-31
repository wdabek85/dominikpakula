<div class="py-6">

  {{-- Badge --}}
  @if ($label)
    <div class="mb-4">
      <x-badge :label="$label" />
    </div>
  @endif

  {{-- Opis --}}
  @if ($description)
    <p class="font-work text-xl leading-relaxed text-black mb-4">
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
            class="w-full flex items-center justify-between gap-6 py-5 text-left cursor-pointer"
            aria-expanded="false"
            data-faq-trigger
          >
            <span class="font-work font-bold text-xl leading-relaxed text-black">
              {{ $item['question'] }}
            </span>
            <x-icons.chevron-down class="size-8 text-black shrink-0 transition-transform duration-300" />
          </button>

          {{-- Odpowiedź --}}
          <div
            class="overflow-hidden max-h-0 transition-[max-height] duration-300 ease-in-out"
            data-faq-content
          >
            <p class="font-work text-lg leading-relaxed text-black pb-6 max-w-3xl">
              {{ $item['answer'] }}
            </p>
          </div>
        </div>
      @endforeach
    </div>
  @endif

</div>
