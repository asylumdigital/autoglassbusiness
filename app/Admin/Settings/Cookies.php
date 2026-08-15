<?php

namespace Asylum\Theme\Admin\Settings;

use Asylum\Theme\Admin\Settings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Cookies
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);
    }

    public function register()
    {
        $themeSettings = new FieldsBuilder('cookies', [
            'layout' => 'seamless'
        ]);

        $themeSettings
            ->addGroup('cookie_banner', [
                'layout' => 'row',
            ])
                ->addText('api_key')
                ->endGroup()
            ->setLocation('options_page', '==', Settings::PAGE_SLUG);

        acf_add_local_field_group($themeSettings->build());
    }
}
