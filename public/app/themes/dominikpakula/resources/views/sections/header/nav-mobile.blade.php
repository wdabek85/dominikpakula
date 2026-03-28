{{-- Mobile Menu Drawer --}}
<div
  id="mobile-menu"
  class="fixed inset-0 z-50 bg-black/50 translate-x-full transition-transform duration-300 lg:hidden"
>
  <div class="absolute right-0 top-0 h-full w-full bg-white shadow-xl">
    {{-- Close --}}
    <div class="flex items-center justify-between px-5 py-2">
      <a href="{{ home_url('/') }}" aria-label="{{ $siteName }}">
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
      <button id="mobile-menu-close" class="text-primary" aria-label="Zamknij menu">
        <x-icons.x-mark />
      </button>
    </div>

    {{-- Mobile Nav Links --}}
    @if (has_nav_menu('primary_navigation'))
      @php
        $menuItems = $menuItems ?? wp_get_nav_menu_items(
          wp_get_nav_menu_object(
            get_nav_menu_locations()['primary_navigation'] ?? 0
          )
        ) ?: [];
      @endphp

      <nav class="px-5 py-6" aria-label="Menu mobilne">
        <ul class="space-y-4">
          @foreach ($menuItems as $item)
            @if (!$item->menu_item_parent)
              <li>
                <a
                  href="{{ $item->url }}"
                  class="block font-poppins text-base text-black hover:text-primary transition-colors"
                >
                  {{ $item->title }}
                </a>

                @php
                  $children = array_filter($menuItems, fn($child) => (int) $child->menu_item_parent === $item->ID);
                @endphp

                @if (count($children) > 0)
                  <ul class="mt-2 ml-4 space-y-2">
                    @foreach ($children as $child)
                      <li>
                        <a
                          href="{{ $child->url }}"
                          class="block font-poppins text-sm text-gray-600 hover:text-primary transition-colors"
                        >
                          {{ $child->title }}
                        </a>
                      </li>
                    @endforeach
                  </ul>
                @endif
              </li>
            @endif
          @endforeach
        </ul>
      </nav>
    @endif

    {{-- Mobile Social + CTA --}}
    <div class="px-5 py-6 border-t border-gray-200 mt-auto">
      <x-button
        label="Kontakt"
        href="/kontakt"
        size="sm"
        icon="right"
        class="w-full"
        :iconSvg="'<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke-width=\'1.5\' stroke=\'currentColor\' class=\'size-6\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z\' /></svg>'"
      />

      <div class="flex items-center justify-center gap-6 mt-6">
        <a href="#" aria-label="Facebook" class="text-black hover:text-primary transition-colors">
          <x-icons.facebook />
        </a>
        <a href="#" aria-label="Instagram" class="text-black hover:text-primary transition-colors">
          <x-icons.instagram />
        </a>
        <a href="#" aria-label="TikTok" class="text-black hover:text-primary transition-colors">
          <x-icons.tiktok />
        </a>
      </div>
    </div>
  </div>
</div>
