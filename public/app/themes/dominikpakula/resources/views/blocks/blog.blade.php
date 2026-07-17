@if ($posts)
  <section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

    {{-- Nagłówek --}}
    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-7 mb-12">
      <h2 class="font-metro text-4xl leading-[44px] text-black lg:max-w-[726px]">
        Styl, inspiracje i porady – zajrzyj do moich <span class="text-[#655098]">najnowszych</span> artykułów.
      </h2>

      <p class="font-poppins text-sm leading-4 text-black lg:max-w-[430px]">
        <span class="font-medium">Na blogu dzielę się wiedzą i doświadczeniem ze świata męskiego stylu</span>. Zobacz, co <span class="font-medium">nowego i zainspiruj się</span> do zmian w swoim wizerunku.
      </p>
    </div>

    {{-- Grid z wpisami --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
      @foreach ($posts as $post)
        <x-blog-card
          :title="$post['title']"
          :excerpt="$post['excerpt']"
          :date="$post['date']"
          :author="$post['author']"
          :url="$post['url']"
          :image="$post['image']"
        />
      @endforeach
    </div>

  </section>
@endif
