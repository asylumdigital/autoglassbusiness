<?php

namespace Asylum\Theme\Block\Callout;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class IconCallout extends BlockController
{
    protected ?string $name = 'icon-callout';

    protected ?string $label = 'Icon callout';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addTextarea('introduction')
            ->addSelect('style', [
                'choices' => [
                    'white' => 'White',
                    'dark' => 'Dark',
                    'highlight' => 'Off white',
                ]
            ])
            ->addRepeater('items', [
                'layout' => 'block',
                'min' => 2,
                'max' => 6,
            ])
                ->addImage('icon', [
                    'mime_types' => 'svg',
                    'preview_size' => 'thumbnail',
                ])
                ->addText('label')
                ->endRepeater()
            ->addGroup('call_to_action')
                ->addLink('link')
                ->addSelect('style', [
                    'choices' => [
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'tertiary' => 'Tertiary'
                    ]
                ])
                ->endGroup()
            ->addTrueFalse('caps', [
                'ui' => true,
                'label' => 'Uppercase labels'
            ]);
        return $fields;
    }
}
