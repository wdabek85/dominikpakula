{{-- Powiązane poradniki --}}
@if (! empty($relatedGuides))
  <section class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">
    <h2 class="font-poppins text-2xl lg:text-3xl leading-tight text-black mb-8 lg:mb-10">
      Zobacz też inne poradniki
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach ($relatedGuides as $guide)
        <x-blog-card
          :title="$guide['title']"
          :excerpt="$guide['excerpt']"
          :date="$guide['date']"
          :url="$guide['url']"
          :image="$guide['image']"
        />
      @endforeach
    </div>
  </section>
@endif
