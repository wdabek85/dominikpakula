@props(['href' => '', 'serviceName' => null])

<a
  href="{{ $href ?: home_url('/voucher/') }}"
  {{ $attributes->merge(['class' => 'bg-primary flex items-center gap-2 rounded-lg border-l border-white pr-2 py-4 group no-underline']) }}
  aria-label="Kup voucher na prezent"
>
  {{-- Ikonka gift --}}
  <div class="bg-white flex items-center justify-center rounded-r-sm shrink-0 w-12 h-16 pl-6 overflow-hidden">
    <div class="-rotate-[50deg]">
      <svg class="size-10 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
      </svg>
    </div>
  </div>

  {{-- Treść --}}
  <div class="flex flex-col gap-2 flex-1 min-w-0">
    <p class="font-poppins font-bold text-sm lg:text-base leading-tight text-white">
      Pomysł na prezent (voucher)
    </p>
    <p class="font-poppins text-sm lg:text-base leading-5 text-white">
      To bardzo dobry prezent "z efektem", bo realnie zmienia codzienność: mniej chaosu, więcej pewności, szybsze poranki.
    </p>
    <p class="font-poppins font-medium text-sm lg:text-base leading-tight text-white">
      <span class="underline">Jest osobna strona do zakupu vouchera na {{ $serviceName ?: (get_the_title() ?: 'tę usługę') }}</span>.
    </p>
  </div>

  {{-- Strzałka --}}
  <x-icons.chevron-right class="size-6 text-white shrink-0 group-hover:translate-x-1 transition-transform" />
</a>
