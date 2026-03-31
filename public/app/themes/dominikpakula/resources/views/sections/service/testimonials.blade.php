<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12 overflow-hidden">

  {{-- Nagłówek --}}
  <div class="flex flex-col gap-2.5 mb-5 lg:mb-8">
    <h2 class="font-serif text-[30px] leading-none text-primary">
      Co mówią nasi klienci
    </h2>
    <p class="font-poppins text-base leading-5 text-black">
      Poznaj opinie osób, które skorzystały z naszych usług.
    </p>
  </div>

  {{-- Slider z opiniami --}}
  @if ($testimonials)
    <div class="-mr-4 lg:-mr-20 overflow-hidden">
      <div
        class="flex gap-6 lg:gap-12 overflow-x-auto snap-x snap-mandatory pb-4 pr-4 lg:pr-20 scrollbar-hide select-none"
        role="list"
        aria-label="Opinie klientów"
        data-drag-scroll
      >
        @foreach ($testimonials as $testimonial)
          <div class="snap-start shrink-0" role="listitem">
            <x-testimonial-card
              :quote="$testimonial['quote']"
              :author="$testimonial['author']"
              :service="$testimonial['service']"
              :mediaType="$testimonial['media_type']"
              :image="$testimonial['image']"
              :videoUrl="$testimonial['video_url']"
            />
          </div>
        @endforeach
      </div>
    </div>
  @endif

</section>
