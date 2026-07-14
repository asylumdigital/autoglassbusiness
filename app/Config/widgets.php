<?php

return [
  'widgets' => [
    [
        'name'          => esc_html__('CPT Archive Sidebar', 'bm'),
        'id'            => 'sidebar-cpt',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>'
    ],

    [
        'name'          => esc_html__('Post & Page Sidebar', 'bm'),
        'id'            => 'sidebar',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>'
    ],

  ]
];
