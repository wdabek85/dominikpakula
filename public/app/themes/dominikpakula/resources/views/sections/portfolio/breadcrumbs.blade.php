<div class="bg-[#f2f2f2]">
  <nav
    class="mx-auto max-w-[1440px] px-4 lg:px-20 py-3 overflow-x-auto scrollbar-hide"
    aria-label="Breadcrumbs"
    itemscope
    itemtype="https://schema.org/BreadcrumbList"
  >
    <ol class="flex items-center gap-[3px] whitespace-nowrap">
      <li
        class="flex items-center gap-[3px] shrink-0"
        itemprop="itemListElement"
        itemscope
        itemtype="https://schema.org/ListItem"
      >
        <a
          href="{{ home_url('/') }}"
          class="font-poppins text-[10px] text-black"
          itemprop="item"
        >
          <span itemprop="name">Strona główna</span>
        </a>
        <meta itemprop="position" content="1">
        <x-icons.chevron-right class="size-[11px] text-black" />
      </li>

      <li
        class="flex items-center gap-[3px] shrink-0"
        itemprop="itemListElement"
        itemscope
        itemtype="https://schema.org/ListItem"
      >
        <a
          href="{{ home_url('/realizacje/') }}"
          class="font-poppins text-[10px] text-black"
          itemprop="item"
        >
          <span itemprop="name">Realizacje</span>
        </a>
        <meta itemprop="position" content="2">
        <x-icons.chevron-right class="size-[11px] text-black" />
      </li>

      <li
        class="flex items-center shrink-0"
        itemprop="itemListElement"
        itemscope
        itemtype="https://schema.org/ListItem"
      >
        <span class="font-poppins text-[10px] text-black" itemprop="name">
          {{ get_the_title() }}
        </span>
        <meta itemprop="position" content="3">
      </li>
    </ol>
  </nav>
</div>
