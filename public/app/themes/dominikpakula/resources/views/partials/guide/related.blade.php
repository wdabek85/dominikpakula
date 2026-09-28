{{-- Powiązane poradniki --}}
@if (! empty($relatedGuides))
  <x-section>
    <x-heading class="mb-8 lg:mb-10">Zobacz też inne poradniki</x-heading>
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
  </x-section>
@endif
