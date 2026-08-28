<?php

namespace Asylum\Theme;

// new Modules\Modules;
new Enqueue\Enqueue;
new Enqueue\ThirdParty;
new Twig\Twig;
new Editor\ListStyles;
new Editor\BlockParents;

//
// new Core\ListStyle\Block;
// new Core\ListStyle\Wysiwyg;
new Core\Search;

// Admin
new Admin\Settings;
new Admin\Settings\Masthead;
new Admin\Settings\Cookies;
new Admin\Settings\Tracking;
new Admin\Settings\Media;
new Admin\Blocks;

// add_action('init', function() {
//     dd(Helper\Settings::getInstance());
// }, PHP_INT_MAX);
