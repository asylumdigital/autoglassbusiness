<?php

namespace Asylum\Theme\Core\ListStyle;

use WP_Block;

class Block
{
    use Bullet;

    public function __construct()
    {
        add_filter('render_block_core/list', [$this, 'alterBlock'], 10, 3);
    }

    public function alterBlock(string $blockContent, array $block, WP_Block $instance)
    {

        return $this->unorderedBullet($blockContent);
    }
}
