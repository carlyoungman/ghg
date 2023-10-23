<?php
/**
 * Abstract Class AbstractComponent
 *
 * Abstract component class for flieters and actions
 *
 * @package BOILERPLATE_THEME
 */

namespace BOILERPLATE_THEME;

use BOILERPLATE_THEME\Concerns\PluginDetail;
use BOILERPLATE_THEME\Interfaces\ComponentInterface;

/**
 * Class AbstractComponent
 *
 * @package BOILERPLATE_THEME
 */
abstract class AbstractComponent implements ComponentInterface {


	use PluginDetail;

	/**
	 * AbstractComponent constructor.
	 * Check if the required plugin is installed and then run all hook methods
	 */
	public function __construct() {
		if ( self::is_plugin_enabled() ) {

			$this->remove_filters();
			$this->remove_actions();

			$this->add_filters();
			$this->add_actions();

			$this->general_config();
			$this->theme_support();
		}
	}

	/**
	 * Remove filters
	 *
	 * @return void
	 */
	public function remove_filters(): void {
	}

	/**
	 * Remove actions
	 *
	 * @return void
	 */
	public function remove_actions(): void {
	}

	/**
	 * Add filters
	 *
	 * @return void
	 */
	public function add_filters(): void {
	}

	/**
	 * Add actions
	 *
	 * @return void
	 */
	public function add_actions(): void {
	}

	/**
	 * General config
	 *
	 * @return void
	 */
	public function general_config(): void {
	}

	/**
	 * Theme support
	 *
	 * @return void
	 */
	public function theme_support(): void {

	}
}
