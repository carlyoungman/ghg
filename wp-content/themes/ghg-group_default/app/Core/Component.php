<?php
/**
 * Class Bootstrap
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core;

use BOILERPLATE_THEME\AbstractComponent;
use BOILERPLATE_THEME\Core\Module\ACF;
use BOILERPLATE_THEME\Core\Module\Ajax;
use BOILERPLATE_THEME\Core\Module\Customizer;
use BOILERPLATE_THEME\Core\Module\CustomPostType;
use BOILERPLATE_THEME\Core\Module\Head;
use BOILERPLATE_THEME\Core\Module\Menu;
use BOILERPLATE_THEME\Core\Module\Script;
use BOILERPLATE_THEME\Core\Module\Style;
use BOILERPLATE_THEME\Core\Module\Taxonomy;
use BOILERPLATE_THEME\Core\Module\Template;

/**
 * Class Component
 *
 * @package BOILERPLATE_THEME\Core
 */
class Component extends AbstractComponent {


	/**
	 * all remove_filter hooks
	 */
	public function remove_filters(): void {
		// Removed a load of crap from the footer
		remove_filter( 'render_block', 'wp_render_duotone_support' );
		remove_filter( 'render_block', 'wp_restore_group_inner_container' );
		remove_filter( 'render_block', 'wp_render_layout_support_flag' );
	}

	/**
	 * All add_filter hooks
	 */
	public function add_filters(): void {
		// Template
		add_filter( 'body_class', [ Template::class, 'body_classes' ] );

		add_filter( 'wpcf7_autop_or_not', '__return_false' );

		add_filter( 'acf/fields/google_map/api', [ Template::class, 'my_acf_google_map_api' ] );

	}


	/**
	 * All remove_actions hooks
	 */
	public function remove_actions(): void {
		// remove SVG and global styles
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
		// remove wp_footer actions which adds global inline styles
		remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
		// Remove unwanted SVG filter injection WP
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		// Remove spacing from the gallery block
		remove_action( 'init', 'register_block_core_gallery' );
	}


	/**
	 * All add_action hooks
	 */
	public function add_actions(): void {
		// Register all Custom Post Types
		add_action( 'init', [ CustomPostType::class, 'register' ] );
		// Register all Custom Taxonomies
		add_action( 'init', [ Taxonomy::class, 'register' ] );
		// Register all ACF components
		add_action( 'init', [ ACF::class, 'flexible_components' ] );
		add_action( 'init', [ ACF::class, 'theme_settings' ] );
		add_action( 'init', [ ACF::class, 'header_settings' ] );
		// Customizer
		add_action( 'customize_register', [ Customizer::class, 'register' ] );
		// Script
		add_action( 'wp_enqueue_scripts', [ Script::class, 'register' ] );
		// Style
		add_action( 'wp_enqueue_scripts', [ Style::class, 'register' ] );
		// Head
		add_action( 'wp_head', [ Head::class, 'register' ], 1 );
		add_action( 'admin_menu', [ Menu::class, 'change_post_menu_label' ] );
		add_action( 'admin_menu', [ Menu::class, 'change_post_object_label' ] );

		add_action(
			'before_delete_post',
			[ Customizer::class, 'restrict_page_deletion' ],
			10,
			1
		);
		add_action(
			'wp_trash_post',
			[ Customizer::class, 'restrict_page_deletion' ],
			10,
			1
		);

		add_action( 'wp_ajax_nopriv_get_news_and_events_filters', [
			Ajax::class,
			'get_news_and_events_filters_handler'
		] );
		add_action( 'wp_ajax_get_news_and_events_filters', [ Ajax::class, 'get_news_and_events_filters_handler' ] );

		add_action( 'wp_ajax_nopriv_get_news_and_events', [ Ajax::class, 'get_news_and_events_handler' ] );
		add_action( 'wp_ajax_get_news_and_events', [ Ajax::class, 'get_news_and_events_handler' ] );


	}

	/**
	 * General theme config and settings
	 */
	public function general_config(): void {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on _s, use a find and replace
		 * to change 'boilerplate-theme' to the name of your theme in all the template files.
		 */
		load_theme_textdomain(
			BOILERPLATE_NAMESPACE,
			get_template_directory() . '/languages'
		);
		/**
		 * Register all theme nav menus from the Menu class
		 */
		register_nav_menus( Menu::register() );


		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @global int $content_width
		 */
		$GLOBALS['content_width'] = apply_filters( 'content_width', 720 );
		/**
		 *  Remove image sizes
		 */
		add_filter(
			'intermediate_image_sizes',
			function ( $sizes ) {
				return array_diff(
					$sizes,
					[
						'medium_large',
						'1536x1536',
						'2048x2048',
					]
				);
			}
		);
		/**
		 *  add image sizes
		 */
		add_image_size( 'hero', '1920', '' );
		add_image_size( 'small', '578', '578' );
		add_image_size( 'x-large', '1200', '1200' );
		add_image_size( 'xx-large', '1400', '1400' );
		add_image_size( 'xxx-large', '1600', '1600' );

		/**
		 *  ACF options page
		 */
		if ( function_exists( 'acf_add_options_page' ) ) {
			acf_add_options_page(
				[
					'page_title' => 'Theme General Settings',
					'menu_title' => 'Theme Settings',
					'menu_slug'  => 'theme-general-settings',
					'capability' => 'edit_posts',
					'redirect'   => false,
				]
			);
		}
	}

	/**
	 * all theme_support hooks
	 */
	public function theme_support(): void {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );
		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );
		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			]
		);
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );
	}

}




