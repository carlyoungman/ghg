<?php
/**
 * Main Theme Functions
 *
 * @package BOILERPLATE_THEME
 */

namespace BOILERPLATE_THEME;

use WP_Query;

/**
 * Autoload composer packages
 */
require_once __DIR__ . '/vendor/autoload.php';

define( 'BOILERPLATE_THEME_VERSION', '1.0.0' );
define( 'BOILERPLATE_NAMESPACE', 'boilerplate-theme' );
define( 'BOILERPLATE_THEME_NAME', 'Boilerplate Theme' );
define( 'BOILERPLATE_THEME_URL', get_stylesheet_directory_uri() );
define( 'BOILERPLATE_THEME_PATH', get_stylesheet_directory() );
define( 'BOILERPLATE_THEME_TRANSIENT_EXPIRATION', 60 );


new Bootstrap();


add_action(
	'wp_print_styles',
	function () {
		wp_dequeue_style( 'bootstrap' );
		wp_dequeue_style( 'proximanova-typekit' );
		wp_dequeue_style( 'normalize' );
		wp_dequeue_style( 'html5blank' );
		wp_dequeue_style( 'slick' );
		wp_dequeue_style( 'remodal' );
		wp_dequeue_style( 'remodal-default-theme' );
		wp_dequeue_style( 'csswow' );
		wp_dequeue_style( 'fd-slider' );
		wp_dequeue_style( 'animsitionscss' );
		wp_dequeue_style( 'niceselect' );
		wp_dequeue_style( 'wp-styles' );
		wp_dequeue_style( 'fontawesome-min' );
		wp_dequeue_style( 'cookieconsent' );
	}
);


