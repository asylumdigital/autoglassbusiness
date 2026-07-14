<?php

if (! defined('WPINC')) {
    die('Something has gone wrong');
}

if (!defined('THEME_PATH')) {
    define('THEME_PATH', get_template_directory());
}

if (!defined('THEME_ABS_PATH')) {
    define('THEME_ABS_PATH', str_replace(substr(ABSPATH, 0, -1), '', THEME_PATH));
}

if (!defined('THEME_VERSION')) {
    define('THEME_VERSION', $theme->get('Version'));
}

if (!defined('THEME_SLUG')) {
    define('THEME_SLUG', $theme->get('TextDomain'));
}
