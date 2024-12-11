<?php
/**
 * Class Bootstrap
 *
 * A bootstrap class for registering classes
 *
 * @package BOILERPLATE_THEME
 */

namespace BOILERPLATE_THEME;

use BOILERPLATE_THEME\Core\Component as Core;

/**
 * Class Bootstrap
 *
 * @package BOILERPLATE_THEME
 */
class Bootstrap {

	/**
	 * Bootstrap constructor.
	 * Check if the required plugin is installed and then run all hook methods
	 */
	public function __construct() {
		new Core();
	}
}
