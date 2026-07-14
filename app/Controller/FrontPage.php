<?php

namespace Asylum\Theme\Controller;

use Asylum\Core\Controller\CoreController;

class FrontPage extends CoreController
{
    public function test()
    {
        return 'This will appear in the context as \'test\'';
    }
}
