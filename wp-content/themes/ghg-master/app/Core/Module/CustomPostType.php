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
		$site_id = get_current_blog_id();
		if ( $site_id === 6 ) {
			register_extended_post_type(
				'product_innovation',
				[
					'show_in_rest' => true,
					'has_archive'  => false,
					'menu_icon'    =>
						'data:image/svg+xml;base64,' .
						base64_encode(
							'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-80q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM360-200q-17 0-28.5-11.5T320-240q0-17 11.5-28.5T360-280h240q17 0 28.5 11.5T640-240q0 17-11.5 28.5T600-200H360Zm-30-120q-69-41-109.5-110T180-580q0-125 87.5-212.5T480-880q125 0 212.5 87.5T780-580q0 81-40.5 150T630-320H330Zm24-80h252q45-32 69.5-79T700-580q0-92-64-156t-156-64q-92 0-156 64t-64 156q0 54 24.5 101t69.5 79Zm126 0Z"/></svg>'
						),
					'supports'     => $support,
				],
				[
					'singular' => 'Innovation',
					'plural'   => 'Innovations',
					'slug'     => 'product-innovation',
				]
			);
			register_extended_post_type(
				'series',
				[
					'show_in_rest' => true,
					'has_archive'  => false,
					'menu_icon'    =>
						'data:image/svg+xml;base64,' .
						base64_encode(
							'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-160q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm480 0q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM480-560q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Z"/></svg>'
						),
					'supports'     => $support,
				],
				[
					'singular' => 'Series',
					'plural'   => 'Series',
					'slug'     => 'series',
				]
			);
		}

		if ( $site_id === 5 || $site_id === 1 || $site_id === 7 ) {
			register_extended_post_type(
				'case_studies',
				[
					'show_in_rest' => true,
					'menu_icon'    =>
						'data:image/svg+xml;base64,' .
						base64_encode(
							'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" height="48" width="48"><path d="M25.6 35.5q2.5-1.25 4.9-1.875Q32.9 33 35.6 33q1.9 0 3.925.3t3.475.8V12.65q-1.7-.85-3.6-1.25-1.9-.4-3.8-.4-2.7 0-5.225.825-2.525.825-4.775 2.325Zm-1.5 3.95q-.4 0-.725-.075-.325-.075-.575-.275-2.35-1.45-5-2.25t-5.4-.8q-1.85 0-3.6.45t-3.5 1.1q-1.15.55-2.225-.15Q2 36.75 2 35.45V12.3q0-.75.35-1.375T3.4 9.95q2.1-1 4.375-1.475Q10.05 8 12.4 8q3.15 0 6.125.85t5.575 2.6q2.55-1.75 5.475-2.6Q32.5 8 35.6 8q2.35 0 4.6.475 2.25.475 4.35 1.475.7.35 1.075.975T46 12.3v23.15q0 1.4-1.125 2.125-1.125.725-2.225.025-1.7-.7-3.45-1.125-1.75-.425-3.6-.425-2.7 0-5.3.8-2.6.8-4.9 2.25-.25.2-.575.275-.325.075-.725.075Z"/></svg>'
						),
					'supports'     => $support,
					'has_archive'  => false,
				],
				[
					'singular' => 'Case study',
					'plural'   => 'Case studies',
					'slug'     => 'case-studies',
				]
			);
			register_extended_post_type(
				'sectors',
				[
					'show_in_rest' => true,
					'menu_icon'    =>
						'data:image/svg+xml;base64,' .
						base64_encode(
							'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" height="48" width="48" viewBox="0 -960 960 960"><path d="M120-520v-320h320v320H120Zm0 400v-320h320v320H120Zm400-400v-320h320v320H520Zm0 400v-320h320v320H520ZM200-600h160v-160H200v160Zm400 0h160v-160H600v160Zm0 400h160v-160H600v160Zm-400 0h160v-160H200v160Zm400-400Zm0 240Zm-240 0Zm0-240Z"/></svg>'
						),
					'supports'     => $support,
					'has_archive'  => false,
				],
				[
					'singular' => 'Sector',
					'plural'   => 'Sectors',
					'slug'     => 'sectors',
				]
			);
		}

		if (
			get_bloginfo( 'name' ) == 'AUT' ||
			get_bloginfo( 'name' ) == 'AUT Wheels & Castors'
		) {
			register_extended_post_type(
				'product_innovation',
				[
					'show_in_rest' => true,
					'has_archive'  => false,
					'menu_icon'    =>
						'data:image/svg+xml;base64,' .
						base64_encode(
							'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M480-80q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM360-200q-17 0-28.5-11.5T320-240q0-17 11.5-28.5T360-280h240q17 0 28.5 11.5T640-240q0 17-11.5 28.5T600-200H360Zm-30-120q-69-41-109.5-110T180-580q0-125 87.5-212.5T480-880q125 0 212.5 87.5T780-580q0 81-40.5 150T630-320H330Zm24-80h252q45-32 69.5-79T700-580q0-92-64-156t-156-64q-92 0-156 64t-64 156q0 54 24.5 101t69.5 79Zm126 0Z"/></svg>'
						),
					'supports'     => $support,
				],
				[
					'singular' => 'Innovation',
					'plural'   => 'Innovations',
					'slug'     => 'product-innovation',
				]
			);
			register_extended_post_type(
				'series',
				[
					'show_in_rest' => true,
					'has_archive'  => false,
					'public'       => true,
					'menu_icon'    =>
						'data:image/svg+xml;base64,' .
						base64_encode(
							'<svg fill="#a7aaad" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-160q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Zm480 0q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM480-560q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35Z"/></svg>'
						),
					'supports'     => $support,
				],
				[
					'singular' => 'Series',
					'plural'   => 'Series',
					'slug'     => 'series',
				]
			);
		}
	}
}
