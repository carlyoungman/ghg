<?php
/**
 * Class Customizer
 *
 * A class for registering functions for the theme customizer API
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Customizer
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Customizer {

	/**
	 * Retrieves customizer instance
	 *
	 * @return void
	 */
	public static function register(): void {
	}

	/**
	 * This function is used to prevent selected pages from being deleted. Each page is being used as archive page
	 *
	 * @param int $post_ID post id of the restricted page
	 *
	 * @return void
	 */
	public static function restrict_page_deletion( int $post_ID ): void {
		$restricted_page_id = [];
		if ( in_array( $post_ID, $restricted_page_id, true ) ) {
			echo 'You are not authorized to delete this page';
			exit();
		}
	}

}
