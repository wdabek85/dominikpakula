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
          $isServicesItem = !empty($navServices) && (
            str_contains(strtolower($item->title), 'usług') ||
            str_contains(strtolower($item->title), 'oferta')
          );
        @endphp

        @if ($isServicesItem && count($navServices) > 0)
          {{-- Mega-menu for Services --}}
          <div class="relative group" data-mega-menu>
            <button
              class="flex items-center gap-1 font-poppins text-base leading-5 text-black transition-colors hover:text-primary {{ $isActive ? 'underline underline-offset-4' : '' }}"
              aria-expanded="false"
              aria-haspopup="true"
            >
              {{ $item->title }}
              <x-icons.chevron-down class="size-5 transition-transform duration-200 group-hover:rotate-180" />
            </button>

            {{-- Mega dropdown --}}
            <div class="invisible opacity-0 group-hover:visible group-hover:opacity-100 absolute top-full -left-20 pt-4 transition-all duration-200 z-50">
              <div class="bg-white border border-gray-200 rounded-lg shadow-xl p-6 w-[700px]">
                <div class="grid grid-cols-2 gap-4">
                  @foreach ($navServices as $service)
                    <a
                      href="{{ $service['url'] }}"
                      class="flex gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors group/card"
                    >
                      @if ($service['image'])
                        <img
                          src="{{ $service['image'] }}"
                          alt=""
                          class="size-16 rounded object-cover shrink-0"
                          width="64"
                          height="64"
                          loading="lazy"
                        >
                      @else
                        <div class="size-16 rounded bg-gray-100 shrink-0"></div>
                      @endif

                      <div class="flex flex-col gap-1 min-w-0">
                        <span class="font-poppins font-semibold text-sm text-black group-hover/card:text-primary transition-colors">
                          {{ $service['title'] }}
                        </span>
                        @if ($service['description'])
                          <span class="font-poppins text-xs text-gray-500 leading-normal line-clamp-2">
                            {{ $service['description'] }}
                          </span>
                        @endif
                      </div>
                    </a>
                  @endforeach
                </div>

                {{-- Link do wszystkich usług --}}
                <div class="border-t border-gray-100 mt-4 pt-4">
                  <a
                    href="{{ $item->url }}"
                    class="inline-flex items-center gap-2 font-poppins text-sm font-medium text-primary hover:underline"
                  >
                    Zobacz wszystkie usługi
                    <x-icons.arrow-right class="size-4" />
                  </a>
                </div>
              </div>
            </div>
          </div>

        @elseif (count($children) > 0)
          {{-- Regular dropdown item --}}
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
