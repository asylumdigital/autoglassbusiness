<?php

namespace Asylum\Theme\Block\Hero;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;

class Video extends BlockController
{
    protected ?string $name = 'hero-video';

    protected ?string $label = 'Image hero';

    protected string $category = 'asylum-hero';

    protected ?string $template = 'block/hero/video';

    protected string $icon = 'format-video';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addTextarea('title')
            ->addTextarea('content')
            ->addRepeater('buttons', [
                'layout' => 'block',
                'max' => 2
            ])
                ->addLink('link')
                ->addSelect('style', [
                    'choices' => [
                        'primary' => 'Primary',
                        'secondary' => 'Secondary',
                        'tertiary' => 'Tertiary'
                    ]
                ])
                ->endRepeater()
            ->addImage('mobile', [
                'preview_size' => 'thumbnail',
            ])
            ->addImage('large', [
                'preview_size' => 'thumbnail',
            ])
            ->addTrueFalse('left_gradient', [
                'ui' => true,
                'default_value' => false,
            ]);
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        $count = static::$blockCount;
        $small = $data['mobile']['url'];
        $large = $data['large']['url'];
        $style = <<<HTML
            <style>
                .hero-bg--{$count} {
                    --header-bg: url($small);
                }

                @media (width >= 1024px) {
                    .hero-bg--{$count} {
                        --header-bg: url($large);
                    }
                }
            </style>
        HTML;

        add_action('wp_head', function() use ($style) {
            echo $style;
        });
    }
}
