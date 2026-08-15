<?php

namespace Asylum\Theme\Helper;

class Settings
{
    private static ?Settings $instance = null;

    protected array $settings = [];

    private function __construct()
    {
        $groups = acf_get_field_groups(['options_page' => 'theme-settings']);

        foreach ($groups as $group) {
            $data = [];
            foreach (acf_get_fields($group['key']) as $setting) {
                $data[$setting['name']] = get_field($setting['name'], 'option');
            }
            $this->settings[$group['settings_key'] ?? $group['key']] = $data;
        }
    }

    public static function getInstance(): Settings
    {
        if (self::$instance === null) {
            self::$instance = new Settings();
        }

        return self::$instance;
    }

}
