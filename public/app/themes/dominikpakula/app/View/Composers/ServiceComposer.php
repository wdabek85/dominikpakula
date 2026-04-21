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
        $thumbId = \get_post_thumbnail_id();
        $image = $thumbId ? (wp_get_attachment_image_url($thumbId, 'large') ?: '') : '';
        $imageAlt = $thumbId ? (get_post_meta($thumbId, '_wp_attachment_image_alt', true) ?: '') : '';

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
