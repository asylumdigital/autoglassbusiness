<?php

namespace Asylum\Theme\Controller;

use Asylum\Core\Controller\CoreController;
use Timber\Timber;

class Styleguide extends CoreController
{
    public function demo_posts()
    {
        return Timber::get_posts([
            'posts_per_page' => 6,
            'post_type' => ['post'],
        ]);
    }
}
