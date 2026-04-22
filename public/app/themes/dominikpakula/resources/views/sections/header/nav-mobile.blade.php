{{-- Mobile Menu Drawer --}}
<div
  id="mobile-menu"
  class="fixed inset-0 z-50 bg-black/50 translate-x-full transition-transform duration-300 lg:hidden"
>
  <div class="absolute right-0 top-0 h-full w-full bg-white shadow-xl overflow-hidden">

    {{-- Panel wrapper: 4 panels side by side --}}
    <div id="mobile-panels" class="flex h-full transition-transform duration-300" style="width: 400%;">

      {{-- Panel 1: Menu główne --}}
      <div class="w-1/4 h-full flex flex-col">
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-2 shrink-0">
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

        {{-- Nav Links --}}
        @if (has_nav_menu('primary_navigation'))
          @php
            $menuItems = $menuItems ?? wp_get_nav_menu_items(
              wp_get_nav_menu_object(
                get_nav_menu_locations()['primary_navigation'] ?? 0
              )
            ) ?: [];
          @endphp

          <nav class="px-5 py-6 flex-1 overflow-y-auto" aria-label="Menu mobilne">
            <ul class="space-y-4">
              @foreach ($menuItems as $item)
                @if (!$item->menu_item_parent)
                  @php
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

                  <li>
                    @if ($isServicesItem && count($navServices) > 0)
                      <button
                        class="flex items-center justify-between w-full font-poppins text-base text-black hover:text-primary transition-colors"
                        data-mobile-go="services"
                      >
                        <span>{{ $item->title }}</span>
                        <x-icons.chevron-right class="size-5 text-gray-400" />
                      </button>
                    @elseif ($isKnowledgeItem)
                      <button
                        class="flex items-center justify-between w-full font-poppins text-base text-black hover:text-primary transition-colors"
                        data-mobile-go="knowledge"
                      >
                        <span>{{ $item->title }}</span>
                        <x-icons.chevron-right class="size-5 text-gray-400" />
                      </button>
                    @else
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
                    @endif
                  </li>
                @endif
              @endforeach
            </ul>
          </nav>
        @endif

        {{-- Social + CTA --}}
        <div class="px-5 py-6 border-t border-gray-200 shrink-0">
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

      {{-- Panel 2: Lista usług --}}
      <div class="w-1/4 h-full flex flex-col">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 shrink-0">
          <button
            class="flex items-center gap-2 font-poppins text-sm text-primary"
            aria-label="Wróć do menu"
            data-mobile-back="main"
          >
            <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <span>Wstecz</span>
          </button>
        </div>

        <div class="px-5 py-4 shrink-0">
          <h3 class="font-poppins font-semibold text-lg text-black">Usługi</h3>
        </div>

        <div class="flex-1 overflow-y-auto px-5 pb-6">
          <ul class="flex flex-col">
            @if (!empty($navServices))
              @foreach ($navServices as $index => $service)
                <li>
                  <button
                    class="flex items-center justify-between w-full py-3 border-b border-gray-100 font-poppins text-base text-black hover:text-primary transition-colors"
                    data-mobile-go="detail"
                    data-service-index="{{ $index }}"
                  >
                    <span>{{ $service['title'] }}</span>
                    <x-icons.chevron-right class="size-5 text-gray-400" />
                  </button>
                </li>
              @endforeach
            @endif
          </ul>

          <a
            href="{{ home_url('/uslugi/') }}"
            class="inline-flex items-center gap-2 font-poppins text-sm font-medium text-primary hover:underline mt-6"
          >
            Zobacz wszystkie usługi
            <x-icons.arrow-right class="size-4" />
          </a>
        </div>
      </div>

      {{-- Panel 3: Szczegóły usługi --}}
      <div class="w-1/4 h-full flex flex-col">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 shrink-0">
          <button
            class="flex items-center gap-2 font-poppins text-sm text-primary"
            aria-label="Wróć do listy usług"
            data-mobile-back="services"
          >
            <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <span>Wstecz</span>
          </button>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-6">
          @if (!empty($navServices))
            @foreach ($navServices as $index => $service)
              <div
                class="hidden flex-col gap-4"
                data-mobile-detail="{{ $index }}"
              >
                @if ($service['image'])
                  <div class="w-full h-[200px] rounded-lg overflow-hidden">
                    <img
                      src="{{ $service['image'] }}"
                      alt=""
                      class="size-full object-cover object-top"
                      loading="lazy"
                    >
                  </div>
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
                  class="inline-flex items-center justify-center gap-2 bg-primary text-white font-poppins text-sm rounded-sm px-4 py-3 hover:opacity-90 transition-opacity w-full"
                >
                  Dowiedz się więcej
                  <x-icons.arrow-right class="size-4" />
                </a>
              </div>
            @endforeach
          @endif
        </div>
      </div>

      {{-- Panel 4: Baza Wiedzy (Blog + Poradniki) --}}
      <div class="w-1/4 h-full flex flex-col">
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100 shrink-0">
          <button
            class="flex items-center gap-2 font-poppins text-sm text-primary"
            aria-label="Wróć do menu"
            data-mobile-back="main"
          >
            <svg class="size-5 rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <span>Wstecz</span>
          </button>
        </div>

        <div class="px-5 py-4 shrink-0 flex items-center justify-between">
          <h3 class="font-poppins font-semibold text-lg text-black">Baza Wiedzy</h3>
          <a href="{{ home_url('/baza-wiedzy/') }}" class="font-poppins text-xs font-medium text-primary">
            Zobacz całość →
          </a>
        </div>

        <div class="flex-1 overflow-y-auto px-5 pb-6">

          {{-- Blog --}}
          @if (!empty($navBlog))
            <div class="mb-8">
              <div class="flex items-center justify-between mb-4">
                <h3 class="font-poppins font-semibold text-lg text-black">Blog</h3>
                <a href="{{ home_url('/blog/') }}" class="font-poppins text-xs font-medium text-primary">
                  Wszystkie →
                </a>
              </div>

              <div class="flex flex-col gap-3">
                @foreach ($navBlog as $post)
                  <a href="{{ $post['url'] }}" class="flex gap-3 group">
                    @if ($post['image'])
                      <div class="w-[80px] h-[56px] rounded overflow-hidden shrink-0">
                        <img src="{{ $post['image'] }}" alt="" class="size-full object-cover" width="80" height="56" loading="lazy">
                      </div>
                    @else
                      <div class="w-[80px] h-[56px] rounded bg-gray-100 shrink-0" aria-hidden="true"></div>
                    @endif
                    <div class="flex flex-col gap-0.5 min-w-0">
                      <span class="font-poppins text-sm text-black group-hover:text-primary transition-colors leading-snug">
                        {{ $post['title'] }}
                      </span>
                      @if (!empty($post['excerpt']))
                        <p class="font-poppins text-xs text-gray-500 leading-snug line-clamp-2">
                          {{ $post['excerpt'] }}
                        </p>
                      @endif
                    </div>
                  </a>
                @endforeach
              </div>
            </div>
          @endif

          {{-- Poradniki --}}
          @if (!empty($navGuides))
            <div>
              <div class="flex items-center justify-between mb-4">
                <h3 class="font-poppins font-semibold text-lg text-black">Poradniki</h3>
                <a href="{{ home_url('/poradniki/') }}" class="font-poppins text-xs font-medium text-primary">
                  Wszystkie →
                </a>
              </div>

              <div class="flex flex-col gap-3">
                @foreach ($navGuides as $guide)
                  <a href="{{ $guide['url'] }}" class="flex gap-3 group">
                    @if ($guide['image'])
                      <div class="w-[80px] h-[56px] rounded overflow-hidden shrink-0">
                        <img src="{{ $guide['image'] }}" alt="" class="size-full object-cover" width="80" height="56" loading="lazy">
                      </div>
                    @else
                      <div class="w-[80px] h-[56px] rounded bg-gray-100 shrink-0" aria-hidden="true"></div>
                    @endif
                    <div class="flex flex-col gap-0.5 min-w-0">
                      <span class="font-poppins text-sm text-black group-hover:text-primary transition-colors leading-snug">
                        {{ $guide['title'] }}
                      </span>
                      @if (!empty($guide['excerpt']))
                        <p class="font-poppins text-xs text-gray-500 leading-snug line-clamp-2">
                          {{ $guide['excerpt'] }}
                        </p>
                      @endif
                    </div>
                  </a>
                @endforeach
              </div>
            </div>
          @endif

        </div>
      </div>

    </div>
  </div>
</div>
