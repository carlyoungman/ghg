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
use BOILERPLATE_THEME\Core\Module\Woocommerce;

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

		//		add_filter(
		//			'admin_body_class',
		//			[Template::class, 'admin_body_classes'],
		//		);

		add_filter( 'wpcf7_autop_or_not', '__return_false' );

		add_filter( 'acf/fields/google_map/api', [
			Template::class,
			'my_acf_google_map_api',
		] );

		add_filter( 'wpseo_breadcrumb_links', [
			Template::class,
			'yoast_seo_breadcrumb_append_links',
		] );


		add_filter( 'woocommerce_ga_gtag_consent_modes', function ( $consent_modes ) {
			$consent_modes[] =
				array(
					'analytics_storage' => 'granted',
					'region'            => array( 'GB' ),
				);

			return $consent_modes;
		} );

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

		remove_action(
			'woocommerce_single_product_summary',
			'woocommerce_template_single_price',
			10
		);
		remove_action(
			'woocommerce_after_single_product_summary',
			'woocommerce_output_related_products',
			20
		);
	}

	/**
	 * Registers all actions for the plugin.
	 *
	 * @return void
	 */
	public function add_actions(): void {
		// Register common actions for all sites
		add_action( 'init', [ CustomPostType::class, 'register' ] );
		add_action( 'init', [ Taxonomy::class, 'register' ] );
		add_action( 'init', [ ACF::class, 'flexible_components' ] );
		add_action( 'init', [ ACF::class, 'theme_settings' ] );
		add_action( 'init', [ ACF::class, 'page_settings' ] );
		add_action( 'init', [ ACF::class, 'mega_menu' ] );

// Actions specific to blog ID 6
		if ( 6 == get_current_blog_id() ) {
			$acf_actions_blog_6 = [
				'series',
				'additional_information',
				'products_media',
				'products',
				'product_call_to_actions',
				'taxonomy_image',
				'hide_editor'
			];

			foreach ( $acf_actions_blog_6 as $action ) {
				add_action( 'init', [ ACF::class, $action ] );
			}
		}

// Actions specific to blog IDs 5 and 7
		if ( in_array( get_current_blog_id(), [ 5, 7 ] ) ) {
			$acf_actions_blog_5_7 = [
				'case_studies',
				'product_settings',
				'product_categories',
				'hide_editor_benchmaster'
			];

			foreach ( $acf_actions_blog_5_7 as $action ) {
				add_action( 'init', [ ACF::class, $action ] );
			}
		}

// Actions specific to blog ID 1
		if ( 1 == get_current_blog_id() ) {
			$acf_actions_blog_1 = [
				'header_settings',
				'hide_editor'
			];

			foreach ( $acf_actions_blog_1 as $action ) {
				add_action( 'init', [ ACF::class, $action ] );
			}
		}


		// Customizer
		add_action( 'customize_register', [ Customizer::class, 'register' ] );
		// Script
		add_action( 'wp_enqueue_scripts', [ Script::class, 'register' ] );
		// Styles
		add_action( 'wp_enqueue_scripts', [ Style::class, 'register' ] );

		add_action( 'admin_enqueue_scripts', [ Style::class, 'register_backend' ] );

		// Head
		add_action( 'wp_head', [ Head::class, 'register' ], 1 );

		add_action( 'admin_menu', [ Menu::class, 'change_post_menu_label' ] );
		add_action( 'admin_menu', [ Menu::class, 'change_post_object_label' ] );

		$hooks = [ 'before_delete_post', 'wp_trash_post' ];

		foreach ( $hooks as $hook ) {
			add_action( $hook, [ Customizer::class, 'restrict_page_deletion' ], 10, 1 );
		}

		$ajax_actions = [
			'get_news_and_events_filters' => 'get_news_and_events_filters_handler',
			'get_news_and_events'         => 'get_news_and_events_handler',
			'get_series'                  => 'get_series_handler',
			'get_product_categories'      => 'get_product_categories_handler',
			'get_aut_products'            => 'get_products_aut_handler',
			'get_products'                => 'get_products_handler',
			'get_tax_products'            => 'get_tax_products_handler',
			'get_case_studies'            => 'get_case_studies_handler',
			'get_sector'                  => 'get_sectors_handler',
			'get_product_innovation'      => 'get_product_innovation_handler',
			'get_product_filters'         => 'get_product_filters_handler',
			'get_series_categories'       => 'get_series_categories_handler'
		];

		foreach ( $ajax_actions as $action => $handler ) {
			add_action( "wp_ajax_nopriv_{$action}", [ Ajax::class, $handler ] );
			add_action( "wp_ajax_{$action}", [ Ajax::class, $handler ] );
		}


		$woocommerce_actions = [
			'woocommerce_after_single_product_summary' => [
				'custom_content_before_product_tabs',
				'show_product_testimonials',
				'show_related_products'
			],
			'woocommerce_single_product_summary'       => [
				'display_price_with_and_without_tax'
			],
			'init'                                     => [
				'disable_woocommerce_taxonomies'
			]
		];

		foreach ( $woocommerce_actions as $hook => $callbacks ) {
			foreach ( $callbacks as $callback ) {
				add_action( $hook, [ Woocommerce::class, $callback ], 10 );
			}
		}

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
		add_filter( 'intermediate_image_sizes', function ( $sizes ) {
			return array_diff( $sizes, [
				'medium_large',
				'1536x1536',
				'2048x2048',
			] );
		} );
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
			acf_add_options_page( [
				'page_title' => 'Theme General Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
			] );
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
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'woocommerce' );
	}
}
