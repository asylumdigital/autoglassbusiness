<?php

namespace Asylum\Theme\Controller;

use Timber\Timber;
use Asylum\Core\Controller\CoreController;

class Archive extends CoreController
{
    public function term()
    {
        return Timber::get_term();
    }

}
