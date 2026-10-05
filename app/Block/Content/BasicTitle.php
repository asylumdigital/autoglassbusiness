<?php

namespace Asylum\Theme\Block\Content;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class BasicTitle extends BlockController
{
    protected ?string $name = 'basic-title';

    protected ?string $label = 'Basic title';

    protected string $category = 'asylum-content';

    protected string $icon = 'heading';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    public function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title');
        return $fields;

    }
}
