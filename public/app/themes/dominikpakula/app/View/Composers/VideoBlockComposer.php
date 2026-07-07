<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class VideoBlockComposer extends Composer
{
    protected static $views = [
        'blocks.video',
    ];

    public function with(): array
    {
        $image = \get_field('video_image');

        return [
            'videoImage' => $image ? $image['url'] : '',
            'videoYoutubeId' => $this->youtubeId(\get_field('video_youtube_id') ?: ''),
            'videoHeading' => \get_field('video_heading') ?: '',
            'videoDescription' => \get_field('video_description') ?: '',
            'videoButtonText' => \get_field('video_button_text') ?: '',
            'videoButtonUrl' => \get_field('video_button_url') ?: '',
            'videoLabel' => \get_field('video_label') ?: 'Obejrzyj Wideo',
        ];
    }

    /**
     * Zwraca ID filmu YouTube. Akceptuje samo ID albo pełny link
     * (watch, youtu.be, embed, shorts). Pusto = brak wideo → tylko zdjęcie.
     */
    protected function youtubeId(string $value): string
    {
        $value = trim($value);

        if ($value === '') {
            return '';
        }

        if (preg_match('~(?:youtu\.be/|youtube\.com/(?:watch\?v=|embed/|shorts/|v/))([A-Za-z0-9_-]{11})~', $value, $m)) {
            return $m[1];
        }

        return $value;
    }
}
