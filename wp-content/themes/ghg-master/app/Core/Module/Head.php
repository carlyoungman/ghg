<?php
/**
 * Class Header
 *
 * A class for registering functions affecting the site header
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Head
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Head {

	/**
	 * Retrieves head instance
	 *
	 * @return void
	 */
	public static function register(): void {
		self::meta_tags();
		self::links();
	}

	/**
	 * Return addtional head meta tags
	 */
	private static function meta_tags(): void {
		$data = [
			'<meta charset="' . get_bloginfo( 'charset' ) . '">',
			'<meta name="viewport" content="width=device-width, initial-scale=1">',
		];

		echo implode( PHP_EOL, $data ) . PHP_EOL; // phpcs:ignore
	}

	/**
	 * Display addtional <link> tags in the head
	 */
	private static function links(): void {
		$data = [ '<link rel="profile" href="https://gmpg.org/xfn/11">' ];

		echo implode( PHP_EOL, $data ) . PHP_EOL; // phpcs:ignore
	}
}
