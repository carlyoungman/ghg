<?php
/**
 * Class Taxonomy
 *
 * A class to register taxonomy hooks
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Taxonomy
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Taxonomy
{
	/**
	 * Register all custom taxonomy
	 *
	 * @@link https://github.com/johnbillion/extended-cpts/wiki
	 */
	public static function register(): void
	{
		register_extended_taxonomy(
			'categories',
			'product_innovation',
			[
				'show_in_rest' => true,
			],
			[
				'singular' => 'category',
				'plural' => 'Categories',
				'slug' => 'product-innovation-category',
			]
		);

		register_extended_taxonomy(
			'industry',
			'series',
			[
				'show_in_rest' => true,
			],
			[
				'singular' => 'Industry',
				'plural' => 'Industry',
				'slug' => 'industry',
			]
		);
		register_extended_taxonomy(
			'categories',
			'series',
			[
				'show_in_rest' => true,
			],
			[
				'singular' => 'category',
				'plural' => 'Categories',
				'slug' => 'category',
			]
		);
		register_extended_taxonomy(
			'tags',
			'series',
			[
				'show_in_rest' => true,
			],
			[
				'singular' => 'Tag',
				'plural' => 'Tags',
				'slug' => 'tag',
			]
		);
	}
}
