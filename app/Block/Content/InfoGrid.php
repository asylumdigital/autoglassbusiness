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

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

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
}
