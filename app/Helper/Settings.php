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
                $this->settings[$setting['name']] = get_field($setting['name'], 'option');
            }

            // $this->settings[$group['settings_key'] ?? $group['key']] = $data;
        }
    }

    public static function getInstance(): Settings
    {
        if (self::$instance === null) {
            self::$instance = new Settings();
        }

        return self::$instance;
    }

    public function getGroup(string $key): array
    {
        return $this->settings[$key] ?? [];
    }

    public function getAll(): array
    {
        return $this->settings;
    }

}
