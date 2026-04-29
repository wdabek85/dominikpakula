@php
  // Konfiguracja per typ — wszystko monochrom + delikatny accent border
  $config = match ($type) {
    'info' => [
      'borderColor' => 'border-l-blue-600/70',
      'iconBg' => 'bg-blue-600/10 text-blue-700',
      'icon' => 'info',
    ],
    'warning' => [
      'borderColor' => 'border-l-amber-600/70',
      'iconBg' => 'bg-amber-600/10 text-amber-700',
      'icon' => 'warning',
    ],
    default => [ // tip
      'borderColor' => 'border-l-primary',
      'iconBg' => 'bg-primary/10 text-primary',
      'icon' => 'lightbulb',
    ],
  };
@endphp

<aside class="not-prose my-8 lg:my-10 max-w-[820px] mx-auto bg-[#f1f1f1] border-l-4 {{ $config['borderColor'] }} rounded-r p-5 lg:p-6 flex gap-4">

  {{-- Ikona w kółku --}}
  <div class="size-10 shrink-0 rounded-full {{ $config['iconBg'] }} flex items-center justify-center" aria-hidden="true">
    @if ($config['icon'] === 'lightbulb')
      <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
      </svg>
    @elseif ($config['icon'] === 'info')
      <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
      </svg>
    @else
      {{-- warning --}}
      <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
      </svg>
    @endif
  </div>

  {{-- Treść --}}
  <div class="flex flex-col gap-1 flex-1">
    @if ($title)
      <p class="font-poppins font-semibold text-base text-black">
        {{ $title }}
      </p>
    @endif
    @if ($text)
      <p class="font-poppins text-sm lg:text-base leading-relaxed text-black/80">
        {{ $text }}
      </p>
    @endif
  </div>

</aside>
