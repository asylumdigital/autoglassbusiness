<?php

namespace Asylum\Theme\Update;

use Asylum\Internal\Token;
use Asylum\Update\Manager;
use Asylum\Update\Package\Theme;

class Updater
{
    public function __construct()
    {
        $theme = new Theme('autoglassbusiness');
        $theme->setParam('key', Token::get());
        Manager::register($theme);
    }
}
