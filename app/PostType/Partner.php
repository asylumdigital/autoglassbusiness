<?php

namespace Asylum\Theme\PostType;

use Asylum\Config\Core\PostType;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Partner
{
    public function __construct()
    {
        add_action('acf/init', [$this, 'fields']);
        add_action('init', [$this, 'register']);
    }

    /**
     * Register post type
     *
     * @return void
     */
    public function register()
    {
        (new PostType('Partner carousel'))
            ->setPublic(false)
            ->setShowInRest(false)
            ->setSupports(['title'])
            ->setPubliclyQueryable(false)
            ->setIcon('dashicons-image-flip-horizontal')
            ->setMenuPosition(55)
            ->register();
    }

    /**
     * Register ACF fields
     *
     * @return void
     */
    public function fields(): void
    {
        $fields = new FieldsBuilder('partner_carousel');

        $fields
            ->addRepeater('partners')
                ->addText('partner_name')
                ->addImage('partner_logo')
                ->addUrl('link')
                ->endRepeater()
            ->setLocation('post_type', '==', 'partner-carousel');

        acf_add_local_field_group($fields->build());
    }
}
