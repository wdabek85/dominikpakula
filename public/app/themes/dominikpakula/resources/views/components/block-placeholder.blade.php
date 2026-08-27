{{--
  Podgląd pustego bloku w edytorze Gutenberga.

  Bloki mają `mode => 'preview'` (app/blocks.php), więc dopóki pola ACF są puste,
  szablon nie zwraca nic i w edytorze widać pusty obszar — trzeba klikać ołówek,
  żeby w ogóle dostać się do formularza. Ten komponent daje w tym miejscu czytelny
  kafelek z nazwą bloku i podpowiedzią.

  Renderuj TYLKO gdy blok leci z edytora (`$block['preview']`) — nigdy na froncie.

  Slot jest opcjonalny: wrzuć w niego szkielet układu (szare prostokąty),
  żeby edytor od razu widział wybrany layout.

  Uwaga na style: `editor.css` kompiluje własny Tailwind BEZ tokenów z `@theme`
  (app.css), więc `font-poppins` tu nie zadziała — krój i tak dziedziczy się
  z `.editor-styles-wrapper`. Z tego samego powodu tekst idzie w `span`, a nie
  w `p`: reguła `.editor-styles-wrapper p` nadpisałaby rozmiary z klas Tailwind.
--}}
@props([
  'title' => '',
  'hint' => '',
])

<div class="border-2 border-dashed border-black/15 rounded-lg bg-black/[0.02] p-5 lg:p-6">

  @if ($title)
    <span class="block font-semibold text-sm leading-tight text-black/70">
      {{ $title }}
    </span>
  @endif

  @if ($hint)
    <span class="block text-xs leading-relaxed text-black/45 mt-1">
      {{ $hint }}
    </span>
  @endif

  @if (! $slot->isEmpty())
    <div class="mt-4" aria-hidden="true">
      {{ $slot }}
    </div>
  @endif

</div>
