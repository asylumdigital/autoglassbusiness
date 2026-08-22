<?php

namespace Asylum\Theme\Block\Slider;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Partner extends BlockController
{
    protected ?string $name = 'partner-marquee';

    protected ?string $label = 'Partner Marquee';

    protected ?string $template = 'block/slider/partner';

    protected string $category = 'asylum-carousel';

    protected string $icon = 'image-flip-horizontal';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addPostObject('partners', [
                'post_type' => [
                    'partner-carousel',
                ]
            ])
            ->addSelect('background', [
                'choices' => [
                    'bg-white' => 'White',
                    'bg-default' => 'Dark',
                    'bg-highlight' => 'Highlight',
                ],
                'default_value' => 'highlight',
            ])
            ->addTrueFalse('reverse', [
                'label' => 'Reverse direction',
                'ui' => true,
            ]);
        return $fields;
    }

    /**
     * Retrieve the fields
     *
     * @param array $data
     * @param array $args
     * @return void
     */
    protected function transform(&$data, array $args = []): void
    {
        $data['items'] = ($data['partners'] ?? false) ? get_fields($data['partners']->ID) : [];
    }

}
