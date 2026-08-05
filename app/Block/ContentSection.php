<?php

namespace Asylum\Theme\Block;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ContentSection extends BlockController
{
    protected ?string $name = 'content-section';

    public function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addWysiwyg('content', [
                'toolbar' => 'basic',
                'media_upload' => false,
            ]);
        return $fields;

    }
}
