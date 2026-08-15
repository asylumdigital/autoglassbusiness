<?php

namespace Asylum\Theme\Admin;

class Settings
{
    public const PAGE_SLUG = 'theme-settings';

    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);
    }

    public function register()
    {
        if (function_exists('acf_add_options_sub_page')) {
            acf_add_options_sub_page([
                'page_title'    => 'Theme Settings',
                'menu_title'    => 'Theme',
                'parent_slug'   => 'options-general.php',
                'menu_slug' => self::PAGE_SLUG,
            ]);
        }

    }
}
