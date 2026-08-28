<?php

namespace Asylum\Theme\Block\Article;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;
use Timber\PostQuery;
use Timber\Timber;

class Sitemap extends BlockController
{
    protected ?string $name = 'sitemap';

    protected ?string $label = 'Sitemap';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $postTypes = get_post_types(['public' => true], 'objects');

        unset($postTypes['attachment']);

        $postTypes = array_map(fn($type) => $type->label, $postTypes);

        $fields
            ->addRepeater('sections')
                ->addText('title')
                    ->setWidth(50)
                ->addSelect('post_type', [
                    'choices' => $postTypes
                ])
                    ->setWidth(50)
                ;
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        if (empty($data['sections'])) {
            $data['sitemap']['pages'] = [
                'title' => 'Pages',
                'items' => $this->getLinks('page'),
            ];

            $data['sitemap']['posts'] = [
                'title' => 'Resource centre',
                'items' => $this->getLinks('post'),
            ];

            return;
        }

        foreach ($data['sections'] as $section) {
            $data['sitemap'][$section['post_type']] = [
                'title' => $section['title'],
                'items' => $this->getLinks($section['post_type']),
            ];
        }
    }

    private function getLinks($postType = 'post'): PostQuery
    {
        $args = [
            'post_type' => $postType,
            'posts_per_page' => -1,
            'post_parent' => 0,
        ];

        return Timber::get_posts($args);

    }
}
