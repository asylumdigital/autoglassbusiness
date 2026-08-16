<?php

namespace Asylum\Theme\Core;

use WP_Query;

class Search
{
    protected array $postTypes = [
        'post',
    ];

    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'setSearchParams']);
    }

    /**
     * Only include give post types in search
     *
     * @param WP_Query $query
     * @return void
     */
    public function setSearchParams(WP_Query $query): void
    {
        if (!is_admin() && $query->is_search()) {
            $query->set('post_type', $this->postTypes);
        }
    }
}
