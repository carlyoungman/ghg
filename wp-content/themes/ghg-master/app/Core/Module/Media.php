<?php
/**
 * Class Media
 *
 * A class for registering functions affecting media
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Media
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Media {

	/**
	 * Render an SVG from a relative path
	 *
	 * @param string $relative_path the relative path to an svg file
	 * @param int $width the output width
	 * @param int $height the output height
	 * @param array $config svg config array
	 *
	 * @return string
	 */
	public static function get_svg_from_relative_path(
		string $relative_path,
		int $width = 0,
		int $height = 0,
		array $config = []
	): string {
		$absolute_path = sprintf(
			'%s/img/%s.svg',
			get_template_directory(),
			$relative_path
		);

		return self::get_svg_from_path(
			$absolute_path,
			$width,
			$height,
			$config
		);
	}

	/**
	 * Render an SVG
	 *
	 * @param string $path the absolute path to the svg file
	 * @param int $width the output width
	 * @param int $height the output height
	 * @param array $config the config array
	 *
	 * @return string
	 */
	public static function get_svg_from_path(
		string $path,
		int $width = 0,
		int $height = 0,
		array $config = []
	): string {
		// Make sure the file exists
		if ( ! is_file( $path ) || ! is_readable( $path ) ) {
			return '';
		}

		// Load the SVG into memory
		$dom_document = new \DOMDocument();
		$dom_document->load( $path );

		// Add classes
		if (
			isset( $config['classes'] ) &&
			is_array( $config['classes'] ) &&
			count( $config['classes'] ) > 0
		) {
			$classes = implode( ' ', $config['classes'] );
			$dom_document->documentElement->setAttribute( 'class', $classes ); //phpcs:ignore
		}

		if ( $width > 0 && $height > 0 ) {
			$dom_document->documentElement->setAttribute( 'width', $width ); //phpcs:ignore
			$dom_document->documentElement->setAttribute( 'height', $height ); //phpcs:ignore
		}

		// Output the SVG
		return $dom_document->saveHTML();
	}
}
