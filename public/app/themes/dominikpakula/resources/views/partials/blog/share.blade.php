{{-- Share block: Skopiuj link jako primary + Messenger/WhatsApp/Facebook/Email (BEZ X i LinkedIn) --}}
<div class="flex flex-col gap-4">

  <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Udostępnij</span>

  <p class="font-poppins text-sm text-black/80 leading-relaxed">
    Ten wpis Ci pomógł? Podrzuć go komuś, komu też może się przydać.
  </p>

  {{-- Primary action — Skopiuj link --}}
  <button
    type="button"
    data-share-copy
    data-share-url="{{ $permalink }}"
    class="inline-flex items-center justify-center gap-2 bg-primary text-white font-poppins font-medium text-sm py-3 px-4 rounded-sm hover:bg-primary/90 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 transition-colors cursor-pointer"
    aria-label="Skopiuj link do wpisu"
  >
    <span data-share-copy-icon class="inline-flex">
      <x-icons.link class="size-4" />
    </span>
    <span data-share-copy-label>Skopiuj link</span>
  </button>

  <span class="font-metro text-[10px] uppercase tracking-[2px] text-black/50 text-center">
    albo wyślij dalej
  </span>

  {{-- Social icons --}}
  <div class="flex items-center justify-center gap-2">
    <a
      href="{{ $shareLinks['messenger'] }}"
      target="_blank"
      rel="noopener"
      class="size-10 rounded-full bg-black/5 flex items-center justify-center text-black/70 hover:bg-primary hover:text-white transition-colors"
      aria-label="Wyślij na Messengerze"
      title="Wyślij na Messengerze"
    >
      <x-icons.messenger class="size-5" />
    </a>
    <a
      href="{{ $shareLinks['whatsapp'] }}"
      target="_blank"
      rel="noopener"
      class="size-10 rounded-full bg-black/5 flex items-center justify-center text-black/70 hover:bg-primary hover:text-white transition-colors"
      aria-label="Wyślij na WhatsApp"
      title="Wyślij na WhatsApp"
    >
      <x-icons.whatsapp class="size-5" />
    </a>
    <a
      href="{{ $shareLinks['facebook'] }}"
      target="_blank"
      rel="noopener"
      class="size-10 rounded-full bg-black/5 flex items-center justify-center text-black/70 hover:bg-primary hover:text-white transition-colors"
      aria-label="Udostępnij na Facebooku"
      title="Udostępnij na Facebooku"
    >
      <x-icons.facebook class="size-5" />
    </a>
    <a
      href="{{ $shareLinks['email'] }}"
      class="size-10 rounded-full bg-black/5 flex items-center justify-center text-black/70 hover:bg-primary hover:text-white transition-colors"
      aria-label="E-mail do przyjaciela"
      title="E-mail do przyjaciela"
    >
      <x-icons.envelope class="size-5" />
    </a>
  </div>

  {{-- Sign-off --}}
  <div class="pt-4 border-t border-black/10">
    <p class="font-poppins italic text-xs text-black/50 text-center leading-relaxed">
      Dzięki, że czytasz.<br>
      @if ($author['name'])
        — {{ $author['name'] }}
      @endif
    </p>
  </div>

</div>
