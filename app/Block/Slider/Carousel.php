<?php

namespace Asylum\Theme\Block\Slider;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Carousel extends BlockController
{
    protected ?string $name = 'carousel';

    protected ?string $label = 'Carousel';

    protected string $category = 'asylum-carousel';

    protected string $icon = 'slides';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addTextarea('introduction')
            ->addSelect('background', [
                'choices' => [
                    'dark' => 'Dark',
                    'light' => 'Light'
                ],
                'default_value' => 'light',
            ]);
        return $fields;
    }
}
