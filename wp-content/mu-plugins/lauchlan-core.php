<?php
/*
    Plugin Name: Lauchlan Core Functions
    Description: Core functions, helpers, and customizations
    Version: 1.0
    Author: Lauchlan
    Author URI: http://lauchlanx.com
*/

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class
 */
require plugin_dir_path( __FILE__ ) . 'lauchlan-core/lauchlan-core.php';

/**
 * WP Password bcrypt
 * Only on PHP 5.5+
 */
if (defined('PHP_VERSION_ID') && PHP_VERSION_ID >= 50500) {
    require plugin_dir_path( __FILE__ ) . 'lauchlan-core/wp-password-bcrypt.php';
}
