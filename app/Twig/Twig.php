<?php

namespace Asylum\Theme\Twig;

use Asylum\Theme\Traits\Registration;
use Twig\TwigFilter;

class Twig
{
    use Registration;

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

        $twig->addFilter(new TwigFilter('html_attributes', 'html_build_attributes'));

        $twig->addFilter(new TwigFilter('sup', function($text) {
            return $this->superscriptRegMark($text);
        }));

        return $twig;
    }
}
