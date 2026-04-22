@if (! post_password_required())
  <section id="comments" class="mx-auto max-w-[1440px] px-4 lg:px-20 py-10 lg:py-16">

    {{-- Section header --}}
    <div class="flex flex-col gap-2 mb-8">
      <span class="font-metro text-xs uppercase tracking-[3px] text-black/60">Dyskusja</span>
      <h2 class="font-serif text-3xl lg:text-4xl text-black">{{ $title }}</h2>
    </div>

    {{-- Comments list --}}
    @if ($responses())
      <ol class="comment-list flex flex-col mb-10">
        {!! $responses !!}
      </ol>

      @if ($paginated())
        <nav class="flex items-center justify-between gap-4 mt-8 pt-6 border-t border-black/10" aria-label="Nawigacja po komentarzach">
          <div>
            @if ($previous())
              {!! $previous !!}
            @endif
          </div>
          <div>
            @if ($next())
              {!! $next !!}
            @endif
          </div>
        </nav>
      @endif
    @endif

    @if ($closed())
      <p class="font-poppins italic text-black/60 bg-[#f1f1f1] rounded-sm p-4">
        Komentarze do tego wpisu zostały zamknięte.
      </p>
    @endif

    {{-- Comment form --}}
    <div class="mt-10">
      <?php comment_form($formArgs); ?>
    </div>

  </section>
@endif
