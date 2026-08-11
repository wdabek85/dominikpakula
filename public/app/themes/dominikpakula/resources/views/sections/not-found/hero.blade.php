{{--
  Hero pustego stanu — używany przez 404 i przez wyszukiwarkę bez wyników.
  Wołający podaje: $heading, $lead oraz opcjonalnie $primaryLabel/$primaryUrl.
--}}
@php
  $heading = $heading ?? 'Tej strony tu nie ma';
  $lead = $lead ?? 'Adres mógł się zmienić albo strona została przeniesiona. Poszukaj tego, po co przyszedłeś, albo zacznij od usług.';
  $primaryLabel = $primaryLabel ?? 'Zobacz usługi';
  $primaryUrl = $primaryUrl ?? home_url('/uslugi/');
  $quickLinks = collect($primaryMenuItems ?? [])
    ->filter(fn ($item) => ! $item->menu_item_parent)
    ->take(5);
@endphp

<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 pt-12 pb-10 lg:pt-20 lg:pb-14">

  <div class="flex flex-col gap-6 max-w-[640px]">

    <h1 class="font-poppins font-semibold text-[32px] md:text-[44px] leading-[1.1] text-[#19121e]">
      {{ $heading }}
    </h1>

    <p class="font-poppins text-base leading-relaxed text-[#19121e]/80">
      {{ $lead }}
    </p>

    <div class="flex flex-col sm:flex-row gap-4 mt-2">
      <x-button
        :label="$primaryLabel"
        :href="$primaryUrl"
        variant="primary"
        size="sm"
        class="w-full sm:w-auto"
      />
      <x-button
        label="Strona główna"
        :href="home_url('/')"
        variant="secondary"
        size="sm"
        class="w-full sm:w-auto"
      />
    </div>

    @if ($quickLinks->isNotEmpty())
      <nav class="flex flex-col gap-3 mt-6" aria-label="Skróty nawigacyjne">
        <p class="font-poppins font-semibold text-base text-[#19121e]">
          Dokąd dalej
        </p>

        <ul class="flex flex-wrap gap-x-6 gap-y-2">
          @foreach ($quickLinks as $item)
            <li>
              <a
                href="{{ $item->url }}"
                class="font-poppins text-base text-[#19121e] underline underline-offset-4 hover:text-primary transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2"
              >
                {{ $item->title }}
              </a>
            </li>
          @endforeach
        </ul>
      </nav>
    @endif

  </div>

</section>
