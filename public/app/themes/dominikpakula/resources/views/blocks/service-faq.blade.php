{{-- Na podstronie usługi blok siedzi w kolumnie treści; na zwykłej stronie potrzebuje własnego kontenera --}}
@if ($standalone)
  <x-section>
    @include('blocks.partials.faq-content')
  </x-section>
@else
  <div>
    @include('blocks.partials.faq-content')
  </div>
@endif
