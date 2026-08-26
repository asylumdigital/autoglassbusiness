<?php

namespace Asylum\Theme\Block\Content\InfoGrid\Cards;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Small extends BlockController
{
    protected ?string $name = 'info-grid-small';

    protected ?string $label = 'Small Item';

    public function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addImage('icon', [
                'mime_types' => 'svg',
            ])
            ->addText('content')
            ->addSelect('background', [
                'choices' => [
                    'bg-white' => 'White',
                    'bg-highlight' => 'Highlight',
                    'bg-default' => 'Dark',
                    'bg-primary' => 'Primary (red)',
                    'bg-secondary' => 'Secondary (yellow)',
                    'bg-tertiary' => 'Tertiary (Green)',
                ]
            ])
            ->addTrueFalse('stack', [
                'ui' => true,
            ]);

        return $fields;
    }

    public function declaration(): array
    {
        return [
            'parent' => [ "acf/info-grid" ],
        ];
    }
}
