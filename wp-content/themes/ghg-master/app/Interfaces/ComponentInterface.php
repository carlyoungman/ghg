<?php
/**
 * Interface ComponentInterface
 *
 * @package BOILERPLATE_THEME\Interfaces
 */

namespace BOILERPLATE_THEME\Interfaces;

/**
 * Interface ComponentInterface
 *
 * @package BOILERPLATE_THEME\Interfaces
 */
interface ComponentInterface {

	/**
	 * Remove filters
	 *
	 * @return void
	 */
	public function remove_filters(): void;

	/**
	 * Remove actions
	 *
	 * @return void
	 */
	public function remove_actions(): void;

	/**
	 * Add filters
	 *
	 * @return void
	 */
	public function add_filters(): void;

	/**
	 * Add actions
	 *
	 * @return void
	 */
	public function add_actions(): void;

	/**
	 * General config
	 *
	 * @return void
	 */
	public function general_config(): void;

	/**
	 * Theme support
	 *
	 * @return void
	 */
	public function theme_support(): void;
}
