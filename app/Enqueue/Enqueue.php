<?php

namespace Asylum\Theme\Enqueue;

class Enqueue
{
    private $config;

    /**
     * Webfonts shared by the front end and the editor canvas.
     *
     * Enqueued rather than linked from layouts/default.twig so the block
     * editor iframe resolves the same faces the front end does.
     */
    private const FONTS = 'https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap';

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'styles']);
        add_action('wp_enqueue_scripts', [$this, 'scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin']);
        add_action('after_setup_theme', [$this, 'editor']);

        // Fires for the front end and inside the editor iframe alike.
        add_action('enqueue_block_assets', [$this, 'block']);
        add_filter('wp_resource_hints', [$this, 'resourceHints'], 10, 2);
    }

    public function editor()
    {
        // add_theme_support('editor-styles');
        // add_editor_style('dist/css/editor.css');
    }

    public function block()
    {
        wp_enqueue_style(THEME_SLUG . '-fonts', self::FONTS, [], null);

        if (is_admin()) {
            wp_enqueue_style(THEME_SLUG, THEME_ABS_PATH . '/dist/css/editor.css', [], THEME_VERSION, 'all');

        }
    }

    public function resourceHints($hints, $relation)
    {
        if ($relation === 'preconnect') {
            $hints[] = 'https://fonts.googleapis.com';
            $hints[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin'];
        }

        return $hints;
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
