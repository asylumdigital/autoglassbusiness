<?php

namespace Asylum\Theme\Admin\Settings;

use Asylum\Theme\Admin\Settings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Footer
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);
    }

    public function register()
    {
        $themeSettings = new FieldsBuilder('footer', [
            'settings_key' => 'footer',
            'layout' => 'seamless'
        ]);

        $themeSettings
            ->addGroup('footer', [
                'layout' => 'row',
            ])
                ->addTextarea('footer_details', [
                    'media_upload' => false,
                ])
                ->endGroup()
            ->setLocation('options_page', '==', Settings::PAGE_SLUG);

        acf_add_local_field_group($themeSettings->build());
    }
}
