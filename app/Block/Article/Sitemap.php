<?php

namespace Asylum\Theme\Block\Article;

use Asylum\Block\BlockController;
use Timber\PostQuery;
use Timber\Timber;

class Sitemap extends BlockController
{
    protected ?string $name = 'sitemap';

    protected ?string $label = 'Sitemap';

    protected array $disallowedTemplates = [
        'template-policy.twig',
    ];

    protected function transform(&$data, array $args = []): void
    {
        $data['sitemap']['pages'] = [
            'title' => '',
            'items' => $this->getLinks('page'),
        ];

        $data['sitemap']['posts'] = [
            'title' => 'Resource centre',
            'items' => $this->getLinks('post'),
        ];
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
