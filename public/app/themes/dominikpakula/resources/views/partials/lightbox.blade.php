{{-- Lightbox modal — uniwersalny, używany przez galerie z `data-lightbox-gallery` --}}
<div
  data-lightbox-modal
  class="fixed inset-0 z-50 hidden items-center justify-center"
  role="dialog"
  aria-modal="true"
  aria-labelledby="lightbox-title"
>
  {{-- Backdrop --}}
  <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" data-lightbox-close aria-hidden="true"></div>

  {{-- Close button --}}
  <button
    type="button"
    class="absolute top-4 right-4 z-10 size-12 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-white"
    data-lightbox-close
    aria-label="Zamknij"
  >
    <x-icons.x-mark class="size-6" />
  </button>

  {{-- Prev button --}}
  <button
    type="button"
    class="absolute left-4 top-1/2 -translate-y-1/2 z-10 size-12 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-white disabled:opacity-30 disabled:pointer-events-none"
    data-lightbox-prev
    aria-label="Poprzednie zdjęcie"
  >
    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
    </svg>
  </button>

  {{-- Next button --}}
  <button
    type="button"
    class="absolute right-4 top-1/2 -translate-y-1/2 z-10 size-12 rounded-full bg-white/10 text-white hover:bg-white/20 transition-colors flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-white disabled:opacity-30 disabled:pointer-events-none"
    data-lightbox-next
    aria-label="Następne zdjęcie"
  >
    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5" aria-hidden="true">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
    </svg>
  </button>

  {{-- Image container --}}
  <div class="relative max-w-[90vw] max-h-[90vh] flex flex-col items-center gap-4">
    <img
      data-lightbox-image
      src=""
      alt=""
      class="block max-w-full max-h-[80vh] object-contain rounded"
    >
    <p
      data-lightbox-caption
      id="lightbox-title"
      class="hidden font-poppins text-sm text-white/80 text-center max-w-[640px]"
    ></p>
    <span
      data-lightbox-counter
      class="font-poppins text-xs text-white/60 tracking-wider"
    ></span>
  </div>
</div>
