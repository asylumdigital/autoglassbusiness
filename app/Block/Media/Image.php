<?php

namespace Asylum\Theme\Block\Media;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Image extends BlockController
{
    protected ?string $name = 'image';

    protected ?string $label = 'Image';

    protected string $category = 'asylum-media';

    protected string $icon = 'format-image';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addImage('image', [
                'preview_size' => 'thumbnail',
            ])
            ->addText('image_caption', [
                'label' => 'Caption'
            ])
                ->setWidth(50)
            ->addText('image_alt', [
                'label' => 'Alternative text',
                'instructions' => 'Override the media library alt text',
            ])
                ->setWidth(50)
            ->addSelect('aspect', [
                'choices' => [
                    'square' => 'Square',
                    'video' => 'Video',
                    'natural' => 'Natural'
                ],
                'default_value' => 'video',
            ])
            ->addTrueFalse('max_width', [
                'ui' => true,
                'instructions' => 'Restrict the image width to it\'s maximum size',
            ]);
        return $fields;
    }

    public function declaration(): array
    {
        return [
            'parent' => [ "acf/prose" ],
        ];
    }
}
