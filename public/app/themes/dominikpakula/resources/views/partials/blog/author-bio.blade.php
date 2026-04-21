{{-- Author bio --}}
<section class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">
  <div class="flex flex-col sm:flex-row gap-6 items-start">

    @if ($author['avatar'])
      <img
        src="{{ $author['avatar'] }}"
        alt=""
        class="size-20 lg:size-24 rounded-full object-cover shrink-0"
        loading="lazy"
        width="96"
        height="96"
      >
    @endif

    <div class="flex flex-col gap-3 flex-1">
      <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Autor</span>

      <h2 class="font-serif text-2xl lg:text-3xl text-black">
        @if ($author['url'])
          <a href="{{ $author['url'] }}" class="hover:text-primary transition-colors">{{ $author['name'] }}</a>
        @else
          {{ $author['name'] }}
        @endif
      </h2>

      @if ($author['bio'])
        <p class="font-poppins text-base text-black/80 leading-relaxed max-w-[640px]">
          {{ $author['bio'] }}
        </p>
      @else
        <p class="font-poppins italic text-sm text-black/50">
          Brak opisu autora — dodaj go w profilu użytkownika.
        </p>
      @endif

      @if ($author['url'])
        <a
          href="{{ $author['url'] }}"
          class="inline-flex items-center gap-2 font-poppins text-sm font-medium text-primary hover:underline w-fit mt-2"
        >
          Zobacz wszystkie wpisy
          <x-icons.arrow-right class="size-4" />
        </a>
      @endif
    </div>

  </div>
</section>
