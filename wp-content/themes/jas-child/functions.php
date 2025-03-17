<?php
/* Function to enqueue stylesheet from parent theme */

function my_theme_enqueue_assets(): void {
	$styles = [
		'parent-style' => [
			'handle' => 'parent-style',
			'uri'    => get_template_directory_uri() . '/dist/css/style.css',
			'path'   => get_template_directory() . '/dist/css/style.css',
		],
		'child-style'  => [
			'handle' => 'child-style',
			'uri'    => get_stylesheet_directory_uri() . '/style.css',
			'path'   => get_stylesheet_directory() . '/style.css',
			'deps'   => 'parent-style',
		],
	];

	// Enqueue styles
	enqueue_asset( $styles['parent-style'], 'style' );
	enqueue_asset( $styles['child-style'], 'style' );


	$scripts = [
		'theme-js'              => [
			'handle'    => 'theme-js',
			'uri'       => get_stylesheet_directory_uri() . '/dist/js/scripts.js',
			'path'      => get_stylesheet_directory() . '/dist/js/scripts.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'master-js'             => [
			'handle'    => 'master-js',
			'uri'       => get_template_directory_uri() . '/dist/js/scripts.js',
			'path'      => get_template_directory() . '/dist/js/scripts.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'news_&_media'          => [
			'handle'    => 'news_&_media',
			'uri'       => get_template_directory_uri() . '/dist/js/news-and-events.js',
			'path'      => get_template_directory() . '/dist/js/news-and-events.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'product_categories'    => [
			'handle'    => 'product_categories',
			'uri'       => get_template_directory_uri() . '/dist/js/product-categories.js',
			'path'      => get_template_directory() . '/dist/js/product-categories.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'products'              => [
			'handle'    => 'products',
			'uri'       => get_template_directory_uri() . '/dist/js/products.js',
			'path'      => get_template_directory() . '/dist/js/products.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'case_studies'          => [
			'handle'    => 'case_studies',
			'uri'       => get_template_directory_uri() . '/dist/js/case-studies.js',
			'path'      => get_template_directory() . '/dist/js/case-studies.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'sectors'               => [
			'handle'    => 'sectors',
			'uri'       => get_template_directory_uri() . '/dist/js/sectors.js',
			'path'      => get_template_directory() . '/dist/js/sectors.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'single-product-toggle' => [
			'handle'    => 'single-product-toggle',
			'uri'       => get_template_directory_uri() . '/dist/js/single-product-toggle.js',
			'path'      => get_template_directory() . '/dist/js/single-product-toggle.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'tax-products'          => [
			'handle'    => 'tax-products',
			'uri'       => get_template_directory_uri() . '/dist/js/tax-products.js',
			'path'      => get_template_directory() . '/dist/js/tax-products.js',
			'strategy'  => 'async',
			'in-footer' => true,
		],
	];
	// Enqueue scripts
	enqueue_asset( $scripts['master-js'], 'script' );
	enqueue_asset( $scripts['theme-js'], 'script' );


	if ( is_tax( 'product_cat' ) ) {
		enqueue_asset( $scripts['tax-products'], 'script' );
	}


	if (
		function_exists( 'have_rows' ) &&
		function_exists( 'get_row_layout' ) &&
		function_exists( 'get_template_part' )
	) {

		$components = [
			'news_&_media',
			'products',
		];
		$term       = get_queried_object();
		if ( have_rows( 'flexible', $term ) ) {
			while ( have_rows( 'flexible', $term ) ) {
				the_row();
				foreach ( $components as $component ) {
					if ( get_row_layout() === $component ) {
						if ( isset( $scripts[ $component ] ) ) {
							enqueue_asset( $scripts[ $component ], 'script' );
						}
					}
				}
			}
		}
	}
}

function enqueue_asset( array $asset, string $type ): void {
	$handle       = $asset['handle']; // Make sure to provide a 'handle' key in the asset array
	$asset_handle = BOILERPLATE_NAMESPACE . '_' . $handle;
	$asset_path   = $asset['path'];
	$asset_uri    = $asset['uri'];

	if ( empty( $asset_uri ) || ! file_exists( $asset_path ) ) {
		return; // Skip if URI is empty or file doesn't exist
	}

	$mtime = filemtime( $asset_path );

	if ( $type === 'style' ) {
		wp_enqueue_style(
			$asset_handle,
			$asset_uri,
			$asset['deps'] ?? [],
			$mtime,
			$asset['media'] ?? 'all',
		);
	} elseif ( $type === 'script' ) {
		wp_enqueue_script(
			$asset_handle,
			$asset_uri,
			$asset['deps'] ?? [],
			$mtime,
			$asset['in-footer'] ?? true
		);

		// Apply async or defer strategy
		if ( ! empty( $asset['strategy'] ) ) {
			$valid_strategies = [ 'async', 'defer' ];
			if ( in_array( $asset['strategy'], $valid_strategies, true ) ) {
				add_filter( 'script_loader_tag', function ( $tag, $handle ) use ( $asset_handle, $asset ) {
					if ( $handle === $asset_handle ) {
						return str_replace(
							'<script',
							'<script ' . esc_attr( $asset['strategy'] ),
							$tag
						);
					}

					return $tag;
				}, 10, 2 );
			}
		}

		// Localize script if enqueued
		if ( wp_script_is( $asset_handle, 'enqueued' ) ) {
			wp_localize_script( $asset_handle, 'ajax_params', [
				'ajaxurl'   => site_url() . '/wp-admin/admin-ajax.php',
				'ajaxNonce' => wp_create_nonce( 'ajax_nonce' ),
			] );
		}
	}
}


add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_assets' );

function my_theme_enqueue_admin_styles(): void {
	$admin_styles = [
		'admin-main-style' => [
			'uri'  => get_template_directory_uri() . '/dist/css/admin.css',
			'path' => get_template_directory() . '/dist/css/admin.css',
		],
	];

	foreach ( $admin_styles as $handle => $style ) {
		$style_handle = BOILERPLATE_NAMESPACE . '_' . $handle;
		$style_path   = $style['path'];
		$style_uri    = $style['uri'];

		if ( ! file_exists( $style_path ) ) {
			continue;
		}

		$mtime = filemtime( $style_path );
		wp_enqueue_style(
			$style_handle,
			$style_uri,
			[], // Dependencies
			$mtime
		);
	}
}

add_action( 'admin_enqueue_scripts', 'my_theme_enqueue_admin_styles' );

add_filter( 'woocommerce_ga_gtag_consent_modes', function ( $consent_modes ) {
	$consent_modes[] =
		array(
			'analytics_storage' => 'granted',
			'region'            => array( 'GB' ),
		);

	return $consent_modes;
} );

// Hide add to cart button
add_filter( 'woocommerce_is_purchasable', '__return_false' );
// Redirect cart page
add_action( 'template_redirect', 'disable_cart_page' );
function disable_cart_page() {
	if ( is_page( 'cart' ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

// Redirect checkout page
add_action( 'template_redirect', 'disable_checkout_page' );
function disable_checkout_page() {
	if ( is_page( 'checkout' ) ) {
		wp_redirect( home_url() );
		exit;
	}
}

// Remove the short description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );

// Add the full description
add_action( 'woocommerce_single_product_summary', 'display_full_product_description', 20 );

function display_full_product_description() {
	global $post;

	if ( $post->post_content ) {
		echo '<div class="woocommerce-product-details__long-description">';
		echo apply_filters( 'the_content', $post->post_content );
		echo '</div>';
	}
}
