<?php

/*
 * Style options for <ul> elements.
 *
 * Shared by the core/list block control and the ACF WYSIWYG toolbar
 * control. Both apply the class as `list--{slug}`, so a single CSS
 * rule set covers lists written in either editor.
 *
 * Add an entry here and it appears in both editors — the only other
 * change needed is the matching CSS.
 */

return [
    'styles' => [
        [
            'slug' => 'ticks',
            'label' => 'Ticks',
        ],
        // [
        //     'slug' => 'arrows',
        //     'label' => 'Arrows',
        // ],
        // [
        //     'slug' => 'columns',
        //     'label' => 'Columns',
        // ],
    ],
];
