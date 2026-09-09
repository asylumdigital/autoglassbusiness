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
            ->addGroup('buttons')
                ->addLink('primary')
                ->addLink('secondary')
                ->endGroup()
            ->addImage('mobile', [
                'preview_size' => 'thumbnail',
            ])
            ->addImage('large', [
                'preview_size' => 'thumbnail',
            ]);
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        add_action('wp_head', function() use ($data) {
            $small = $data['mobile']['url'];
            $large = $data['large']['url'];
            echo <<<HTML
                <style>
                    :root {
                        --header-bg: url($small);
                    }

                    @media (width >= 1024px) {
                        :root {
                            --header-bg: url($large);
                        }
                    }
                </style>
            HTML;
        });
    }
}
