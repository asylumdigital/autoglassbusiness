<?php

namespace Asylum\Theme\Enqueue;

use Asylum\Theme\Helper\Settings;
use Timber\Timber;

class ThirdParty
{
    public function __construct()
    {
        add_action('wp_footer', [$this, 'addCookieBanner']);
        add_action('init', [$this, 'addScripts']);
    }

    public function addCookieBanner()
    {
        $settings = Settings::getInstance();
        $cookieSettings = $settings->getGroup('cookie_banner');

        if ($cookieSettings['api_key'] ?? false) {
            Timber::render('scripts/cookie-consent.twig', $cookieSettings);
        }
    }

    public function addScripts()
    {
        $settings = Settings::getInstance();

        $trackingSettings = $settings->getGroup('tracking');

        if ($trackingSettings['gtm'] ?? false) {
            switch($trackingSettings['gtm_location'] ?? 'footer') {
                case 'head':
                    add_action('wp_head', [$this, 'insertTagManager']);
                    break;
                default:
                    add_action('wp_footer', [$this, 'insertTagManager']);
            }
        }

        if ($trackingSettings['ga'] ?? false) {
            switch($trackingSettings['ga_location'] ?? 'footer') {
                case 'head':
                    add_action('wp_head', [$this, 'insertGoogleAnalytics']);
                    break;
                default:
                    add_action('wp_footer', [$this, 'insertGoogleAnalytics']);
            }
        }
    }

    public function insertTagManager()
    {
        $data = Settings::getInstance()->getGroup('tracking');
        Timber::render('scripts/gtm.twig', $data);

    }

    public function insertGoogleAnalytics()
    {
        $data = Settings::getInstance()->getGroup('tracking');
        Timber::render('scripts/ga.twig', $data);

    }


}
