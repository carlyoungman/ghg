<?php
/**
 * Trait HasAmpVersion
 *
 * @package BOILERPLATE_THEME\Concerns
 */

namespace BOILERPLATE_THEME\Concerns;

trait HasAmpVersion {
	/**
	 * Amp endpoint
	 *
	 * @return bool
	 */
	public static function is_amp_endpoint() {
		if ( function_exists( 'is_amp_endpoint' ) ) {
			return is_amp_endpoint();
		}

		return false;
	}
}
