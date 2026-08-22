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

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addTextarea('title')
            ->addTextarea('content')
            ->addGroup('buttons')
                ->addLink('primary')
                ->addLink('secondary')
                ->endGroup()
            ->addImage('image', [
                'preview_size' => 'thumbnail',
                'return_format' => 'id'
            ]);
        return $fields;
    }
}
