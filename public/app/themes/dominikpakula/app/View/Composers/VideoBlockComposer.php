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
            'videoYoutubeId' => \get_field('video_youtube_id') ?: '',
            'videoHeading' => \get_field('video_heading') ?: '',
            'videoDescription' => \get_field('video_description') ?: '',
            'videoButtonText' => \get_field('video_button_text') ?: '',
            'videoButtonUrl' => \get_field('video_button_url') ?: '',
            'videoLabel' => \get_field('video_label') ?: 'Obejrzyj Wideo',
        ];
    }
}
