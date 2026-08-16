<?php

namespace Asylum\Theme\Admin\Settings;

use Asylum\Theme\Admin\Settings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Media
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);
    }

    public function register()
    {
        $themeSettings = new FieldsBuilder('media', [
            'settings_key' => 'media',
            'layout' => 'seamless'
        ]);

        $themeSettings
            ->addGroup('media', [
                'layout' => 'row',
            ])
                ->addImage('fallback_image', [
                    'return_format' => 'id',
                ])
            ->setLocation('options_page', '==', Settings::PAGE_SLUG);

        acf_add_local_field_group($themeSettings->build());
    }
}
