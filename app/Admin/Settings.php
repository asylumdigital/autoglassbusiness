<?php

namespace Asylum\Theme\Admin;

class Settings
{
    public const PAGE_SLUG = 'theme-settings';

    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);

        add_action('init', function() {
            remove_action('admin_notices', 'wap_client_maybe_show_https_notice');
        });
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
