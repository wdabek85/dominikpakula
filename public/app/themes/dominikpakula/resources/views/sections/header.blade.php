<header class="bg-white relative z-50">
  <div class="mx-auto max-w-[1440px] flex items-center justify-between px-5 lg:px-20 py-2">

    {{-- Logo --}}
    <a href="{{ home_url('/') }}" class="shrink-0" aria-label="{{ $siteName }} — Strona główna">
      @if (has_custom_logo())
        <img
          src="{{ wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') }}"
          alt="{{ $siteName }}"
          class="h-[29px] w-auto"
        >
      @else
        <span class="font-poppins font-bold text-sm uppercase tracking-wider text-primary">
          {{ $siteName }}
        </span>
      @endif
    </a>

    @include('sections.header.nav-desktop')

    {{-- Desktop Right Side: Social + CTA --}}
    <div class="hidden lg:flex items-center gap-6">
      <div class="flex items-center gap-4">
        <a href="#" aria-label="Facebook" class="text-black hover:text-primary transition-colors">
          <x-icons.facebook />
        </a>
        <a href="https://www.instagram.com/dpakula_stylist/" aria-label="Instagram" class="text-black hover:text-primary transition-colors">
          <x-icons.instagram />
        </a>
        {{-- <a href="#" aria-label="TikTok" class="text-black hover:text-primary transition-colors">
          <x-icons.tiktok />
        </a> --}}
      </div>

      <x-button
        label="Kontakt"
        href="/kontakt"
        size="sm"
        icon="right"
        :iconSvg="'<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\' stroke=\'currentColor\' class=\'size-6\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z\' /></svg>'"
      />
    </div>

    {{-- Mobile Menu Toggle --}}
    <button
      id="mobile-menu-toggle"
      class="lg:hidden text-primary"
      aria-label="Otwórz menu"
      aria-expanded="false"
      aria-controls="mobile-menu"
    >
      <x-icons.menu-icon />
    </button>
  </div>

  @include('sections.header.nav-mobile')
</header>
