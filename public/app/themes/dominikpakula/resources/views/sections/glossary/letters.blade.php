{{-- Siatka liter: 1 kolumna mobile, 2 tablet, 3 desktop. Wiersze grida wyrównują wysokość kafli. --}}
<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 pt-8 pb-16 lg:pt-12 lg:pb-24" aria-label="Hasła słowniczka">
  @if (! empty($groups))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
      @foreach ($groups as $group)
        <x-glossary-letter
          :letter="$group['letter']"
          :id="$group['id']"
          :count="$group['count']"
          :terms="$group['terms']"
        />
      @endforeach
    </div>
  @else
    <p class="font-poppins text-base text-black/60 text-center py-10">
      Wkrótce pojawią się tu pierwsze hasła.
    </p>
  @endif
</section>
