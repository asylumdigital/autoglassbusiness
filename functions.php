<?php

use Timber\Timber;
use Asylum\Update\Theme;

$theme = wp_get_theme();

// load any constants
require_once dirname(__FILE__) . '/app/Config/constants.php';

// Check for composer installation
if (!file_exists(THEME_PATH . '/vendor/autoload.php')) {
    wp_die(__('Please run <code>composer install</code>'));
}

// include vendor
require_once THEME_PATH . '/vendor/autoload.php';

// load the .env as may not have a plugin to do it
if (file_exists(ABSPATH . '.env')) {
    $dotenv = \Dotenv\Dotenv::createImmutable(ABSPATH);
    $dotenv->load();
}

// init updater
// new Theme(get_option(THEME_SLUG . '_updates_key'), get_option('asylum_dev_update', false));

// instansiate Timber
Timber::init();

// Update the Twig views Path
Timber::$locations = [
    THEME_PATH . '/app/Resources/views'
];

// Cache views
add_filter('timber/locations', function($locations) {
    $locations[] = [
        THEME_PATH . '/app/Resources/views'
    ];

    return $locations;
}, 1);


/**
 * The core theme class
 */
new Asylum\Core\Bootstrap;

/**
 * Local Boostrap
 */
require THEME_PATH . '/app/Bootstrap.php';
