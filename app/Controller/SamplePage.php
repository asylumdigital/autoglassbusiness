<?php

namespace Asylum\Theme\Controller;

use Asylum\Core\Controller\CoreController;

class SamplePage extends CoreController
{
    public function test()
    {
        return 'This will appear in the context as \'test\'';
    }
}
