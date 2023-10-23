<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * Class Template
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use WC_Product;
use WC_Subscriptions_Product;
use WP_Query;

/**
 * Class Template
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Template {


	/**
	 * This function is responsible for displaying the ACF flexible components
	 * Page builder
	 * https://www.advancedcustomfields.com/resources/flexible-content/
	 */
	public static function get_flexible_components(): void {
		if ( function_exists( 'have_rows' ) && function_exists( 'get_row_layout' ) && function_exists( 'get_template_part' ) ) {
			$path       = './template-parts/flexible/';
			$components = [
				'hero',
				'headline_with_content',
				'image_with_content',
				'key_points',
				'news_&_media',
				'slider_section',
				'testimonials',
				'cards_grid',
				'content_block',
				'listing_block',
				'current_vacancies',
				'inline_forms',
				'location_map',
				'group_listing'
			];

			if ( have_rows( 'flexible' ) ) {
				while ( have_rows( 'flexible' ) ) {
					the_row();
					foreach ( $components as $component ) {
						if ( get_row_layout() === $component ) {
							get_template_part( $path . $component );
						}
					}
				}
			}
		}
	}

	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @param array $classes Classes for the body element.
	 *
	 * @return array
	 */
	public static function body_classes( array $classes ): array {
		// Helps detect if JS is enabled or not.
		$classes[] = 'no-js';
		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';
		// Add a body class if the main navigation is active.
		if ( has_nav_menu( 'primary' ) ) {
			$classes[] = 'has-main-navigation';
		}

		return $classes;
	}

	/**
	 * This function is responsible for display yoast breadcrumbs
	 */
	public static function breadcrumbs(): void {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
		}
	}

	/**
	 * This function is responsible for displaying a fallback image if a featured image isn't found
	 *
	 * @param string $base Class name to be applied
	 * @param int $image_id Content's featured image ID
	 * @param string $size image size that should be used for the image
	 * @param bool $echo A flag to return or echo the image
	 *
	 * @return string return ot echo the image
	 */
	public static function get_image_with_fallback(
		string $base,
		int $image_id,
		string $size,
		bool $echo = false
	): string {
		// Check if the image exists over-wise use the fallback ID
		if ( ! $image_id ) {
			$image_id = get_field( 'fallback_image', 'options' )['id'] ?? 0;
		}
		// Build the image
		$image = wp_get_attachment_image(
			$image_id,
			$size,
			false,
			[
				'class' => esc_attr( $base ) . '__image',
			]
		);
		if ( false === $echo ) {
			return $image;
		}
		$allowed_html = [
			'img' => [
				'src'    => true,
				'srcset' => true,
				'sizes'  => true,
				'alt'    => true,
				'width'  => true,
				'height' => true,
				'class'  => true,
			],
		];
		echo wp_kses( $image, $allowed_html );

		return '';
	}

	/**
	 * This function can be used to display two buttons side by side.
	 *
	 * @param string $base Class name to be applied
	 * @param array $buttons Array of ACF links
	 * @param bool $echo A flag to return or echo
	 *
	 * @return string
	 */
	public static function build_buttons(
		string $base,
		array $buttons,
		bool $echo = false
	): string {
		$rtn = '';
		if ( ! empty( $buttons ) ) {
			$rtn .= '<div class="' . $base . '__button-grid">';
			foreach ( $buttons as $button ) :
				$rtn .= self::build_button(
					$base,
					$button['button'],
					false,
					false
				);
			endforeach;
			$rtn .= '</div>';
		}
		if ( false === $echo ) {
			return $rtn;
		}

		echo $rtn;

		return '';
	}

	/**
	 * This function can be used to build a button or link from an ACF link
	 *
	 * @param string $base Class name to be applied
	 * @param array $props ACF link array
	 * @param bool $button A flag to return a button or a tag
	 * @param bool $echo A flag to return or echo
	 *
	 * @return string return a button or a tag
	 */
	public static function build_button(
		string $base,
		$props,
		bool $button = true,
		bool $echo = false
	): string {
		if ( ! empty( $props ) ) {
			$tag_open  = '<a ';
			$tag_close = '</a>';
			if ( true === $button ) {
				$tag_open  = '<button ';
				$tag_close = '</button>';
			}
			// Destructure passed properties
			$url     = $props['url'] ?? '';
			$target  =
				isset( $props['target'] ) && '' !== $props['target']
					? $props['target']
					: '_self';
			$title   = esc_html( $props['title'] ) ?? '';
			$classes = $base . '__button';
			// Final construction
			$rtn = $tag_open;
			$rtn .= 'class="' . esc_attr( $classes ) . '"';
			$rtn .= 'aria-label="' . $title . '"';
			$rtn .= 'rel="noreferrer noopener"';
			$rtn .= 'href="' . esc_url( $url ) . '"';
			if ( ! empty( $props['answers'] ) ) {
				$rtn .= 'data-answers="' . htmlspecialchars( $props['answers'] ) . '"';
			}
			if ( ! empty( $props['product_ID'] ) ) {
				$rtn .= 'data-product-ID="' . esc_attr( $props['product_ID'] ) . '"';
			}
			$rtn .= 'target="' . esc_attr( $target ) . '">';
			$rtn .= $title;
			$rtn .= $tag_close;

			if ( false === $echo ) {
				return $rtn;
			}
			echo $rtn;
		}

		return '';
	}

	/**
	 * This function is responsible for getting categories of a single post
	 *
	 * @param string $base Class name to be applied
	 * @param int $limit A flag to limit the number of terms
	 * @param bool $text A flag to return an HTML list or plan text list
	 * @param bool $echo A flag to return or echo
	 * @param string $item show category or tags
	 * @param bool $show_title Flag to display a title
	 *
	 * @return string
	 */
	public static function get_post_items(
		string $base,
		int $limit,
		bool $text = false,
		bool $echo = false,
		string $item = 'categories',
		bool $show_title = false
	): string {
		$types = get_the_category();
		if ( $item === 'tags' ) {
			$types = get_the_tags();
		}
		$rtn = '';
		$i   = 0;
		if ( ! empty( $types ) ) {
			if ( false === $text ) {
				if ( true === $show_title ) {
					$rtn .= '<h6 class="' . esc_attr( $base ) . '__categories__header">' . $item . '</h6>';
				}
				$rtn .= '<ul class="' . esc_attr( $base ) . '__categories">';
				foreach ( $types as $type ) {
					if ( $i < $limit ) {
						/* Translators: %s: Alt tag of each category */
						$rtn .=
							'<li class="' . esc_attr( $base ) . '__category">';
						/* translators: %s: cat term */
						$rtn .= esc_html( $type->name );

						$rtn .= '</li>';
						++ $i;
					}
				}
				$rtn .= '</ul>';
				if ( false === $echo ) {
					return $rtn;
				}
				echo wp_kses_post( trim( $rtn ) );
			} else {
				$cats = [];
				foreach ( $types as $type ) {
					if ( $i < $limit ) {
						$cats = $type->slug;
						++ $i;
					}
				}

				if ( false === $echo ) {
					return $cats;
				}

				$allowed_html = [
					'ul' => [
						'class' => true,
					],
					'li' => [
						'class' => true,
					],
				];
				echo wp_kses( $cats, $allowed_html );
			}
		}

		return '';
	}

	/**
	 * Displays a logo and wraps it in a link
	 *
	 * @param string $base Class name to be applied
	 * @param bool $echo option to echo or return
	 *
	 * @return string
	 */
	public static function display_logo(
		string $base,
		bool $echo = false
	): string {
		$rtn =
			'<a class="' .
			$base .
			'__logo-link" href="' .
			get_bloginfo( 'url' ) .
			'" aria-label="Company logo">';
		$rtn .=
			'<svg  viewBox="0 0 177 33" fill="none"
					 xmlns="http://www.w3.org/2000/svg">
					<g clip-path="url(#clip0_2_1952)">
						<path d="M21.4789 11.5859H12.7893V16.5514H21.4789V11.5859Z" />
						<path
							d="M20.4172 11.5861C20.4607 11.989 20.4879 12.4027 20.4879 12.8329C20.4879 17.4716 17.4608 21.0215 12.724 21.0215C7.98719 21.0215 4.96001 17.733 4.96001 12.8329C4.96001 7.93275 8.14509 4.64422 12.724 4.64422C15.4027 4.64422 17.5533 5.71136 18.909 7.54074L23.7656 5.90736C21.6749 2.20505 17.7711 0 12.7185 0C5.22135 0 0 5.18868 0 12.8329C0 20.477 5.11246 25.6657 12.7185 25.6657C20.3246 25.6657 25.4371 20.1068 25.4371 12.8329C25.4371 12.4082 25.4207 11.9944 25.3935 11.5861H20.4172Z"
							/>
						<path d="M73.5072 11.5859H64.8177V16.5514H73.5072V11.5859Z"
						/>
						<path
							d="M72.4401 11.5861C72.4837 11.989 72.5109 12.4028 72.5109 12.8329C72.5109 17.4717 69.4837 21.0216 64.7469 21.0216C60.0101 21.0216 56.9829 17.7331 56.9829 12.8329C56.9829 7.93282 60.168 4.6443 64.7469 4.6443C67.4256 4.6443 69.5763 5.71143 70.9319 7.54081L75.7885 5.90744C73.7032 2.20513 69.7995 -0.00537109 64.7469 -0.00537109C57.2497 -0.00537109 52.0284 5.18331 52.0284 12.8275C52.0284 20.4717 57.1408 25.6604 64.7469 25.6604C72.353 25.6604 77.4654 20.1014 77.4654 12.8275C77.4654 12.4028 77.4491 11.989 77.4219 11.5807H72.4455L72.4401 11.5861Z"
							/>
						<path
							d="M80.7757 12.8656C80.7757 9.09249 81.9027 6.02175 84.1622 3.64791C86.4217 1.27408 89.5796 0.0871582 93.6303 0.0871582C95.0187 0.0871582 96.2927 0.228717 97.4633 0.511835C98.6285 0.794953 99.5867 1.16518 100.333 1.62797C101.079 2.09076 101.737 2.59711 102.314 3.14701C102.892 3.69691 103.327 4.2577 103.621 4.82394C103.915 5.39017 104.16 5.90196 104.351 6.36475C104.541 6.82754 104.667 7.19777 104.716 7.48089L104.792 7.90557H101.83C101.803 7.75312 101.759 7.55167 101.694 7.30667C101.628 7.06166 101.411 6.63154 101.04 6.0163C100.67 5.40106 100.213 4.85116 99.6738 4.36115C99.1348 3.87658 98.3345 3.43557 97.2673 3.05445C96.2002 2.66789 94.9915 2.47733 93.6303 2.47733C90.369 2.47733 87.8918 3.47913 86.1985 5.47729C84.5052 7.48089 83.6559 9.94184 83.6559 12.871C83.6559 15.8002 84.5216 18.1577 86.2529 20.1831C87.9843 22.2085 90.4398 23.2266 93.6249 23.2266C95.0623 23.2266 96.3472 22.9816 97.4742 22.497C98.6012 22.0125 99.4996 21.3537 100.169 20.5315C100.839 19.7094 101.351 18.8492 101.71 17.9508C102.069 17.0525 102.287 16.1269 102.363 15.1795H93.7392V12.871H105.211V13.4481C105.211 14.9617 105.01 16.4318 104.612 17.8583C104.215 19.2847 103.567 20.5914 102.668 21.7838C101.77 22.9762 100.545 23.9126 98.9933 24.5932C97.4416 25.2738 95.6503 25.6113 93.6249 25.6113C89.7211 25.6113 86.6068 24.4244 84.2711 22.0506C81.9354 19.6767 80.7703 16.6169 80.7703 12.871L80.7757 12.8656Z"
							/>
						<path
							d="M109.409 7.90015V11.1342C110.383 8.97817 112.038 7.90015 114.374 7.90015H116.917V10.2086H114.45C112.501 10.2086 111.2 10.7858 110.541 11.94C109.888 13.0943 109.545 15.136 109.523 18.0597V25.2193H106.866V7.90015H109.409Z"
							/>
						<path
							d="M118.959 10.056C120.652 8.36278 122.922 7.51343 125.77 7.51343C128.617 7.51343 130.888 8.36278 132.581 10.056C134.274 11.7493 135.123 13.9162 135.123 16.5623C135.123 19.2084 134.285 21.4407 132.603 23.1067C130.92 24.7727 128.644 25.6112 125.77 25.6112C122.895 25.6112 120.652 24.7727 118.959 23.0904C117.265 21.408 116.416 19.2356 116.416 16.5678C116.416 13.8999 117.265 11.7548 118.959 10.0615V10.056ZM119.149 16.5623C119.149 18.6421 119.748 20.3082 120.94 21.5659C122.133 22.8236 123.744 23.4497 125.77 23.4497C127.795 23.4497 129.374 22.8236 130.583 21.5659C131.791 20.3082 132.39 18.6421 132.39 16.5623C132.39 14.4825 131.791 12.8818 130.599 11.5969C129.407 10.3119 127.795 9.66948 125.77 9.66948C123.744 9.66948 122.165 10.3119 120.957 11.5969C119.748 12.8818 119.149 14.5369 119.149 16.5623Z"
							/>
						<path
							d="M136.392 17.7548V7.90015H139.049V17.7548C139.049 19.7312 139.457 21.1577 140.28 22.0288C141.102 22.9 142.321 23.3355 143.938 23.3355C145.555 23.3355 146.818 22.7911 147.809 21.7021C148.795 20.6132 149.29 18.9744 149.29 16.7966V7.90015H151.947V25.2248H149.405V21.9145C148.942 22.9435 148.229 23.8146 147.27 24.5333C146.307 25.252 145.158 25.6114 143.824 25.6114C141.309 25.6114 139.441 24.9689 138.221 23.684C137.002 22.3991 136.392 20.4227 136.392 17.7548Z"
							/>
						<path
							d="M154.37 7.89999H156.913V10.7094C158.475 8.58056 160.659 7.51343 163.457 7.51343C166.256 7.51343 168.531 8.35189 170.138 10.0343C171.744 11.7166 172.544 13.9162 172.544 16.6385C172.544 19.3608 171.744 21.5659 170.138 23.1829C168.531 24.8 166.397 25.6058 163.729 25.6058H163.228C160.664 25.5295 158.595 24.4896 157.033 22.486V32.2645H154.376V7.89999H154.37ZM156.913 16.5623C156.913 18.5387 157.474 20.183 158.59 21.4897C159.706 22.7964 161.252 23.4551 163.228 23.4551C165.205 23.4551 166.762 22.829 167.982 21.5713C169.201 20.3136 169.811 18.6694 169.811 16.644C169.811 14.4879 169.207 12.7892 168.003 11.5424C166.795 10.2956 165.205 9.67492 163.228 9.67492C161.252 9.67492 159.706 10.3119 158.59 11.5805C157.474 12.8491 156.913 14.5152 156.913 16.5678V16.5623Z"
							/>
						<path
							d="M172.038 1.11607C172.55 0.604284 173.17 0.348389 173.894 0.348389C174.618 0.348389 175.234 0.604284 175.746 1.11607C176.252 1.62786 176.508 2.24855 176.508 2.97267C176.508 3.6968 176.252 4.30115 175.74 4.81294C175.228 5.32473 174.613 5.58063 173.9 5.58063C173.187 5.58063 172.555 5.32473 172.043 4.81294C171.531 4.30115 171.276 3.68591 171.276 2.97267C171.276 2.25943 171.531 1.62786 172.043 1.11607H172.038ZM171.684 2.97267C171.684 3.58247 171.896 4.0997 172.326 4.53527C172.751 4.96539 173.274 5.18317 173.894 5.18317C174.515 5.18317 175.021 4.96539 175.457 4.53527C175.887 4.10515 176.105 3.58247 176.105 2.97267C176.105 2.36288 175.887 1.82387 175.457 1.3883C175.027 0.952737 174.504 0.729509 173.894 0.729509C173.285 0.729509 172.751 0.947292 172.326 1.3883C171.902 1.82387 171.684 2.35199 171.684 2.97267ZM172.931 4.28482V1.53531H174.02C174.352 1.53531 174.608 1.61153 174.787 1.76942C174.967 1.92187 175.059 2.12876 175.059 2.38466C175.059 2.695 174.923 2.92912 174.646 3.08701C174.858 3.14146 174.967 3.27757 174.967 3.5008V4.28482H174.58V3.5008C174.58 3.31024 174.499 3.21224 174.341 3.21224H173.317V4.28482H172.931ZM173.317 1.86743V2.89101H174.02C174.221 2.89101 174.379 2.842 174.493 2.74945C174.608 2.65144 174.662 2.53166 174.662 2.37922C174.662 2.03621 174.45 1.86743 174.02 1.86743H173.317Z"
							/>
						<path d="M49.9104 0.500977H44.9667V10.3883H49.9104V0.500977Z" />
						<path d="M32.6076 0.500977H27.6639V10.3883H32.6076V0.500977Z" />
						<path
							d="M32.6076 25.2247V15.9689C32.6076 15.6204 32.8907 15.3373 33.2391 15.3373H44.3352C44.6836 15.3373 44.9668 15.6204 44.9668 15.9689V25.2247H49.9104V16.1104C49.9104 15.615 49.7144 15.1413 49.3605 14.7874L44.9613 10.3882H32.6021L28.2029 14.8037C27.8545 15.1522 27.6584 15.6313 27.6584 16.1213V25.2192H32.6021L32.6076 25.2247Z"
							/>
						<path
							d="M34.8779 30.811C35.0848 30.811 35.0848 30.4897 34.8779 30.4897C34.6711 30.4897 34.6711 30.811 34.8779 30.811Z"
							/>
					</g>
					<defs>
						<clipPath id="clip0_2_1952">
							<rect width="176.502" height="32.27"/>
						</clipPath>
					</defs>
				</svg>';
		$rtn .= '</a>';
		if ( false === $echo ) {
			return $rtn;
		}
		echo $rtn;

		return '';
	}

	/** Checks which options have been set for the block and applies a corresponding class which can be used for styling
	 *
	 * @param array $options_array Options set for the block
	 * @param array $options Options set for the block via ACF
	 */
	public static function apply_classes( array $options_array, array $options ): void {
		$class = [ '' ];
		// Loops the array and echos out the class name
		foreach ( $options_array as $key => $op ) {
			if ( isset( $options[ $op[0] ] ) && $options[ $op[0] ] ) {
				// Applies selected ACF option class if $op[2] = true
				if ( isset( $op[2] ) ) {
					$class[] = $op[1] . '-' . str_replace( '_', '-', strtolower( $options[ $op[0] ] ) );
				} else {
					$class[] = str_replace( '_', '-', $op[1] );
				}
			}
		}
		echo esc_attr( implode( ' ', $class ) );
	}


	/** This function is used to add a Google Maps API key to ACF
	 *
	 * @param $api
	 *
	 * @return mixed
	 */
	public static function my_acf_google_map_api( $api ) {
		$API_KEY    = get_field( 'google_maps_API_key', 'options' );
		$api['key'] = $API_KEY;

		return $api;
	}

}
