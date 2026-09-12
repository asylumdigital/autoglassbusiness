<?php

namespace Asylum\Theme\Admin\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class Menu
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'fields']);
    }

    public function fields(): void
    {
        $fields = new FieldsBuilder('social_nav');

        $fields
            ->addImage('icon', [
                'mime_types' => 'svg',
                'library' => 'all',
                'preview_size' => 'thumbnail',
                'return_format' => 'array',
            ])
            ->setLocation('nav_menu_item', '==', 'location/social_nav');

        acf_add_local_field_group($fields->build());
    }
}
