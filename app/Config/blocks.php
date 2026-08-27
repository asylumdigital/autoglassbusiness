<?php

return [
    // 'widgets' => [
    //     'acf/widget-lead-gen',
    // ]
    'widgets' => get_field('allowed_widget_block', 'option') ?: [],
    'page' => get_field('allowed_page_block', 'option') ?: [],
    'post' => get_field('allowed_post_block', 'option') ?: [],
    'groups' => [
        [
            'slug' => 'asylum-hero',
            'title' => 'Hero',
            'icon' => null,
        ],
        [
            'slug' => 'asylum-carousel',
            'title' => 'Carousel',
            'icon' => null,
        ],
        [
            'slug' => 'asylum-content',
            'title' => 'Content',
            'icon' => null,
        ],
        [
            'slug' => 'asylum-callout',
            'title' => 'Callout / CTA',
            'icon' => null,
        ],
        [
            'slug' => 'asylum-media',
            'title' => 'Media',
            'icon' => null,
        ],
        [
            'slug' => 'asylum-form',
            'title' => 'Forms',
            'icon' => null,
        ],
    ]
];
