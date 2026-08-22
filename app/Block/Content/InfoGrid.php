<?php

namespace Asylum\Theme\Block\Content;

use Asylum\Block\BlockController;
use Asylum\Core\Image\ImageRegistry;
use StoutLogic\AcfBuilder\FieldsBuilder;

class InfoGrid extends BlockController
{
    protected ?string $name = 'info-grid';

    protected ?string $label = 'Info Grid';

    protected string $category = 'asylum-content';

    protected string $icon = 'grid-view';

    public function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addTextarea('introduction');
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
