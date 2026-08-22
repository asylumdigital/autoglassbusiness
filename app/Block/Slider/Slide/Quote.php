<?php

namespace Asylum\Theme\Block\Slider\Slide;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Quote extends BlockController
{
    protected ?string $name = 'quote-slide';

    protected ?string $label = 'Quote Slide';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addImage('image', [
                'label' => 'Feature images',
                'preview_size' => 'thumbnail',
                'return_format' => 'id',
            ])
            ->addTextarea('content')
            ->addImage('logo', [
                'label' => 'Logo',
                'preview_size' => 'thumbnail',
            ]);
        return $fields;
    }

    public function declaration(): array
    {
        return [
            'parent' => [ "acf/carousel" ],
        ];
    }
}
