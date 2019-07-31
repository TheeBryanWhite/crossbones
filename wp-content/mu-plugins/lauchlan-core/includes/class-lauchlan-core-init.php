<?php

/**
 * Main Init Class
 */

class Lauchlan_Core_Init {

	public function __construct() {

		$lauchlan_core_acf                = new Lauchlan_Core_ACF();
		$lauchlan_core_admin_render       = new Lauchlan_Core_Admin_Render();
		$lauchlan_core_admin_widgets      = new Lauchlan_Core_Admin_Widgets();
		$lauchlan_core_media_library      = new Lauchlan_Core_Media_Library();
		$lauchlan_core_performance        = new Lauchlan_Core_Performance();
		$lauchlan_core_permissions        = new Lauchlan_Core_Permissions();
		$lauchlan_core_public_render      = new Lauchlan_Core_Public_Render();
		$lauchlan_core_pretty_search_urls = new Lauchlan_Core_Search();
		$lauchlan_core_theme_setup        = new Lauchlan_Core_Theme_Setup();

		if ((defined('WP_DEBUG') && WP_DEBUG === true) && is_admin() ) {
			$lauchlan_core_reveal_ids = new Lauchlan_Core_Reveal_IDs();
		}

	}

}
