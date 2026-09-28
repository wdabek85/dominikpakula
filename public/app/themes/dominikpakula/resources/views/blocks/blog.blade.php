@if ($posts)
  <x-section>

    {{-- Nagłówek --}}
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-7 mb-12">
      <x-heading class="lg:max-w-[726px]">
        Styl, inspiracje i porady – zajrzyj do moich <span class="text-[#655098]">najnowszych</span> artykułów.
      </x-heading>

      <p class="font-poppins text-sm leading-4 text-black lg:max-w-[430px]">
        <span class="font-medium">Na blogu dzielę się wiedzą i doświadczeniem ze świata męskiego stylu</span>. Zobacz, co <span class="font-medium">nowego i zainspiruj się</span> do zmian w swoim wizerunku.
      </p>
    </div>

    {{-- Grid z wpisami --}}
    {{-- Od md (tablet w pionie) od razu 3 kolumny — bez pośredniego kroku na 2 --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
      @foreach ($posts as $post)
        <x-blog-card
          :title="$post['title']"
          :excerpt="$post['excerpt']"
          :date="$post['date']"
          :author="$post['author']"
          :authorAvatar="$post['authorAvatar']"
          :authorRole="$post['authorRole']"
          :url="$post['url']"
          :image="$post['image']"
        />
      @endforeach
    </div>

  </x-section>
@endif
