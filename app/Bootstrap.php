<?php

namespace Asylum\Theme;

// new Modules\Modules;
new Enqueue\Enqueue;
new Enqueue\ThirdParty;
new Twig\Twig;
new Editor\ListStyles;

//
new Core\Block;

// Admin
new Admin\Settings;
new Admin\Settings\Cookies;
new Admin\Settings\Tracking;

// add_action('init', function() {
//     dd(Helper\Settings::getInstance());
// }, PHP_INT_MAX);
