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
          $isKnowledgeItem = (!empty($navBlog) || !empty($navGuides)) && (
            str_contains(strtolower($item->title), 'baza') ||
            str_contains(strtolower($item->title), 'wiedz') ||
            str_contains(strtolower($item->title), 'blog')
          );
        @endphp

        @if ($isKnowledgeItem)
          {{-- Knowledge base mega-menu trigger --}}
          <div data-mega-trigger-kb>
            <a
              href="{{ $item->url }}"
              class="flex items-center gap-1 font-poppins text-base leading-5 text-black transition-colors hover:text-primary {{ $isActive ? 'underline underline-offset-4' : '' }}"
              aria-haspopup="true"
            >
              {{ $item->title }}
              <x-icons.chevron-down class="size-5 transition-transform duration-200" data-mega-chevron-kb />
            </a>
          </div>

        @elseif ($isServicesItem && count($navServices) > 0)
          {{-- Mega-menu trigger --}}
          <div data-mega-trigger>
            <a
              href="{{ $item->url }}"
              class="flex items-center gap-1 font-poppins text-base leading-5 text-black transition-colors hover:text-primary {{ $isActive ? 'underline underline-offset-4' : '' }}"
              aria-haspopup="true"
            >
              {{ $item->title }}
              <x-icons.chevron-down class="size-5 transition-transform duration-200" data-mega-chevron />
            </a>
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

{{-- Full-width mega-menu panel --}}
@if (!empty($navServices))
  <div
    id="mega-menu-panel"
    class="absolute left-0 right-0 top-full bg-white shadow-xl border-t border-gray-100 z-40 overflow-hidden transition-all duration-300 max-h-0 opacity-0"
  >
    <div class="mx-auto max-w-[1440px] px-20 py-10">
      <div class="flex gap-12" data-mega-content>

        {{-- Lewa: lista usług --}}
        <div class="w-[280px] shrink-0 flex flex-col">
          <p class="font-poppins font-semibold text-xs text-gray-400 uppercase tracking-wider mb-4">Usługi</p>
          <ul class="flex flex-col">
            @foreach ($navServices as $index => $service)
              <li>
                <a
                  href="{{ $service['url'] }}"
                  class="flex items-center justify-between py-3 border-b border-gray-100 font-poppins text-base text-black transition-colors hover:text-primary data-[active]:text-primary data-[active]:font-semibold"
                  data-mega-item="{{ $index }}"
                >
                  <span>{{ $service['title'] }}</span>
                  <x-icons.arrow-right class="size-4 opacity-0 transition-opacity" data-mega-arrow />
                </a>
              </li>
            @endforeach
          </ul>

          <a
            href="{{ home_url('/uslugi/') }}"
            class="inline-flex items-center gap-2 font-poppins text-sm font-medium text-primary hover:underline mt-6"
          >
            Wszystkie usługi
            <x-icons.arrow-right class="size-4" />
          </a>
        </div>

        {{-- Prawa: szczegóły aktywnej usługi --}}
        <div class="flex-1 min-w-0">
          @foreach ($navServices as $index => $service)
            <div
              class="hidden flex-col gap-4 {{ $index === 0 ? '!flex' : '' }}"
              data-mega-detail="{{ $index }}"
            >
              @if ($service['image'])
                <div class="w-full h-[240px] rounded-lg overflow-hidden">
                  <img
                    src="{{ $service['image'] }}"
                    alt=""
                    class="size-full object-cover object-top"
                    width="600"
                    height="240"
                    loading="lazy"
                  >
                </div>
              @else
                <div class="w-full h-[240px] rounded-lg bg-gray-100"></div>
              @endif

              <h3 class="font-poppins font-semibold text-xl text-black">
                {{ $service['title'] }}
              </h3>

              @if ($service['description'])
                <p class="font-poppins text-sm text-gray-600 leading-relaxed">
                  {{ $service['description'] }}
                </p>
              @endif

              <a
                href="{{ $service['url'] }}"
                class="inline-flex items-center gap-2 font-poppins text-sm font-medium text-primary hover:underline w-fit"
              >
                Dowiedz się więcej
                <x-icons.arrow-right class="size-4" />
              </a>
            </div>
          @endforeach
        </div>

      </div>
    </div>
  </div>
@endif

{{-- Full-width mega-menu panel: Baza Wiedzy --}}
@if (!empty($navBlog) || !empty($navGuides))
  <div
    id="mega-menu-kb-panel"
    class="absolute left-0 right-0 top-full bg-white shadow-xl border-t border-gray-100 z-40 overflow-hidden transition-all duration-300 max-h-0 opacity-0"
  >
    <div class="mx-auto max-w-[1440px] px-20 py-10">
      <div class="flex gap-12">

        {{-- Blog --}}
        @if (!empty($navBlog))
          <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
              <p class="font-poppins font-semibold text-xs text-gray-400 uppercase tracking-wider">Blog</p>
              <a href="{{ home_url('/blog/') }}" class="font-poppins text-sm font-medium text-primary hover:underline">
                Wszystkie wpisy →
              </a>
            </div>

            <div class="flex flex-col gap-0">
              @foreach ($navBlog as $post)
                <a href="{{ $post['url'] }}" class="flex gap-4 px-3 py-1 rounded-[2px] hover:bg-gray-50 transition-colors group/card">
                  @if ($post['image'])
                    <div class="w-[120px] h-[80px] rounded-[2px] overflow-hidden shrink-0">
                      <img src="{{ $post['image'] }}" alt="" class="size-full object-cover" width="120" height="80" loading="lazy">
                    </div>
                  @else
                    <div class="w-[120px] h-[80px] rounded-[2px] bg-gray-100 shrink-0"></div>
                  @endif
                  <span class="font-poppins font-medium text-sm text-black group-hover/card:text-primary transition-colors leading-snug">
                    {{ $post['title'] }}
                  </span>
                </a>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Separator --}}
        <div class="w-px bg-gray-100"></div>

        {{-- Poradniki --}}
        @if (!empty($navGuides))
          <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
              <p class="font-poppins font-semibold text-xs text-gray-400 uppercase tracking-wider">Poradniki</p>
              <a href="{{ home_url('/poradniki/') }}" class="font-poppins text-sm font-medium text-primary hover:underline">
                Wszystkie poradniki →
              </a>
            </div>

            <div class="flex flex-col gap-0">
              @foreach ($navGuides as $guide)
                <a href="{{ $guide['url'] }}" class="flex gap-4 px-3 py-1 rounded-[2px] hover:bg-gray-50 transition-colors group/card">
                  @if ($guide['image'])
                    <div class="w-[120px] h-[80px] rounded-[2px] overflow-hidden shrink-0">
                      <img src="{{ $guide['image'] }}" alt="" class="size-full object-cover" width="120" height="80" loading="lazy">
                    </div>
                  @else
                    <div class="w-[120px] h-[80px] rounded-[2px] bg-gray-100 shrink-0"></div>
                  @endif
                  <span class="font-poppins font-medium text-sm text-black group-hover/card:text-primary transition-colors leading-snug">
                    {{ $guide['title'] }}
                  </span>
                </a>
              @endforeach
            </div>
          </div>
        @endif

      </div>
    </div>
  </div>
@endif
