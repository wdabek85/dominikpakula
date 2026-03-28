{{-- Desktop Navigation --}}
@if (has_nav_menu('primary_navigation'))
  <nav class="hidden lg:flex items-center gap-12" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
    @php
      $menuItems = wp_get_nav_menu_items(
        wp_get_nav_menu_object(
          get_nav_menu_locations()['primary_navigation'] ?? 0
        )
      ) ?: [];
      $currentUrl = home_url(add_query_arg([], $GLOBALS['wp']->request ?? ''));
    @endphp

    @foreach ($menuItems as $item)
      @if (!$item->menu_item_parent)
        @php
          $children = array_filter($menuItems, fn($child) => (int) $child->menu_item_parent === $item->ID);
          $isActive = rtrim($item->url, '/') === rtrim($currentUrl, '/');
        @endphp

        @if (count($children) > 0)
          {{-- Dropdown item --}}
          <div class="relative group">
            <button
              class="flex items-center gap-1 font-poppins text-base leading-5 text-black transition-colors hover:text-primary {{ $isActive ? 'underline underline-offset-4' : '' }}"
              aria-expanded="false"
              aria-haspopup="true"
            >
              {{ $item->title }}
              <x-icons.chevron-down class="size-5 transition-transform group-hover:rotate-180" />
            </button>

            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 absolute top-full left-0 pt-2 transition-all duration-200 z-50">
              <div class="bg-white border border-gray-200 rounded shadow-lg py-2 min-w-[200px]">
                @foreach ($children as $child)
                  <a
                    href="{{ $child->url }}"
                    class="block px-4 py-2 font-poppins text-sm text-black hover:bg-gray-50 hover:text-primary transition-colors"
                  >
                    {{ $child->title }}
                  </a>
                @endforeach
              </div>
            </div>
          </div>
        @else
          {{-- Regular item --}}
          <a
            href="{{ $item->url }}"
            class="font-poppins text-base leading-5 text-black transition-colors hover:text-primary {{ $isActive ? 'underline underline-offset-4' : '' }}"
          >
            {{ $item->title }}
          </a>
        @endif
      @endif
    @endforeach
  </nav>
@endif
