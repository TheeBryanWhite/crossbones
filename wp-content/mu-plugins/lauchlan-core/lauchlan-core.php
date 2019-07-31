<?php

/**
 * The core plugin class.
 */
if (!class_exists('Lauchlan_Core')) {

	class Lauchlan_Core {

		private static $instance;

		/**
		 * Instance of the plugin
		 */
		public static function instance() {
			if (!isset(self::$instance) && !(self::$instance instanceof Lauchlan_Core)) {
				self::$instance = new Lauchlan_Core;
				self::$instance->includes();
				self::$instance->init = new Lauchlan_Core_Init();
			}
			return self::$instance;
		}

		/**
		 * Load required files
		 */
		private function includes() {
			$plugin_path = plugin_dir_path(__FILE__);

			// Classes
			require $plugin_path . 'includes/class-development.php';
			require $plugin_path . 'includes/class-theme-setup.php';
			require $plugin_path . 'includes/class-acf.php';
			require $plugin_path . 'includes/class-gforms.php';
			require $plugin_path . 'admin/class-admin-render.php';
			require $plugin_path . 'admin/class-media-library.php';
			require $plugin_path . 'admin/class-performance.php';
			require $plugin_path . 'admin/class-permissions.php';
			require $plugin_path . 'admin/class-reveal-ids.php';
			require $plugin_path . 'admin/class-widgets.php';
			require $plugin_path . 'public/class-public-render.php';
			require $plugin_path . 'public/class-search.php';
			require $plugin_path . 'public/rot13-encode-decode/rot13-encode-decode.php';
			
			// Initialize classes
			require $plugin_path . 'includes/class-lauchlan-core-init.php';

			// Global functions
			require $plugin_path . 'public/helpers.php';
			require $plugin_path . 'public/pagination.php';
			require $plugin_path . 'public/smart-excerpt.php';

		}

	}

}
/**
 * Return the instance
 */
function Lauchlan_Core_Run() {
	return Lauchlan_Core::instance();
}
Lauchlan_Core_Run();
