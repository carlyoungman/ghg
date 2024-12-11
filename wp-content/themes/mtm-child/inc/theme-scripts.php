<?php
/*==================================
|	Theme Scripts & Styles
==================================*/

// Load theme stylesheets
function yr_load_styles() {

	$styles        = get_stylesheet_directory_uri() . '/dist/assets/css/main.min.css';
	$stylesVersion = filemtime( get_stylesheet_directory() . '/dist/assets/css/main.min.css' );

	// Remove gutenberg styles
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS


	wp_enqueue_style( 'yeahright-theme-styles', $styles, null, $stylesVersion );

	// Google Font(s)
	wp_enqueue_style( 'google-font-api', 'https://fonts.googleapis.com' );
	wp_enqueue_style( 'google-font-static', 'https://fonts.gstatic.com' );
	wp_enqueue_style( 'google-font-dmsans', 'https://fonts.googleapis.com/css2?family=DM+Sans:opsz@9..40&display=swap' );
}

add_action( 'wp_enqueue_scripts', 'yr_load_styles' );


// Preconnect filter
add_filter( 'style_loader_tag', 'yr_style_preconnect', 10, 2 );


function yr_style_preconnect( $html, $handle ) {
	if ( $handle === 'google-font-api' || $handle === 'google-font-static' ) {
		$filtered = str_replace( $handle . '-css', $handle, $html );
		$filtered = str_replace( "rel='stylesheet'", "rel='preconnect'", $html );
		$filtered = str_replace( "type='text/css'", "", $filtered );
		$filtered = str_replace( "media='all'", "", $filtered );

		return $filtered;
	}

	return $html;
}


// Load theme scripts
function yr_load_scripts() {

	// Get google maps api key (set in theme options)
	global $prefix;
	$key = ( isset( get_field( $prefix . 'additional', 'option' )['maps_key'] ) ) ? get_field( $prefix . 'additional', 'option' )['maps_key'] : false;


	if ( $key ) {
		wp_enqueue_script( 'Yeahright-GoogleMaps', 'https://maps.googleapis.com/maps/api/js?key=' . $key . '&callback=gmNoop', null, false, array(
			'in_footer' => false,
			'strategy'  => 'async',
		) );
	}

	$scripts        = get_stylesheet_directory_uri() . '/dist/assets/js/main.js';
	$scriptsVersion = filemtime( get_stylesheet_directory() . '/dist/assets/js/main.js' );

	wp_enqueue_script( 'Yeahright-Scripts', $scripts, null, $scriptsVersion, true );
}

add_action( 'wp_enqueue_scripts', 'yr_load_scripts' );
