<?php

namespace Asylum\Theme\Block\Hero;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Standard extends BlockController
{
    protected ?string $name = 'standard';

    protected ?string $label = 'Standard Hero';

    protected string $category = 'asylum-hero';

    protected string $icon = 'cover-image';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addTextarea('title')
            ->addTextarea('content')
            ->addRepeater('buttons', [
                'layout' => 'block',
                'max' => 2
            ])
                ->addLink('link')
                ->addSelect('style', [
                    'choices' => [
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'tertiary' => 'Tertiary'
                    ]
                ])
                ->endRepeater()
            ->addImage('image', [
                'preview_size' => 'thumbnail',
                'return_format' => 'id'
            ]);
        return $fields;
    }
}
