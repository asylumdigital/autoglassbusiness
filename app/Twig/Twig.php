<?php

namespace Asylum\Theme\Twig;

use Twig\TwigFilter;
class Twig
{
    public function __construct()
    {
        add_filter('timber/twig', [$this, 'addFilters']);
    }


    public function addFilters($twig)
    {
        /* Example */
        $twig->addFilter(new TwigFilter('theme', function ($asset) {
            $link = get_stylesheet_directory_uri() . '/dist/img/' . $asset;
            return str_replace(site_url(), "", $link);
        }));

        return $twig;
    }
}
