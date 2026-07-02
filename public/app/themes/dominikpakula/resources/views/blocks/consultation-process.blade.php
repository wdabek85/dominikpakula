<section class="bg-white mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-14">

  {{-- Nagłówek: etykieta + tytuł (lewa) + lead (prawa) --}}
  <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8 lg:mb-12">
    <div class="flex flex-col gap-2 shrink-0">
      @if ($label)
        <span class="font-metro text-2xl leading-none text-[#19121e] tracking-[6px]">
          {{ $label }}
        </span>
      @endif

      @if ($title)
        <h2 class="font-poppins text-[32px] lg:text-[44px] leading-tight text-[#19121e]">
          {{ $title }}
        </h2>
      @endif
    </div>

    @if ($lead)
      <p class="font-poppins text-sm lg:text-base leading-relaxed text-[#2a2a2b] lg:max-w-[440px] lg:text-right">
        {!! $lead !!}
      </p>
    @endif
  </div>

  {{-- Kroki — schodkowy grid na desktop (jak na stronie głównej), kolumna na mobile --}}
  @if ($steps)
    <div class="flex flex-col lg:flex-row gap-6 mb-10 lg:mb-12">
      @foreach ($steps as $index => $step)
        @php $offset = $index * 48; @endphp
        <div class="flex-1" @if($offset > 0) style="--step-offset: {{ $offset }}px" @endif>
          <div class="lg:mt-[var(--step-offset,0px)]">
            @include('blocks.process.step-card', [
              'number' => $step['number'],
              'title' => $step['title'],
              'description' => $step['description'],
            ])
          </div>
        </div>
      @endforeach
    </div>
  @endif

  {{-- CTA + footer --}}
  <div class="flex flex-col items-center gap-3 text-center">
    <x-button
      label="{{ $ctaLabel }}"
      class="booking-trigger"
      data-service="{{ $ctaService }}"
    />

    @if ($footer)
      <p class="font-poppins text-xs leading-relaxed text-[#7b7a7c]">
        {!! $footer !!}
      </p>
    @endif
  </div>

</section>
