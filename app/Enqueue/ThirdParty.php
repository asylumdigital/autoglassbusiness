<?php

namespace Asylum\Theme\Enqueue;

use Asylum\Theme\Helper\Settings;
use Timber\Timber;

class ThirdParty
{
    public function __construct()
    {
        add_action('wp_footer', [$this, 'addScripts']);
    }

    public function addScripts()
    {

        $settings = Settings::getInstance();

        Timber::render('scripts/cookie-consent.twig');

        
    }
}
