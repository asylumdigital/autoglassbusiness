<?php

namespace Asylum\Theme\Block;

use Asylum\Block\BlockController;
use Asylum\Core\Image\ImageRegistry;
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
