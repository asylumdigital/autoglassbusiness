<?php

namespace Asylum\Theme\Block\Callout;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Callout extends BlockController
{
    protected ?string $name = 'callout';

    protected ?string $label = 'Callout';

    protected string $category = 'asylum-callout';

    protected string $icon = 'megaphone';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addSelect('style', [
                'choices' => [
                    'none' => 'None',
                    'dark' => 'Dark',
                    'highlight' => 'Highlight',
                    'primary' => 'Primary',
                    'secondary' => 'Secondary',
                ],
                'default_value' => 'primary',
            ])
            ->addTrueFalse('inner_only', [
                'ui' => true,
            ])
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addTextarea('content')
            ->addLink('button');
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        if ($data['style'] !== 'none' && $data['inner_only'] ?? false) {
            $data['inner_color'] = $data['style'];
            unset($data['style']);
        }
    }

}
