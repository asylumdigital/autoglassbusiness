<?php

namespace Asylum\Theme\Block\Article;

use Asylum\Block\BlockController;
use StoutLogic\AcfBuilder\FieldsBuilder;
use Timber\Timber;

class ArticleList extends BlockController
{
    protected ?string $name = 'article-list';

    protected ?string $label = 'Article List';

    protected ?string $template = 'block/article/list';

    protected string $category = 'asylum-content';

    protected string $icon = 'list-view';

    protected function fields(FieldsBuilder $fields): FieldsBuilder
    {
        $postTypes = ['any' => 'Any'] + array_map(fn($type) => $type->label, get_post_types(['public' => true], 'objects'));

        unset(
            $postTypes['attachment'],
        );
        $fields
            ->addText('eyebrow', [
                'label' => 'Accent title',
            ])
            ->addText('title')
            ->addTextarea('introduction')
            ->addSelect('selection', [
                'choices' => [
                    'manual' => 'Manual',
                    'recent' => 'Recent',
                ],
            ])
            ->addSelect('style', [
                'label' => 'Card style',
                'choices' => [
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ]
            ])
            ->addRelationship('posts', [
                'post_type' => [
                    'post',
                    'page',
                ],
                'min' => 3,
                'max' => 12,
                'return_format' => 'id',
            ])
                ->conditional('selection', '==', 'manual')
            ->addNumber('count', [
                'default_value' => 6,
                'min' => 3,
                'max' => 12,

            ])
                ->setWidth(50)
                ->conditional('selection', '!=', 'manual')
            ->addSelect('type', [
                'choices' => $postTypes,
            ])
                ->setWidth(50)
                ->conditional('selection', '!=', 'manual')
            ->addTaxonomy('category', [
                'label' => 'Limit to these categories',
                'taxonomy' => 'category',
                'return_format' => 'id',
                'field_type' => 'multi_select',
            ])
                ->conditional('type', '!=', 'manual')
                ->and('type', '==', 'post')
            ;
        return $fields;
    }

    protected function transform(&$data, array $args = []): void
    {
        $query = [];
        // if (($data['selection'] ?? false) !== 'manual') {
        //     dd($data);
        // }

        if (($data['selection'] ?? false) === 'manual') {
            $query['post__in'] = $data['posts'];
            $query['posts_per_page'] = count($data['posts'] ?? []);
            $args['post_type'] = 'any';
        } else {
            $query['posts_per_page'] = (int) ($data['count'] ?? 6);
            $query['post_type'] = $data['type'];

            if ($data['category'] ?? false) {
                $query['tax_query'] = [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $data['category'],
                    ]
                ];
            }
        }

        $data['posts'] = Timber::get_posts($query);
    }
}
