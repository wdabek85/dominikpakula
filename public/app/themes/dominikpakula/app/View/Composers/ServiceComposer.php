<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class ServiceComposer extends Composer
{
    protected static $views = [
        'single-service',
    ];

    public function with(): array
    {
        $image = \get_post_thumbnail_id()
            ? wp_get_attachment_image_url(\get_post_thumbnail_id(), 'large')
            : '';

        $imageAlt = \get_post_thumbnail_id()
            ? get_post_meta(\get_post_thumbnail_id(), '_wp_attachment_image_alt', true)
            : '';

        $sidebarTitle = \get_field('service_sidebar_title') ?: get_the_title();
        $sidebarDescription = \get_field('service_sidebar_description') ?: '';
        $price = \get_field('service_price') ?: '';
        $tags = \get_field('service_tags') ?: [];

        return [
            'image' => $image,
            'imageAlt' => $imageAlt,
            'sidebarTitle' => $sidebarTitle,
            'sidebarDescription' => $sidebarDescription,
            'price' => $price,
            'tags' => $tags,
        ];
    }
}
