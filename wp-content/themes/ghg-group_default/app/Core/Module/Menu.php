<?php
/**
 * Class Menu
 *
 * A class for registering navigation menus
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Menu
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Menu {


	/**
	 * Retrieves menu instance
	 *
	 * @return array
	 */
	public static function register(): array {
		return [
			'primary'     => esc_html__(
				'Primary Navigation',
				'boilerplate-theme'
			),
			'mobile'      => esc_html__(
				'Mobile Navigation',
				'boilerplate-theme'
			),
			'our-brands'  => esc_html__(
				'Our brands',
				'boilerplate-theme'
			),
			'our-company' => esc_html__(
				'Our company',
				'boilerplate-theme'
			),
			'legal'       => esc_html__(
				'legal',
				'boilerplate-theme'
			),

		];
	}

	/**
	 * This function is used to change the menu label of posts
	 *
	 * @return void
	 */
	public static function change_post_menu_label(): void {
		global $menu;
		global $submenu;
		$menu_text                  = 'News & Media';
		$menu[5][0]                 = $menu_text;
		$submenu['edit.php'][5][0]  = 'All ' . $menu_text;
		$submenu['edit.php'][10][0] = 'Add new';
		$submenu['edit.php'][16][0] = 'Tags';
		echo '';
	}

	/**
	 * This function is used to change the object label of posts
	 *
	 * @return void
	 */
	public static function change_post_object_label(): void {
		global $wp_post_types;
		$menu_text                  = 'News & Media';
		$labels                     = &$wp_post_types['post']->labels;
		$labels->name               = $menu_text;
		$labels->singular_name      = $menu_text;
		$labels->add_new            = 'Add New ';
		$labels->add_new_item       = 'Add New';
		$labels->edit_item          = 'Edit ' . $menu_text;
		$labels->new_item           = $menu_text;
		$labels->view_item          = 'View ' . $menu_text;
		$labels->search_items       = 'Search ' . $menu_text;
		$labels->not_found          = 'No ' . $menu_text . ' found';
		$labels->not_found_in_trash = 'No ' . $menu_text . ' found in Trash';
	}
}
