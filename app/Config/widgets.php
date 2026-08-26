<?php

return [
  'widgets' => [
        [
            'name'          => 'Static items',
            'id'            => 'sidebar',
            'before_widget' => '<div id="%1$s" class="pt-20 widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ],
        [
            'name'          => 'Sticky items',
            'id'            => 'sticky-sidebar',
            'before_widget' => '<div id="%1$s" class="sticky top-22 hidden md:block widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>'
        ],
    ]
];
