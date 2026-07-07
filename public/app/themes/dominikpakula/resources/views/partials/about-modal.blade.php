{{-- About Modal — globalny. Treść: Ustawienia → "Sekcja: Poznaj mnie". Otwierany przez .about-trigger --}}
<div
  id="about-modal"
  class="fixed inset-0 z-[60] hidden"
  aria-modal="true"
  role="dialog"
  aria-labelledby="about-modal-title"
>
  {{-- Overlay --}}
  <div class="absolute inset-0 bg-black/60" data-about-close></div>

  {{-- Panel --}}
  <div class="absolute inset-4 lg:inset-auto lg:top-1/2 lg:left-1/2 lg:-translate-x-1/2 lg:-translate-y-1/2 lg:w-full lg:max-w-lg bg-white rounded-lg shadow-2xl flex flex-col max-h-[calc(100vh-2rem)] overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 shrink-0">
      <h2 class="font-poppins font-semibold text-lg text-black" id="about-modal-title">{{ $aboutHeading }}</h2>
      <button data-about-close class="text-gray-400 hover:text-black transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-primary rounded-sm cursor-pointer" aria-label="Zamknij">
        <x-icons.x-mark class="size-6" />
      </button>
    </div>

    {{-- Treść (HTML z panelu, przepuszczony przez wp_kses_post) --}}
    <div class="px-6 py-5 overflow-y-auto font-poppins text-sm leading-relaxed text-[#19121e] [&>p]:mb-4 [&>p:last-child]:mb-0 [&_a]:text-primary [&_a]:underline [&_strong]:font-semibold">
      {!! $aboutBody !!}
    </div>

    {{-- Footer: link do pełnej historii --}}
    @if ($aboutLinkUrl && $aboutLinkLabel)
      <div class="px-6 py-4 border-t border-gray-100 shrink-0">
        <a
          href="{{ $aboutLinkUrl }}"
          class="inline-flex items-center justify-center gap-2 w-full bg-primary border border-white px-6 py-3 rounded-sm font-poppins font-medium text-base text-white transition-colors hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
        >
          {{ $aboutLinkLabel }}
          <x-icons.arrow-right class="size-4" />
        </a>
      </div>
    @endif

  </div>
</div>
