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
 * Class Queries
 *
 * The Queries class provides static methods to perform various queries.
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
	public static function news_and_media(
		int $display_number = 12,
		array $categories = [],
		bool $selected_posts_flag = false,
		array $selected_posts = [],
		int $page = 1
	): WP_Query {
		$args = [
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $display_number,
			'orderby'        => 'post_date',
			'order'          => 'desc',
			'paged'          => $page,
		];

		// Filter by $categories
		if ( false === $selected_posts_flag && ! empty( $categories ) ) {
			$args['category__in'] = $categories;
		}

		// Selected posts
		if ( true === $selected_posts_flag && ! empty( $selected_posts ) ) {
			$args['post__in']       = $selected_posts;
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = 100;
		}

		return new WP_Query( $args );
	}

	/**
	 * @param int $display_number The number of products to display.
	 * @param string $categories The categories to filter the products by.
	 * @param bool $selected_posts_flag Flag to indicate whether to display only selected posts.
	 * @param array $selected_posts The array of selected product IDs.
	 *
	 * @return WP_Query                    The query object for the product innovation.
	 */
	public static function product_innovation(
		int $display_number = 100,
		string $categories = '',
		bool $selected_posts_flag = false,
		array $selected_posts = []
	): WP_Query {
		$args = [
			'post_type'      => 'product_innovation',
			'posts_per_page' => $display_number,
			'orderby'        => 'post_date',
			'order'          => 'desc',
		];

		// Filter by $categories
		if ( false === $selected_posts_flag && ! empty( $categories ) ) {
			$args['category__in'] = $categories;
		}

		// Selected posts
		if ( true === $selected_posts_flag && ! empty( $selected_posts ) ) {
			$args['post__in']       = $selected_posts;
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = 100;
		}

		return new WP_Query( $args );
	}

	/**
	 * @param int $display_number
	 * @param array $sectors
	 * @param bool $selected_posts_flag
	 * @param array $individual_posts
	 *
	 * @return WP_Query
	 */
	public static function case_studies(
		int $display_number = 12,
		array $sectors = [],
		bool $selected_posts_flag = false,
		array $individual_posts = []
	): WP_Query {
		$args = [
			'post_type'           => 'case_studies',
			'post_status'         => 'publish',
			'posts_per_page'      => $display_number,
			'orderby'             => 'post_date',
			'order'               => 'desc',
			'ignore_sticky_posts' => true,
		];
		// Filter by sector
		if ( false === $selected_posts_flag && ! empty( $sectors ) ) {
			$count = 0;
			foreach ( $sectors as $sector ) {
				$args['meta_query'][ $count ]   = [
					'key'     => 'assigned_sector',
					'value'   => $sector,
					'compare' => 'LIKE',
				];
				$args['meta_query']['relation'] = 'OR';
				$count ++;
			}
		}

		// Individual case studies
		if ( true === $selected_posts_flag && ! empty( $individual_posts ) ) {
			$args['post__in']       = $individual_posts;
			$args['posts_per_page'] = 100;
			$args['orderby']        = 'post__in';
		}

		return new WP_Query( $args );
	}

	/**
	 * @param int $display_number
	 * @param bool $selected_posts_flag
	 * @param array $selected_posts
	 *
	 * @return WP_Query
	 */
	public static function sectors(
		int $display_number = 9,
		bool $selected_posts_flag = false,
		array $selected_posts = []
	): WP_Query {
		$args = [
			'post_type'      => 'sectors',
			'post_status'    => 'publish',
			'posts_per_page' => $display_number,
			'orderby'        => 'title',
			'order'          => 'asc',
		];
		if ( true === $selected_posts_flag && ! empty( $selected_posts ) ) {
			$args['post__in']       = $selected_posts;
			$args['orderby']        = 'post__in';
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
	public static function related_content(
		string $post_type,
		string $cat,
		int $post_id,
		int $display_number
	): WP_Query {
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

	/** This function can be used to get related products
	 *
	 * @param int $product_id
	 *
	 * @return WC_Product_Query
	 */
	public static function related_products( int $product_id ): WC_Product_Query {
		$product    = wc_get_product( $product_id );
		$upsell_ids = $product->get_upsell_ids();
		$args       = [
			'post_type'    => 'product',
			'limit'        => 3,
			'include'      => $upsell_ids,
			'post__not_in' => [ $product_id ],
		];

		return new WC_Product_Query( $args );
	}

	/**
	 * Retrieves a list of products based on various filters.
	 *
	 * @param int $display_number The maximum number of products to display per page.
	 * @param bool $select_products Whether to select specific products or not.
	 * @param array $individual_products An array of individual product IDs if $select_products is true.
	 * @param array $filters An array of filters to refine the product list.
	 * @param string $sort_by The attribute to sort the products by.
	 * @param int $page The current page number.
	 * @param array $tax An array containing taxonomy information for filtering the series.
	 * @param array $single An array containing information for a single series.
	 *
	 * @return WP_Query An instance of WP_Query containing the queried products.
	 */
	public static function products(
		int $display_number,
		bool $select_products,
		array $individual_products,
		array $filters,
		string $sort_by,
		int $page,
		array $tax,
		array $single
	): WP_Query {
		$series = [];
		// Base query arguments
		$args = [
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => $display_number,
			'paged'          => $page,
			'order'          => 'ASC',
			'tax_query'      => [ 'relation' => 'OR' ],
		];

		if ( get_current_blog_id() === 6 ) {
			$args['meta_key'] = 'series';
			$args['orderby']  = 'meta_value';
		}

		// Single series handling
		if ( ! empty( $single ) ) {
			if ( 'series' === $single[0] ) {
				$args['meta_query'][] = [
					'key'     => 'series',
					'value'   => $single[1],
					'compare' => 'LIKE',
				];
			} else {
				$args['tax_query'][] = [
					'taxonomy' => $single[0],
					'field'    => 'term_id',
					'terms'    => $single[1],
				];
			}
		}


		// Series and taxonomy handling

		if ( ! empty( $tax ) ) {
			// Fetch series posts based on taxonomy
			$series_posts = new WP_Query( [
				'post_type'      => 'series',
				'post_status'    => 'publish',
				'posts_per_page' => - 1, // Fetch all posts
				'tax_query'      => [
					[
						'taxonomy' => $tax[0],
						'field'    => 'term_id',
						'terms'    => $tax[1],
					],
				],
			] );

			// Collect series slugs
			if ( $series_posts->have_posts() ) {
				while ( $series_posts->have_posts() ) {
					$series_posts->the_post();
					$series[] = sanitize_title( get_the_title() );
				}
			}
			wp_reset_postdata();
		}

		// Filter handling
		if ( ! empty( $filters ) && empty( $single ) ) {
			foreach ( $filters as $attribute => $values ) {
				$attribute = sanitize_title_with_dashes( $attribute );
				$values    = array_map( 'sanitize_title', $values );

				if ( ! empty( $values ) ) {
					$args['tax_query'][] = [
						'taxonomy' => 'pa_' . $attribute,
						'field'    => 'term_id',
						'terms'    => $values,
						'operator' => 'IN',
					];
				}
			}
		}

		// Individual products handling
		if (
			$select_products &&
			! empty( $individual_products ) &&
			empty( $single )
		) {
			$args['post__in']       = $individual_products;
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = count( $individual_products );
		}

		// Sorting handling

		if ( ! empty( $sort_by ) ) {
			switch ( $sort_by ) {
				case 'productName':
					$args['orderby'] = 'title';
					$args['order']   = 'ASC';
					break;
				case 'price':
					$args['meta_key'] = '_price';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'ASC';
					break;
				case 'date':
					$args['orderby'] = 'date';
					$args['order']   = 'DESC';
					break;
				case 'series':
					$args['meta_key'] = 'series';
					$args['orderby']  = 'meta_value';
					$args['order']    = 'ASC';
					break;
				default:
					break;
			}
		}

		// Return the WP_Query object
		return new WP_Query( $args );
	}

	/**
	 * Retrieves a list of series based on various filters.
	 *
	 * @param int $display_number
	 * @param bool $select_series Whether to select a specific series or not.
	 * @param array $individual_series An array of individual series if $select_series is true.
	 * @param array $categories An array of category IDs to filter the series by.
	 * @param array $industry An array of industry IDs to filter the series by.
	 * @param int $page The current page number.
	 *
	 * @return WP_Query An instance of WP_Query containing the queried series.
	 */
	public static function series(
		int $display_number,
		bool $select_series,
		array $individual_series,
		array $categories,
		array $industry,
		int $page
	): WP_Query {

		$args = [
			'post_type'      => 'series',
			'post_status'    => 'publish',
			'posts_per_page' => $display_number,
			'paged'          => $page,
			'orderby'        => 'title',
			'order'          => 'ASC',
		];

		// Select series
		if ( true === $select_series && ! empty( $individual_series ) ) {
			$args['post__in']       = $individual_series;
			$args['orderby']        = 'post__in';
			$args['posts_per_page'] = 100;
		} else {
			// Filter by categories
			if ( ! empty( $categories ) ) {

				$args['tax_query'][] = [
					'taxonomy' => 'categories',
					'field'    => 'term_id',
					'terms'    => $categories,
				];
			}

			// Filter by industry
			if ( ! empty( $industry ) ) {
				$args['tax_query'][] = [
					'taxonomy' => 'industry',
					'field'    => 'term_id',
					'terms'    => $industry,
				];
			}
		}


		return new WP_Query( $args );
	}
}
