<?php

namespace Asylum\Theme\Block\Content;

use Asylum\Block\BlockController;
use Asylum\Core\Image\ImageRegistry;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContentSection extends BlockController
{
    protected ?string $name = 'content-section';

    protected ?string $label = 'Content Section';

    protected string $category = 'asylum-content';

    protected string $icon = 'admin-post';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Eyebrow subtitle'
            ])
            ->addTextarea('title')
            ->addSelect('style', [
                'choices' => [
                    'white' => 'White',
                    'dark' => 'Dark',
                    'highlight' => 'Off white',
                ]
            ])
            ->addImage('image', [
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
            ])
            ->addSelect('align', [
                'choices' => [
                    'left' => 'Left',
                    'right' => 'Right',
                ],
                'default_value' => 'left',
            ])
            ->addLink('cta', [
                'label' => 'Call to action',
            ]);
        return $fields;

    }

    protected function assets(): void
    {
        $assets = [
            'content_section' => [
                'md' => [700, 150],
                'lg' => [700],
                '2xl' => [240],
                'sm' => [100],
                'default' => [400, 30],
                'xl' => [294],
            ],
        ];

        foreach ($assets as $name => $size) {
            ImageRegistry::addSize($name, $size);
        }
    }
}
