<?php

namespace Asylum\Theme\Block\Content;

use Asylum\Block\BlockController;

class Tabs extends BlockController
{
    protected ?string $name = 'tabs';

    protected ?string $label = 'Tabs';

    protected string $category = 'asylum-content';

    protected string $icon = 'excerpt-view';

    protected function transform(&$data, array $args = []): void
    {
        $data['titles'] = collect($args['wp_block']->inner_blocks)->
            map(function($block) {
                return [
                    'name' => $block->parsed_block['attrs']['data']['title'] ?? '',
                    'slug' => sanitize_title($block->parsed_block['attrs']['data']['title'] ?? ''),
                ];
            })
            ->toArray();
    }
}
