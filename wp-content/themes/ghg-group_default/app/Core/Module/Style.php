<?php
/**
 * Class Style
 *
 * Enqueue all style sheets
 *
 * @package Elementary\Theme
 */

namespace BOILERPLATE_THEME\Core\Module;

use BOILERPLATE_THEME\Concerns\FileUtil;

/**
 * Class Style
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Style {


	use FileUtil;


	/**
	 * List all front end stylesheet requirements as named arrays
	 */
	private const FRONTEND = [
		'child-theme' => '/dist/css/style.css',
	];

	/**
	 * Register theme styles
	 */
	public static function register(): void {

		self::enqueue_frontend();
	}

	/**
	 * Enqueue admin styles
	 */


	/**
	 * Enqueue front end styles
	 */
	private static function enqueue_frontend(): void {
		foreach ( self::FRONTEND as $handle => $uri ) {
			if ( file_exists( BOILERPLATE_THEME_PATH . $uri ) !== false ) {

				wp_enqueue_style(
					BOILERPLATE_NAMESPACE . '_' . $handle,
					BOILERPLATE_THEME_URL . $uri,
					[],
					filemtime( BOILERPLATE_THEME_PATH . $uri )
				);
				// style data
				wp_style_add_data( $handle, 'rtl', 'replace' );
			}
		}
		wp_deregister_style( 'yeahright-theme-styles' );
	}
}
