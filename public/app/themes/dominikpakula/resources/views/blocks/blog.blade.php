<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-8 lg:py-12">

  {{-- Nagłówek --}}
  <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-7 mb-12">
    <h2 class="font-metro text-4xl leading-[44px] text-black lg:max-w-[726px]">
      Wiedza, inspiracje i porady – sprawdź nasze <span class="text-[#655098]">Najnowsze</span> artykuły.
    </h2>

    <p class="font-poppins text-sm leading-4 text-black lg:max-w-[430px]">
      <span class="font-medium">Na naszym blogu dzielimy się wiedzą, doświadczeniem i aktualnościami ze świata technologii</span>. Sprawdź, co <span class="font-medium">nowego i zainspiruj się</span> naszymi rozwiązaniami.
    </p>
  </div>

  {{-- Grid z wpisami --}}
  @if ($posts)
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
  @endif

</section>
