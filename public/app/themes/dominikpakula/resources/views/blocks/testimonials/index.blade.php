<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12 overflow-hidden">

  {{-- Nagłówek --}}
  @if ($title || $subtitle)
    <div class="flex flex-col gap-2.5 mb-5 lg:mb-8">
      @if ($title)
        <h2 class="font-serif text-[30px] leading-none text-[#19121e]">
          {{ $title }}
        </h2>
      @endif

      @if ($subtitle)
        <p class="font-poppins text-base leading-5 text-black">
          {{ $subtitle }}
        </p>
      @endif
    </div>
  @endif

  {{-- Grid opinii --}}
  @if ($testimonials)
    <div
      class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12"
      role="list"
      aria-label="Opinie klientów"
    >
      @foreach ($testimonials as $testimonial)
        <div role="listitem">
          <x-testimonial-card
            :quote="$testimonial['quote']"
            :author="$testimonial['author']"
            :service="$testimonial['service']"
          />
        </div>
      @endforeach
    </div>
  @endif

</section>
