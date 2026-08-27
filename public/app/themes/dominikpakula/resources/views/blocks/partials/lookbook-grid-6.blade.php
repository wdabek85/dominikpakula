{{--
  Mozaika 6 zdjęć — duże kadry po przekątnej.

  Lewa kolumna:  item 1 (duże) + para 2-3
  Prawa kolumna: para 4-5 + item 6 (duże)

  Kolumny płyną niezależnie (osobne `flex-col`), więc prawe duże zdjęcie zaczyna się
  wyżej niż kończy lewe. To zamierzone — wiersze celowo NIE są wyrównane.

  Na mobile wszystko schodzi w jedną kolumnę w kolejności: duże → para → para → duże.

  Proporcje kadrów (duże 4/5, małe kwadrat) są dobrane tak, żeby kolumna zmieściła się
  w oknie laptopa: przy kolumnie treści ~912px daje to ~791px wysokości. Pierwotne 2/3 + 3/4
  dawało ~973px i wyjeżdżało poza ekran — nie zwiększaj ich bez przeliczenia.

  Zmienne: $items (wymagane min. 6 elementów — pilnuje tego blocks.lookbook-section).
--}}
@php
  $leftFeatured = $items[0];
  $leftPair = array_slice($items, 1, 2);
  $rightPair = array_slice($items, 3, 2);
  $rightFeatured = $items[5];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-5">

  {{-- Lewa kolumna: duże na górze, para pod spodem --}}
  <div class="flex flex-col gap-4 lg:gap-5">
    @include('blocks.partials.lookbook-item', ['item' => $leftFeatured, 'aspect' => 'aspect-[4/5]'])

    <div class="grid grid-cols-2 gap-4 lg:gap-5">
      @foreach ($leftPair as $item)
        @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => 'aspect-square'])
      @endforeach
    </div>
  </div>

  {{-- Prawa kolumna: para na górze, duże pod spodem --}}
  <div class="flex flex-col gap-4 lg:gap-5">
    <div class="grid grid-cols-2 gap-4 lg:gap-5">
      @foreach ($rightPair as $item)
        @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => 'aspect-square'])
      @endforeach
    </div>

    @include('blocks.partials.lookbook-item', ['item' => $rightFeatured, 'aspect' => 'aspect-[4/5]'])
  </div>

</div>
