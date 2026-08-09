<?php

namespace Asylum\Theme\Controller;

use Timber;

class Common
{
    public function __construct()
    {
        add_filter('timber/context', [$this, 'getWidgets']);
        add_filter('the_content', [$this, 'removeEmptyParagraph']);
    }

    public function getWidgets($context)
    {
        global $wp_registered_sidebars;

        foreach (array_keys($wp_registered_sidebars) as $sidebar) {
            $context['aside_widgets'][$sidebar] = Timber::get_widgets($sidebar);
        }
        return $context;
    }

    public function removeEmptyParagraph($content)
    {
        $content = str_replace("<p></p>", "", $content);
        $content = str_replace("<p>&nbsp;</p>", "", $content);
        return $content;
    }
}
