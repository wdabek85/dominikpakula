{{--
  Sekcja ratunkowa pod hero pustego stanu — karty usług, żeby dać userowi
  drogę dalej zamiast ślepego zaułka. Dane z NavigationComposer ($navServices).
--}}
@if (! empty($navServices))
  <section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 pb-14 lg:pb-20">

    <x-heading class="mb-8">Zobacz, w czym mogę pomóc</x-heading>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach (array_slice($navServices, 0, 4) as $service)
        <x-service-card
          variant="detailed"
          category="Usługa"
          :title="$service['title']"
          :link-url="$service['url']"
          link-text="Zobacz usługę"
        />
      @endforeach
    </div>

  </section>
@endif
