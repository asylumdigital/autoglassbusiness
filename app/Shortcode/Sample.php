<?php

namespace Asylum\Theme\Shortcode;

class Sample
{
    public function __construct()
    {
        // current implmentation has not context, removing
        add_shortcode('sample', '__return_false');
    }
}
