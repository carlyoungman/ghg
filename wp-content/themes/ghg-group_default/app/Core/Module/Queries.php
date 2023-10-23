<?php
/**
 * Class Customizer
 *
 * A class for registering project querys
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use WC_Product_Query;
use WP_Query;

/**
 * Class Query
 *
 * @package HARWELL\Core\Module
 */
class Queries {
	/**
	 * A query to display news and media posts
	 *
	 * @param int $display_number How many posts to display
	 * @param array $categories Filter by categories
	 * @param bool $selected_posts_flag A flag to determine if a use has selected posts
	 * @param array $selected_posts Selected posts
	 *
	 * @return WP_Query
	 */
	public static function news_and_media( int $display_number = 12, string $categories = '', bool $selected_posts_flag = false, array $selected_posts = [] ): WP_Query {
		$args = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $display_number,
			'orderby'        => 'post_date',
			'order'          => 'desc',
		];

		// Filter by $categories
		if ( ( false === $selected_posts_flag ) && ! empty( $categories ) ) {
			$args['category__in'] = $categories;
		}
		// Selected posts
		if ( ( true === $selected_posts_flag ) && ! empty( $selected_posts ) ) {
			$args['post__in']       = $selected_posts;
			$args['posts_per_page'] = 100;
		}

		return new WP_Query( $args );
	}


	/**
	 * A query to display related content
	 *
	 * @param string $cat Which category of posts to display
	 * @param int $post_id Post ID of the post that the related post is associated with
	 * @param int $display_number how many posts to display
	 *
	 * @return WP_Query
	 */
	public static function related_content( string $post_type, string $cat, int $post_id, int $display_number ): WP_Query {
		$args = [
			'post_type'      => $post_type,
			'post_status'    => 'publish',
			'posts_per_page' => $display_number,
			'orderby'        => 'post_date',
			'order'          => 'desc',
			'category_name'  => $cat,
			'post__not_in'   => [ $post_id ],
		];
		// Related posts fallback
		$query = new WP_Query( $args );

		if ( 0 === $query->post_count ) {
			$args['category_name'] = '';
			$query                 = new WP_Query( $args );
		}

		return new WP_Query( $args );
	}

	/** This function is responsible for displaying the search results.
	 * This query is also passed to the load more search results functionality. Core/Ajax.php
	 *
	 * @param string $filter
	 *
	 * @return WP_Query
	 */
	public static function get_search_results( string $filter = '' ): WP_Query {
		$args = [];
		if ( ! empty( get_search_query() ) ) {
			$args = [
				's'              => sanitize_text_field( $_GET['s'] ),
				'order'          => 'ASC',
				'post_status'    => 'publish',
				'orderby'        => 'relevance',
				'relevanssi'     => true,
				'posts_per_page' => 12,
			];
		}
		if ( ! empty( $filter ) && 'all' !== $filter ) {
			$args['post_type'] = $filter;
		}


		return new WP_Query( $args );
	}

}

