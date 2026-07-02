<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

use function App\Blog\polish_plural_count;

class Comments extends Composer
{
    protected static $views = [
        'partials.comments',
    ];

    public function title(): string
    {
        $count = (int) get_comments_number();

        if ($count === 0) {
            return 'Bądź pierwszy — dodaj komentarz';
        }

        return polish_plural_count($count, 'komentarz', 'komentarze', 'komentarzy');
    }

    public function responses(): ?string
    {
        if (! have_comments()) {
            return null;
        }

        return wp_list_comments([
            'style' => 'ol',
            'short_ping' => true,
            'echo' => false,
            'avatar_size' => 48,
            'callback' => __NAMESPACE__ . '\\render_comment',
        ]);
    }

    public function previous(): ?string
    {
        if (! get_previous_comments_link()) {
            return null;
        }

        return get_previous_comments_link('← Starsze komentarze');
    }

    public function next(): ?string
    {
        if (! get_next_comments_link()) {
            return null;
        }

        return get_next_comments_link('Nowsze komentarze →');
    }

    public function paginated(): bool
    {
        return get_comment_pages_count() > 1 && get_option('page_comments');
    }

    public function closed(): bool
    {
        return ! comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments');
    }

    public function formArgs(): array
    {
        $currentUser = wp_get_current_user();
        $displayName = $currentUser && $currentUser->display_name ? $currentUser->display_name : '';
        $logoutUrl = wp_logout_url(get_permalink());
        $profileUrl = admin_url('profile.php');

        $inputClass = 'w-full bg-white border-2 border-black/40 rounded-sm px-4 py-3 font-poppins text-base text-black placeholder:text-black/40 outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors';
        $labelClass = 'font-metro text-xs uppercase tracking-[2px] text-black/70';
        $req = '<span class="text-red-600">*</span>';

        return [
            'title_reply' => 'Dodaj komentarz',
            'title_reply_to' => 'Odpowiedź: %s',
            'cancel_reply_link' => 'anuluj odpowiedź',
            'label_submit' => 'Opublikuj komentarz',
            'class_submit' => 'inline-flex items-center justify-center bg-primary text-white font-poppins font-medium text-base px-8 py-4 rounded-sm hover:bg-primary/90 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-primary focus-visible:ring-offset-2 cursor-pointer border-0',
            'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s →</button>',
            'submit_field' => '<p class="form-submit mt-6">%1$s %2$s</p>',
            'title_reply_before' => '<h3 class="font-serif text-2xl text-black mb-4">',
            'title_reply_after' => '</h3>',
            'must_log_in' => '<p class="font-poppins text-sm text-black/70 mb-4">Musisz być <a href="' . esc_url(wp_login_url(get_permalink())) . '" class="text-primary underline">zalogowany</a>, aby dodać komentarz.</p>',
            'logged_in_as' => '<p class="font-poppins text-sm text-black/70 mb-4">Zalogowany jako <a href="' . esc_url($profileUrl) . '" class="text-primary underline">' . esc_html($displayName) . '</a>. <a href="' . esc_url($logoutUrl) . '" class="text-primary underline">Wyloguj się?</a></p>',
            'comment_notes_before' => '<p class="font-poppins text-xs text-black/50 mb-4">Twój adres e-mail nie zostanie opublikowany. Pola wymagane oznaczone są ' . $req . '.</p>',
            'comment_notes_after' => '',
            'comment_field' => '<p class="flex flex-col gap-2 mb-4"><label for="comment" class="' . $labelClass . '">Komentarz ' . $req . '</label><textarea id="comment" name="comment" cols="45" rows="6" maxlength="65525" required class="' . $inputClass . ' resize-none"></textarea></p>',
            'fields' => [
                'author' => '<p class="flex flex-col gap-2 mb-4"><label for="author" class="' . $labelClass . '">Imię ' . $req . '</label><input id="author" name="author" type="text" required class="' . $inputClass . '"></p>',
                'email' => '<p class="flex flex-col gap-2 mb-4"><label for="email" class="' . $labelClass . '">E-mail ' . $req . '</label><input id="email" name="email" type="email" required class="' . $inputClass . '"></p>',
                'cookies' => '<p class="flex items-start gap-2 mb-2 cursor-pointer"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" class="mt-1 size-4 shrink-0 accent-primary"><label for="wp-comment-cookies-consent" class="font-poppins text-xs text-black/70 leading-relaxed">Zapisz moje dane w tej przeglądarce, bym nie musiał ich wpisywać przy następnym komentarzu.</label></p>',
            ],
            'format' => 'html5',
        ];
    }
}

/**
 * Custom comment renderer — styled Polish comment.
 */
function render_comment($comment, array $args, int $depth): void
{
    $tag = 'div' === $args['style'] ? 'div' : 'li';
    ?>
    <<?php echo $tag; ?> <?php comment_class('flex gap-4 py-6 border-t border-black/10'); ?> id="comment-<?php comment_ID(); ?>">
        <div class="shrink-0">
            <?php echo get_avatar($comment, $args['avatar_size'], '', '', ['class' => 'rounded-full object-cover']); ?>
        </div>
        <div class="flex-1 flex flex-col gap-2 min-w-0">
            <div class="flex flex-wrap items-center gap-3">
                <span class="font-poppins font-semibold text-sm text-black">
                    <?php echo get_comment_author_link($comment); ?>
                </span>
                <span class="font-metro text-[10px] uppercase tracking-[2px] text-black/50">
                    <time datetime="<?php echo esc_attr(get_comment_date('c', $comment)); ?>">
                        <?php echo esc_html(get_comment_date('d.m.Y', $comment)); ?>
                    </time>
                </span>
            </div>

            <?php if ('0' === $comment->comment_approved) : ?>
                <p class="font-poppins italic text-xs text-black/50">Twój komentarz oczekuje na moderację.</p>
            <?php endif; ?>

            <div class="font-poppins text-base leading-relaxed text-black/85">
                <?php comment_text(); ?>
            </div>

            <?php
            comment_reply_link(array_merge($args, [
                'add_below' => 'comment',
                'depth' => $depth,
                'max_depth' => $args['max_depth'] ?? 5,
                'reply_text' => 'Odpowiedz',
            ]));
            ?>
        </div>
    <?php
}

/**
 * Style the comment-reply-link with our tokens.
 */
add_filter('comment_reply_link', function ($link) {
    return str_replace(
        'class="comment-reply-link',
        'class="comment-reply-link inline-flex items-center font-metro text-[10px] uppercase tracking-[2px] text-primary hover:underline mt-1',
        $link
    );
});
