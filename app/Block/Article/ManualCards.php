<?php

namespace Asylum\Theme\Block\Article;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ManualCards extends BlockController
{
    protected ?string $name = 'manual-cards';

    protected ?string $label = 'Custom cards';

    protected ?string $template = 'block/article/list';

    protected string $category = 'asylum-content';

    protected string $icon = 'list-view';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addTextarea('introduction')
            ->addSelect('style', [
                'label' => 'Card style',
                'choices' => [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ]
            ])
            ->addSelect('card_color', [
                'label' => 'Card Colour',
                'choices' => [
                    'dark' => 'Dark',
                    'light' => 'White',
                    'highlight' => 'Highlight'
                ],
                'default_value' => 'white',
            ])
            ->addRepeater('cards', [
                'layout' => 'row',
            ])
                ->addText('title')
                ->addTextarea('preview')
                ->addImage('thumbnail')
                ->addPostObject('link')
                ->endRepeater();
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        $data['posts'] = collect($data['cards'])
            ->map(function($item) {
                $item['post'] = $item['link'];
                $item['link'] = get_permalink($item['post']);

                return $item;
            })
            ->toArray();
    }
}

// image
// title
// excerpt/preview
// url
