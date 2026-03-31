<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class VoucherBlockComposer extends Composer
{
    protected static $views = [
        'blocks.voucher',
    ];

    public function with(): array
    {
        $leftImage = \get_field('voucher_image_left');
        $rightImage = \get_field('voucher_image_right');

        return [
            'title' => \get_field('voucher_title') ?: '',
            'description' => \get_field('voucher_description') ?: '',
            'buttonText' => \get_field('voucher_button_text') ?: '',
            'buttonUrl' => \get_field('voucher_button_url') ?: '#',
            'imageLeft' => $leftImage ? $leftImage['url'] : '',
            'imageLeftAlt' => $leftImage ? ($leftImage['alt'] ?: 'Voucher') : '',
            'imageRight' => $rightImage ? $rightImage['url'] : '',
            'imageRightAlt' => $rightImage ? ($rightImage['alt'] ?: 'Voucher prezentowy') : '',
        ];
    }
}
