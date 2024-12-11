<?php
/**
 * Class Script
 *
 * Enqueue all Javascript requirements
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Script
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Script
{
	/**
	 * list all front end scripts as named arrays: uri, deps, in-footer
	 */
	public const FRONTEND = [
		'theme-js' => ['uri' => '/dist/js/scripts.js'],
	];

	/**
	 * Enqueue Scripts
	 */
	public static function register(): void
	{
		self::enqueue_frontend();
	}

	/**
	 * Enqueue front end scripts
	 */
	private static function enqueue_frontend(): void
	{
		foreach (self::FRONTEND as $handle => $script) {
			// Fail if there's no URI
			if (!isset($script['uri']) || empty($script['uri'])) {
				continue;
			}

			// Define values
			$script_handle = BOILERPLATE_NAMESPACE . '_' . $handle;
			$script_path = BOILERPLATE_THEME_PATH . $script['uri'];
			$script_uri = BOILERPLATE_THEME_URL . $script['uri'];

			// Fail if the script is missing
			if (false === file_exists($script_path)) {
				continue;
			}

			// Use modification time as a version number
			$mtime = filemtime($script_path);

			// Register the script
			wp_register_script(
				$script_handle,
				$script_uri,
				$script['deps'] ?? [],
				$mtime,
				$script['in-footer'] ?? true
			);

			// Attach meta data
			wp_localize_script($script_handle, 'ajax_params', [
				'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php',
				'ajaxNonce' => wp_create_nonce('ajax_nonce'),
			]);

			// Enqueue the script
			wp_enqueue_script($script_handle);
		}

		// enqueue comment scripts if comments are open
		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}
}
