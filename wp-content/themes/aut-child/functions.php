<?php
/* Function to enqueue stylesheet from parent theme */

function my_theme_enqueue_styles(): void {
	$styles = [
		'parent-style' => [
			'handle' => 'parent-style',
			'uri'    => get_template_directory_uri() . '/dist/css/style.css',
			'path'   => get_template_directory() . '/dist/css/style.css',
		],
		'child-style'  => [
			'handle' => 'child-style',
			'uri'    => get_stylesheet_directory_uri() . '/style.css',
			'path'   => get_template_directory() . '/dist/css/style.css',
			'deps'   => 'parent-style',
		],
	];

// Enqueue styles
	enqueue_asset( $styles['parent-style'], 'style' );
	enqueue_asset( $styles['child-style'], 'style' );


	$scripts = [
		'theme-js'              => [
			'handle'    => 'theme-js',
			'uri'       => get_template_directory_uri() . '/dist/js/scripts.js',
			'path'      => get_template_directory() . '/dist/js/scripts.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'news_&_media'          => [
			'handle'    => 'news_&_media',
			'uri'       =>
				get_template_directory_uri() . '/dist/js/news-and-events.js',
			'path'      => get_template_directory() . '/dist/js/news-and-events.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'series-categories'     => [
			'handle'    => 'series-categories',
			'uri'       =>
				get_template_directory_uri() . '/dist/js/series-categories.js',
			'path'      =>
				get_template_directory() . '/dist/js/series-categories.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'AUT_products'          => [
			'handle'    => 'AUT_products',
			'uri'       => get_template_directory_uri() . '/dist/js/AUT-products.js',
			'path'      => get_template_directory() . '/dist/js/AUT-products.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'product-innovation'    => [
			'handle'    => 'product-innovation',
			'uri'       =>
				get_template_directory_uri() . '/dist/js/product-innovation.js',
			'path'      =>
				get_template_directory() . '/dist/js/product-innovation.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'single-product-toggle' => [
			'handle'    => 'single-product-toggle',
			'uri'       =>
				get_template_directory_uri() .
				'/dist/js/single-product-toggle.js',
			'path'      =>
				get_template_directory() . '/dist/js/single-product-toggle.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'tax-products'          => [
			'handle'    => 'tax-products',
			'uri'       => get_template_directory_uri() . '/dist/js/tax-products.js',
			'path'      => get_template_directory() . '/dist/js/tax-products.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
		'series'                => [
			'handle'    => 'series',
			'uri'       => get_template_directory_uri() . '/dist/js/series.js',
			'path'      => get_template_directory() . '/dist/js/series.js',
			'deps'      => [],
			'strategy'  => 'async',
			'in-footer' => true,
		],
	];

	// Enqueue scripts
	enqueue_asset( $scripts['theme-js'], 'script' );


	if ( is_product() ) {
		enqueue_asset( $scripts['single-product-toggle'], 'script' );
	}
	if ( is_archive() ) {
		enqueue_asset( $scripts['tax-products'], 'script' );
	}

	if ( is_tax( 'categories' ) || is_tax( 'industry' ) ) {
		enqueue_asset( $scripts['series'], 'script' );
	}


	if (
		function_exists( 'have_rows' ) &&
		function_exists( 'get_row_layout' ) &&
		function_exists( 'get_template_part' )
	) {

		$components = [
			'news_&_media',
			'AUT_products',
			'series'
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


add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );

function modify_posts_clauses_for_taxonomy_sort( $clauses, $query ) {
	global $wpdb;

	// Check if this is the main query and the custom sorting is required
	if (
		! is_admin() &&
		$query->is_main_query() &&
		$query->get( 'orderby' ) === 'pa_series'
	) {
		$clauses['join']    .= "
            LEFT JOIN {$wpdb->term_relationships} AS tr ON {$wpdb->posts}.ID = tr.object_id
            LEFT JOIN {$wpdb->term_taxonomy} AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            LEFT JOIN {$wpdb->terms} AS t ON tt.term_id = t.term_id
        ";
		$clauses['where']   .= " AND tt.taxonomy = 'pa_series'";
		$clauses['orderby'] = 't.name ASC';
	}

	return $clauses;
}

add_filter( 'posts_clauses', 'modify_posts_clauses_for_taxonomy_sort', 10, 2 );

