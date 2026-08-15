<?php

namespace Asylum\Theme\Controller;

use Asylum\Core\Controller\CoreController;
use Timber\Timber;

class Single extends CoreController
{
    public function relatedPosts()
    {
        $current = get_the_ID();

        return Timber::get_posts([
            'post__not_in' => [$current],
            'posts_per_page' => 6,
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => collect(get_the_terms($current, 'category'))
                        ->map(fn($t) => $t->term_id)
                        ->toArray(),
                ],
            ],
        ]);
    }
}
