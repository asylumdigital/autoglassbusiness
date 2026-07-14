<?php

namespace Asylum\Theme\Enqueue;

class Enqueue
{
    private $config;

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin']);
    }

    public function styles()
    {
        wp_enqueue_style(THEME_SLUG, THEME_ABS_PATH . '/dist/css/app.css', [], THEME_VERSION, 'all');
    }

    public function scripts()
    {
        wp_enqueue_script(THEME_SLUG, THEME_ABS_PATH . '/dist/js/main.js', [], THEME_VERSION, true);
    }

    public function admin()
    {
        wp_enqueue_style(THEME_SLUG . '-admin', THEME_ABS_PATH . '/dist/css/admin.css', [], THEME_VERSION);
    }
}
