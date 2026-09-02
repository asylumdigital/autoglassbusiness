<?php

namespace Asylum\Theme\Controller;

use Asylum\Theme\Helper\Settings;
use Timber;

class Common
{
    public function __construct()
    {
        add_filter('timber/context', [$this, 'getWidgets']);
        add_filter('timber/context', [$this, 'getMasthead']);
        add_filter('timber/context', [$this, 'getFooter']);
        // add_filter('asylum/context', [$this, 'getFallbackImage']);
        add_filter('default_post_metadata', [$this, 'getFallbackImage'], 10, 4);
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

    public function getMasthead(array $context): array
    {
        $settings = Settings::getInstance()->getGroup('masthead');

        $context['masthead'] = $settings;

        return $context;
    }

    /**
     * Undocumented function
     *
     * @param mixed $value
     * @param int $object_id
     * @param string $meta_key
     * @param boolean $single
     * @return mixed
     */
    public function getFallbackImage($value, $object_id, $meta_key, $single): mixed
    {
        if ($meta_key !== '_thumbnail_id' || !$single) {
            return $value;
        }

        $settings = Settings::getInstance()->getGroup('media');

        return ($settings['fallback_image'] ?? false) ?: null;
    }

    public function getFooter(array $context): array
    {
        $context['footer'] = Settings::getInstance()->getGroup('footer');
        return $context;
    }
}
