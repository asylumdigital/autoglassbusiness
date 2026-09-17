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
            ->addTextarea('description');

        return $fields;
    }

    public function declaration(): array
    {
        return [
            'parent' => [ "acf/tabs" ],
        ];
    }
}
