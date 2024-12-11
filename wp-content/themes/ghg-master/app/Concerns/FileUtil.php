<?php
/**
 * Trait FileUtil
 *
 * General use file utilities
 *
 * @package BOILERPLATE_THEME\Concerns
 */

namespace BOILERPLATE_THEME\Concerns;

trait FileUtil {

	/**
	 * Wrap PHP file_get_contents in a cache
	 *
	 * @param string $path the file path
	 * @param int $cache_time the output cache_time
	 *
	 * @return string
	 */
	public static function file_get_contents_cached( string $path, int $cache_time = 900 ): string {

		$rtn = '';

		$cache_key = md5(
		// phpcs:ignore
			serialize(
				[
					'url'        => $path,
					'cache_time' => $cache_time,
				]
			)
		);

		$cache = wp_cache_get( $cache_key );
		if ( false !== $cache ) {
			$rtn = $cache;
		} elseif ( false !== file_exists( $path ) ) {
			ob_start();
			readfile( $path );
			$file = ob_get_clean();
			if ( ! empty( $file ) ) {
				$rtn = $file;
				wp_cache_set( $cache_key, $rtn, '', absint( $cache_time ) ); // phpcs:ignore
			}
		}

		return $rtn;
	}

}
