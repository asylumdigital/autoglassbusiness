<?php

namespace Asylum\Theme\Controller;

use Asylum\Theme\Helper\Settings;
use Timber;

class Common
{
    public function __construct()
    {
        add_filter('timber/context', [$this, 'getWidgets']);
        add_filter('timber/context', [$this, 'getFallbackImage']);
        add_filter('the_content', [$this, 'removeEmptyParagraph']);
    }

    public function getWidgets(array $context): array
    {
        global $wp_registered_sidebars;

        foreach (array_keys($wp_registered_sidebars) as $sidebar) {
            $context['aside_widgets'][$sidebar] = Timber::get_widgets($sidebar);
        }
        return $context;
    }

    public function removeEmptyParagraph(string $content): string
    {
        $content = str_replace("<p></p>", "", $content);
        $content = str_replace("<p>&nbsp;</p>", "", $content);
        return $content;
    }

    public function getFallbackImage(array $context): array
    {
        $settings = Settings::getInstance()->getGroup('media');

        $context['fallback_image'] = $settings['fallback_image'] ?? 0;

        return $context;
    }
}
