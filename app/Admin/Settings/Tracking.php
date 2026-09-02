<?php

namespace Asylum\Theme\Admin\Settings;

use Asylum\Theme\Admin\Settings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Tracking
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);
    }

    public function register()
    {
        $themeSettings = new FieldsBuilder('tracking', [
            'settings_key' => 'tracking',
            'layout' => 'seamless'
        ]);

        $themeSettings
            ->addGroup('tracking', [
                'layout' => 'row',
            ])
                ->addText('gtm', [
                    'label' => 'Tag Manager ID'
                ])
                ->addSelect('gtm_location', [
                    'label' => 'GTM Script location',
                    'choices' => [
                        'head' => 'Head',
                        'footer' => 'Footer',
                    ],
                    'default_value' => 'footer',
                ])
                ->addText('ga', [
                    'label' => 'Google Analytics ID',
                ])
                ->addSelect('ga_location', [
                    'label' => 'GA Script Location',
                    'choices' => [
                        'head' => 'Head',
                        'footer' => 'Footer',
                    ],
                    'default_value' => 'footer',
                ])
                ->endGroup()
            ->setLocation('options_page', '==', Settings::PAGE_SLUG);

        acf_add_local_field_group($themeSettings->build());
    }
}
