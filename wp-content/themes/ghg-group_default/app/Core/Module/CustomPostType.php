<?php
/**
 * Class CustomPostType
 *
 * A class to register Custom Post Types
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use function register_extended_post_type;

/**
 * Class CustomPostType
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class CustomPostType {

	/**
	 * Register all custom post types using extended-cpt
	 *
	 * @link https://github.com/johnbillion/extended-cpts/wiki
	 */
	public static function register(): void {
		$support = [ 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' ];

		/** Title */
//		register_extended_post_type(
//			'title',
//			[
//				'show_in_rest'  => true,
//				'menu_icon'     =>
//					'data:image/svg+xml;base64,' .
//					base64_encode(
//						'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" height="48" width="48"><path d="M25.6 35.5q2.5-1.25 4.9-1.875Q32.9 33 35.6 33q1.9 0 3.925.3t3.475.8V12.65q-1.7-.85-3.6-1.25-1.9-.4-3.8-.4-2.7 0-5.225.825-2.525.825-4.775 2.325Zm-1.5 3.95q-.4 0-.725-.075-.325-.075-.575-.275-2.35-1.45-5-2.25t-5.4-.8q-1.85 0-3.6.45t-3.5 1.1q-1.15.55-2.225-.15Q2 36.75 2 35.45V12.3q0-.75.35-1.375T3.4 9.95q2.1-1 4.375-1.475Q10.05 8 12.4 8q3.15 0 6.125.85t5.575 2.6q2.55-1.75 5.475-2.6Q32.5 8 35.6 8q2.35 0 4.6.475 2.25.475 4.35 1.475.7.35 1.075.975T46 12.3v23.15q0 1.4-1.125 2.125-1.125.725-2.225.025-1.7-.7-3.45-1.125-1.75-.425-3.6-.425-2.7 0-5.3.8-2.6.8-4.9 2.25-.25.2-.575.275-.325.075-.725.075Z"/></svg>'
//					),
//				'supports'      => $support,
//				'has_archive'   => false,
//				'admin_cols'    => [
//					'title_category' => [
//						'taxonomy' => 'title-category',
//					],
//				],
//				'admin_filters' => [
//					'title_category' => [
//						'taxonomy' => 'title-category',
//					],
//				],
//			]
//		);
	}
}
