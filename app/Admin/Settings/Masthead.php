<?php

namespace Asylum\Theme\Admin\Settings;

use Asylum\Theme\Admin\Settings;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Masthead
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'register']);
    }

    public function register()
    {
        $themeSettings = new FieldsBuilder('masthead', [
            'layout' => 'seamless',
            'menu_order' => -1,
        ]);

        $themeSettings
            ->addGroup('masthead', [
                'layout' => 'row',
            ])
                ->addGroup('cta_1', [
                    'layout' => 'row',

                ])
                    ->addLink('link', [
                    ])
                    ->addSelect('style', [
                        'choices' => [
                            'primary' => 'Primary',
                            'secondary' => 'Secondary',
                            'tertiary' => 'Tertiary'
                        ]
                    ])
                    ->endGroup()
                ->addGroup('cta_2', [
                    'layout' => 'row',
                ])
                    ->addLink('link', [
                    ])
                    ->addSelect('style', [
                        'choices' => [
                            'primary' => 'Primary',
                            'secondary' => 'Secondary',
                            'tertiary' => 'Tertiary'
                        ]
                    ])
                    ->endGroup()
                ->endGroup()

            ->setLocation('options_page', '==', Settings::PAGE_SLUG);

        acf_add_local_field_group($themeSettings->build());
    }
}
