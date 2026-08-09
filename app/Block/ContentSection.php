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
                // Toolbar registered by Asylum\Theme\Editor\ListStyles
                'toolbar' => 'content',
                'media_upload' => false,
            ]);
        return $fields;

    }
}
