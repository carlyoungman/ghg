<?php
/**
 * Trait PluginDetail
 *
 * @package BOILERPLATE_THEME\Concerns
 */

namespace BOILERPLATE_THEME\Concerns;

/**
 * Trait HasAmpVersion
 *
 * @package BOILERPLATE_THEME\Concerns
 */
trait PluginDetail {

	/**
	 * Must be a direct url to the plugin php file, so "plugin/plugin.php"
	 *
	 * @var string
	 */
	public static $plugin_url = '';

	/**
	 * Is the plugin outlined in the static $plugin actually available to use?
	 *
	 * @return bool
	 */
	public static function is_plugin_enabled(): bool {
		return empty( self::$plugin_url ) || in_array( static::$plugin_url, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	}

}
