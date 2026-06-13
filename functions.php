<?php
/**
 * Winter theme functions.
 *
 * @package Winter
 */

if (! defined('ABSPATH')) {
    exit;
}

define('WSWA_VERSION', '1.0.2');
define('WSWA_THEME_DIR', get_template_directory());
define('WSWA_THEME_URI', get_template_directory_uri());

require_once WSWA_THEME_DIR . '/inc/setup.php';
require_once WSWA_THEME_DIR . '/inc/helpers.php';
require_once WSWA_THEME_DIR . '/inc/acf.php';
require_once WSWA_THEME_DIR . '/inc/updater.php';
