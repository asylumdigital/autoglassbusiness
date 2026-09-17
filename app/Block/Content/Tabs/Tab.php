<?php

namespace Asylum\Theme\Block\Content\Tabs;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Tab extends BlockController
{
    protected ?string $name = 'tab';

    protected ?string $label = 'Tab';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('title')
            ->addTextarea('description')
            ->addGroup('callout')
                ->addText('title')
                ->addTextarea('content')
                ->addLink('button')
                ->addTrueFalse('hide_on_mobile', [
                    'default_value' => true,
                    'ui' => true
                ])
                ->endGroup();

        return $fields;
    }

    public function declaration(): array
    {
        return [
            'parent' => [ "acf/tabs" ],
        ];
    }
}
