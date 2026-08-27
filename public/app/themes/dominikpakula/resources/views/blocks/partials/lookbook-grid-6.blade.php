{{--
  Mozaika 6 zdjęć — duże kadry po przekątnej.

  Lewa kolumna:  item 1 (duże) + para 2-3
  Prawa kolumna: para 4-5 + item 6 (duże)

  Kolumny płyną niezależnie (osobne `flex-col`), więc prawe duże zdjęcie zaczyna się
  wyżej niż kończy lewe. To zamierzone — wiersze celowo NIE są wyrównane.

  Na mobile wszystko schodzi w jedną kolumnę w kolejności: duże → para → para → duże.

  Proporcje: duże `aspect-[2/3]`, małe `aspect-[3/4]` — WSZYSTKIE kadry prostokątne,
  świadoma decyzja usera (2026-08-27), żadnych kwadratów.

  Przy kolumnie treści ~912px kolumna mozaiki ma ~446px, więc:
    duże = 669px, małe = 284px  →  669 + 20 + 284 = ~973px

  To WIĘCEJ niż widoczna wysokość okna MacBooka 14" (~870px), czyli mozaika nie mieści się
  w jednym ekranie i trzeba ją przewinąć. Testowaliśmy dwa niższe warianty (4/5 + kwadrat
  = 790px, kwadrat + 3/4 = 750px) i user wybrał powrót do prostokątów mimo tej wysokości.
  Zanim to zmienisz — zapytaj, to nie jest przeoczenie.

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
    @include('blocks.partials.lookbook-item', ['item' => $leftFeatured, 'aspect' => 'aspect-[2/3]'])

    <div class="grid grid-cols-2 gap-4 lg:gap-5">
      @foreach ($leftPair as $item)
        @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => 'aspect-[3/4]'])
      @endforeach
    </div>
  </div>

  {{-- Prawa kolumna: para na górze, duże pod spodem --}}
  <div class="flex flex-col gap-4 lg:gap-5">
    <div class="grid grid-cols-2 gap-4 lg:gap-5">
      @foreach ($rightPair as $item)
        @include('blocks.partials.lookbook-item', ['item' => $item, 'aspect' => 'aspect-[3/4]'])
      @endforeach
    </div>

    @include('blocks.partials.lookbook-item', ['item' => $rightFeatured, 'aspect' => 'aspect-[2/3]'])
  </div>

</div>
