{{-- Linkowanie wewnętrzne na końcu treści usługi: „Zobacz też” (miasta) / „Inne usługi” (usługi główne) --}}
@if (! empty($relatedLinks))
  <section aria-labelledby="related-services-heading" class="not-prose">
    <x-heading variant="column" id="related-services-heading" class="mb-6">{{ $relatedHeading }}</x-heading>
    <x-link-list :items="$relatedLinks" />
  </section>
@endif
