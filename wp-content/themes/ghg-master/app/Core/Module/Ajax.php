<?php

/**
 * Class Ajax
 *
 * A class to register Ajax functions relating to site content
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use WP_Query;

/**
 * Class Ajax
 */
class Ajax {
	/**
	 * Retrieves the news and events filters and sends a JSON response with the data.
	 *
	 * @return array The news and events filters data.
	 */
	public static function get_news_and_events_filters_handler(): array {
		return wp_send_json_success( get_categories() );
	}

	/**
	 * Retrieves tax products based on the given term ID and page number.
	 *
	 * @return array An array containing the retrieved tax products and related information.
	 */
	public static function get_tax_products_handler(): void {
		$data           = [];
		$page           = isset( $_POST['page'] ) ? (int) $_POST['page'] : 1;
		$termID         = isset( $_POST['page_ID'] ) ? (int) $_POST['page_ID'] : 0;
		$total_pages    = 1;
		$show_load_more = true;
		$args           = [
			'post_type'      => 'product',
			'posts_per_page' => 12,
			'post_status'    => 'publish',
			'paged'          => $page,
		];

		if ( ! empty( $termID ) ) {
			$args['tax_query'][] = [
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $termID,
			];
		}

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			$total_pages = $query->max_num_pages;
			while ( $query->have_posts() ) {
				$query->the_post();
				$product      = wc_get_product( get_the_ID() );
				$image_url    = get_the_post_thumbnail_url( get_the_ID(), 'small' );
				$product_type = $product->get_type();
				if ( empty( $image_url ) ) {
					$fallback_image = get_field( 'fallback_image', 'options' );
					$image_url      = ! empty( $fallback_image['sizes']['small'] )
						? $fallback_image['sizes']['small']
						: '';
				}

				$is_configurable = get_post_meta(
					get_the_ID(),
					'_mkl_pc__is_configurable',
					true
				);
				if ( 'yes' === $is_configurable ) {
					$product_type = 'configurable';
				}

				$data['data'][] = [
					'title'             => get_the_title(),
					'image_url'         => $image_url,
					'permalink'         => get_permalink(),
					'description'       => get_the_content(),
					'short_description' => $product->get_short_description(),
					'price_with_vat'    =>
						wc_price( wc_get_price_including_tax( $product ) ) .
						'<span>Inc. VAT</span>',
					'price_without_vat' =>
						wc_price( wc_get_price_excluding_tax( $product ) ) .
						'<span>Excl. VAT</span>',
					'product_type'      => $product_type,
				];
			}

			if ( $total_pages <= $page ) {
				$show_load_more = false;
			}


			$data['additional_data'] = [
				'total_page'  => $total_pages,
				'show_button' => $show_load_more,
				'page'        => $page,
				'show_vat'    => false,
			];

			wp_reset_postdata();
		}

		try {
			wp_send_json_success( $data );
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	public static function get_series_handler(): void {
		try {
			$page               = isset( $_POST['page'] ) ? (int) $_POST['page'] : 1;
			$page_ID            = isset( $_POST['page_ID'] ) ? (int) $_POST['page_ID'] : 0;
			$tax                = $_POST['tax'] ?? '';
			$options            = [];
			$data['no_results'] = false;
			$show_load_more     = false;
			if ( have_rows( 'flexible', $page_ID ) ) {
				while ( have_rows( 'flexible', $page_ID ) ) {
					the_row();
					if ( get_row_layout() === 'series' ) {
						$options = get_sub_field( 'options' ) ?: [];
					}
				}
				wp_reset_postdata();
			}

			$display_number = $options['series_number'] ?: 15;
			if ( $display_number === 'all' ) {
				$display_number = 15;
				$show_load_more = true;
			}
			$display_number = (int) $display_number;

			$select_series     = $options['select_series'] ?? false;
			$individual_series =
				isset( $options['individual_series'] ) &&
				is_array( $options['individual_series'] )
					? $options['individual_series']
					: [];

			$categories =
				isset( $options['categories'] ) &&
				$options['categories'] !== false
					? $options['categories']
					: [];

			$industry =
				isset( $options['industry'] ) && $options['industry'] !== false
					? $options['industry']
					: [];

			if ( $tax === 'industry' ) {
				$industry[] = $page_ID;
			}
			if ( $tax === 'categories' ) {
				$categories[] = $page_ID;
			}

			$data = Template::get_series( $display_number, $select_series, $individual_series, $categories, $industry, $page, $show_load_more, $page_ID );

			wp_send_json_success( $data );
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	/**
	 * Retrieves the product categories data for the specified page.
	 *
	 * @return void
	 */
	public static function get_product_categories_handler(): void {
		try {
			$data       = [];
			$page_ID    = 0;
			$categories = [];
			if ( ! empty( $_POST['page_ID'] ) ) {
				$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
			}

			$btn_text = 'Shop now';
			if ( 7 == get_current_blog_id() || 5 == get_current_blog_id() ) {
				$btn_text = 'View the range';
			}

			$taxonomy = 'product_cat';
			$term     = 'product_categories';

			if ( have_rows( 'flexible', $page_ID ) ) {
				while ( have_rows( 'flexible', $page_ID ) ) {
					the_row();
					if ( get_row_layout() === 'product_categories' ) {
						$categories = get_sub_field( 'options' )[ $term ];
					}
				}
				wp_reset_postdata();
			}

			if ( ! empty( $categories ) ) {
				foreach ( $categories as $categoryID ) {
					$category = get_term( $categoryID, $taxonomy );

					$thumbnail_id  = get_term_meta(
						$category->term_id,
						'thumbnail_id',
						true
					);
					$thumbnail_url = wp_get_attachment_image_src(
						$thumbnail_id,
						'small'
					)[0];

					if ( empty( $thumbnail_url ) ) {
						$thumbnail_url = $image_URL = get_field(
							'fallback_image',
							'options'
						)['sizes']['small'];
					}

					$catInfo = [
						'title'             => $category->name,
						'image_url'         => $thumbnail_url,
						'permalink'         => get_term_link( $categoryID, $taxonomy ),
						'short_description' => get_field( 'short_description', $category ),
						'button_text'       => $btn_text,
					];
					$data[]  = $catInfo;
				}
			}
			wp_send_json_success( $data );
			die();
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	/**
	 * @return void The array of products and data.
	 */
	public static function get_products_handler(): void {
		try {
			$data           = [];
			$page           = isset( $_POST['page'] ) ? (int) $_POST['page'] : 1;
			$pageID         = isset( $_POST['page_ID'] ) ? (int) $_POST['page_ID'] : 0;
			$options        = [];
			$show_load_more = true;

			if ( have_rows( 'flexible', $pageID ) ) {
				while ( have_rows( 'flexible', $pageID ) ) {
					the_row();
					if ( get_row_layout() === 'products' ) {
						$options = get_sub_field( 'options' ) ?: [];
					}
				}
				wp_reset_postdata();
			}

			$product_numbers = isset( $options['product_number'] )
				? $options['product_number']
				: 12;
			if ( $product_numbers === 'All' ) {
				$product_numbers = 12;
			}

			$categories          = isset( $options['categories'] )
				? $options['categories']
				: [];
			$woocommerce_filter  = isset( $options['woocommerce_filter'] )
				? $options['woocommerce_filter']
				: [];
			$select_products     = isset( $options['select_products'] )
				? $options['select_products']
				: false;
			$individual_products = isset( $options['individual_products'] )
				? $options['individual_products']
				: [];
			$series              = isset( $options['series'] ) ? $options['series'] : [];

			$args = [
				'post_type'      => 'product',
				'posts_per_page' => $product_numbers,
				'post_status'    => 'publish',
				'paged'          => $page,
			];

			// Product filters
			if ( ! empty( $categories ) ) {
				$args['tax_query'][] = [
					'taxonomy' => 'product_cat',
					'field'    => 'id',
					'terms'    => $categories,
				];
			}

			// Various WooCommerce filters
			if ( ! empty( $woocommerce_filter ) ) {
				if (
					$woocommerce_filter === 'Best selling' ||
					$woocommerce_filter === 'Top rated'
				) {
					$args['orderby']  = [
						'meta_value_num' =>
							$woocommerce_filter === 'Best selling'
								? 'DESC'
								: 'ASC',
						'title'          => 'ASC',
					];
					$args['meta_key'] =
						$woocommerce_filter === 'Best selling'
							? 'total_sales'
							: '_wc_average_rating';
				}
				if ( $woocommerce_filter === 'On sale' ) {
					$args['post__in'] = wc_get_product_ids_on_sale();
					$args['orderby']  = 'post__in';
				}
			}

			// Select individual products
			if ( $select_products && ! empty( $individual_products ) ) {
				$args['post__in']       = $individual_products;
				$args['posts_per_page'] = 100;
			}

			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
				$total_pages = $query->max_num_pages;

				while ( $query->have_posts() ) {
					$query->the_post();
					$product   = wc_get_product( get_the_ID() );
					$image_url = get_the_post_thumbnail_url(
						get_the_ID(),
						'small'
					);

					if ( empty( $image_url ) ) {
						$fallback_image = get_field(
							'fallback_image',
							'options'
						);
						$image_url      = ! empty( $fallback_image['sizes']['small'] )
							? $fallback_image['sizes']['small']
							: '';
					}

					$data['data'][] = [
						'title'             => get_the_title(),
						'image_url'         => $image_url,
						'permalink'         => get_permalink(),
						'description'       => get_the_content(),
						'short_description' => $product->get_short_description(),
						'price_with_vat'    => '£' .
						                       wc_format_decimal( wc_get_price_excluding_tax( $product ), 2 ) .
						                       '<span class="card-product__vat">Ex VAT</span>',
						'price_without_vat' => '£' .
						                       wc_format_decimal( wc_get_price_including_tax( $product ), 2 ) .
						                       '<span class="card-product__vat">Inc VAT</span>',
						'product_type'      => $product->get_type(),
					];
				}

				if ( $total_pages <= $page ) {
					$show_load_more = false;
				}


				$data['additional_data'] = [
					'total_page'  => $total_pages,
					'show_button' => $show_load_more,
					'page'        => $page,
					'show_vat'    => false,
				];
			}

			wp_send_json_success( $data );
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	/**
	 * Retrieves the product data for the specified page.
	 *
	 * @return void
	 * @throws Exception If an error occurs while retrieving product data.
	 */
	public static function get_products_aut_handler(): void {
		try {
			$page_ID        = 0;
			$tax            = [];
			$options        = [];
			$sort_by        = '';
			$page           = 1;
			$single         = [];
			$show_load_more = false;

			if ( ! empty( $_POST['page_ID'] ) ) {
				$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
			}
			$filters = isset( $_POST['filters'] )
				? json_decode( stripslashes( $_POST['filters'] ), true )
				: [];

			if ( ! empty( $_POST['sort_by'] ) ) {
				$sort_by = sanitize_text_field( $_POST['sort_by'] );
			}

			if ( ! empty( $_POST['page'] ) ) {
				$page = (int) sanitize_text_field( $_POST['page'] );
			}

			if ( $page > 1 ) {
				$initial = false;
			}
			if ( ! empty( $_POST['single'] ) ) {
				$single = [ sanitize_text_field( $_POST['single'] ), $page_ID ];
			}

			if ( have_rows( 'flexible', $page_ID ) ) {
				while ( have_rows( 'flexible', $page_ID ) ) {
					the_row();
					if ( get_row_layout() === 'AUT_products' ) {
						$options = get_sub_field( 'options' );
					}
				}
				wp_reset_postdata();
			}

			$display_filters = $options['display_filters'] ?? false;

			$display_number = $options['product_number'] ?? 9;
			if ( 'all' === $display_number ) {
				$display_number = 9;
				$show_load_more = true;
				if ( true === $display_filters ) {
					$display_number = 8;
				}
			}

			if ( true === $display_filters ) {
				$display_number = 8;
				$show_load_more = true;
			}


			$select_products     = $options['select_products'] ?: false;
			$individual_products = $options['individual_products'] ?: [];

			if ( get_post_meta( $page_ID )['content_tag_line'] ) {
				$select_products     = true;
				$individual_products = [ $page_ID ];
			}

			$categories = $options['categories'] ?: [];
			$industry   = $options['industry'] ?: [];

			if ( false === $display_filters ) {
				$tax = [ $tax, $page_ID ];

				if ( ! empty( $categories ) ) {
					$tax = [ 'categories', $categories ];
				}
				if ( ! empty( $industry ) ) {
					$tax = [ 'industry', $industry ];
				}
			}

			if ( ! empty( $single ) ) {
				$display_number = 100;
			}


			$data = Template::get_AUT_products(
				$display_number,
				$select_products,
				$individual_products,
				$filters,
				$sort_by,
				$page,
				$tax,
				$single,
				$show_load_more,
				$page_ID,
			);

			wp_send_json_success( $data );

			die();
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	/**
	 * Retrieves the news and events data for the specified page.
	 *
	 * @return void
	 */
	#[NoReturn]
	public static function get_news_and_events_handler(): void {

		try {

			$page_ID        = 0;
			$options        = [];
			$posts          = [];
			$categories     = [];
			$page           = 1;
			$total_pages    = 1;
			$show_load_more = true;

			if ( ! empty( $_POST['page'] ) ) {
				$page = (int) sanitize_text_field( $_POST['page'] );
			}

			if ( ! empty( $_POST['page_ID'] ) ) {
				$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
			}
			if ( have_rows( 'flexible', $page_ID ) ) {
				while ( have_rows( 'flexible', $page_ID ) ) {
					the_row();
					if ( get_row_layout() === 'news_&_media' ) {
						$options = get_sub_field( 'options' );
					}
					wp_reset_postdata();
				}
			}

			$display_number = $options['number_of_posts'] ?: 12;
			if ( 'All' == $display_number ) {
				$display_number = 12;
				$show_load_more = true;
			}

			if ( $options['filter_by_category'] ) {
				$categories = implode( ',', $options['filter_by_category'] ) ?: '';
			}
			$select_posts     = $options['select_posts'] ?: false;
			$individual_posts = $options['individual_posts'] ?: [];

			if ( ! empty( $_POST['filter_by_category'] ) ) {
				$categories = sanitize_text_field( $_POST['filter_by_category'] );
			}
			$posts = Queries::news_and_media(
				$display_number,
				$categories,
				$select_posts,
				$individual_posts,
				$page
			);

			if ( $posts->have_posts() ) {
				$total_pages = $posts->max_num_pages;
				while ( $posts->have_posts() ) {
					$posts->the_post();
					$excerpt = get_the_excerpt();
					if ( strlen( $excerpt ) > 150 ) {
						$excerpt = substr( $excerpt, 0, 150 );
						$excerpt = rtrim( $excerpt );
						$excerpt .= '...';
					}

					$image_URL = wp_get_attachment_image_url(
						get_post_thumbnail_id(),
						'small'
					);
					if ( empty( $image_URL ) ) {
						$image_URL = get_field( 'fallback_image', 'options' )['sizes']['small'];
					}


					$data['data'][] = [
						'title'       => get_the_title(),
						'image_URL'   => $image_URL,
						'post_date'   => get_the_date( 'dS F Y' ),
						'permalink'   => get_the_permalink(),
						'excerpt'     => $excerpt,
						'categories'  => Template::get_post_items(
							'news-and-media-card',
							2
						),
						'button_text' => 'Read Blog',
					];

				}
			}

			if ( $total_pages <= $page ) {
				$show_load_more = false;
			}


			$data['additional_data'] = [
				'total_page'     => $total_pages,
				'active_filters' => $categories,
				'show_button'    => $show_load_more,
				'page'           => $page,
			];

			wp_send_json_success( $data );


		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}

	}

	/**
	 * Retrieves the product innovation data for the specified page.
	 *
	 * @return void
	 */
	#[NoReturn]
	public static function get_product_innovation_handler(): void {
		$page_ID    = 0;
		$options    = [];
		$posts      = [];
		$categories = '';
		if ( ! empty( $_POST['page_ID'] ) ) {
			$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
		}
		if ( have_rows( 'flexible', $page_ID ) ) {
			while ( have_rows( 'flexible', $page_ID ) ) {
				the_row();
				if ( get_row_layout() === 'product_innovation' ) {
					$options = get_sub_field( 'options' );
				}
				wp_reset_postdata();
			}
		}

		$display_number = $options['number_of_posts'] ?: 9;

		if ( 'All' === $display_number ) {
			$display_number = 100;
		}

		if ( $options['filter_by_category'] ) {
			$categories = implode( ',', $options['filter_by_category'] ) ?: '';
		}
		$select_innovation     = $options['select_posts'] ?: false;
		$individual_innovation = $options['individual_posts'] ?: [];

		if ( ! empty( $_POST['filter_by_category'] ) ) {
			$categories = sanitize_text_field( $_POST['filter_by_category'] );
		}

		$posts = Queries::product_innovation(
			$display_number,
			$categories,
			$select_innovation,
			$individual_innovation
		);

		if ( $posts->have_posts() ) {
			$results = [];
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$excerpt = get_the_excerpt();
				if ( strlen( $excerpt ) > 150 ) {
					$excerpt = substr( $excerpt, 0, 150 );
					$excerpt = rtrim( $excerpt );
					$excerpt .= '...';
				}
				$image_URL = wp_get_attachment_image_url(
					get_post_thumbnail_id(),
					'small'
				);
				if ( empty( $image_URL ) ) {
					$image_URL = get_field( 'fallback_image', 'options' )['sizes']['small'];
				}

				$post_info = [
					'title'       => get_the_title(),
					'image_URL'   => $image_URL,
					'post_date'   => get_the_date( 'dS F Y' ),
					'permalink'   => get_the_permalink(),
					'excerpt'     => $excerpt,
					'categories'  => Template::get_post_items(
						'news-and-media-card',
						2
					),
					'button_text' => 'Read Blog',
				];

				$results[] = $post_info;
			}

			$final = [
				'posts'          => $results,
				'active_filters' => $categories,
			];

			// Return the result as JSON
			header( 'Content-Type: application/json' );
			echo json_encode( $final );
		}
		die();
	}

	/**
	 * Retrieves the case studies data for the specified page.
	 *
	 * @return void
	 */
	#[NoReturn]
	public static function get_case_studies_handler(): void {
		$page_ID = 0;
		$options = [];
		$results = [];
		$sectors = [];
		if ( ! empty( $_POST['page_ID'] ) ) {
			$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
		}

		if ( have_rows( 'flexible', $page_ID ) ) {
			while ( have_rows( 'flexible', $page_ID ) ) {
				the_row();
				if ( get_row_layout() === 'case_studies' ) {
					$options = get_sub_field( 'options' );
				}
				wp_reset_postdata();
			}
		}

		$display_number = $options['number_of_case_studies'] ?: 9;
		if ( 'All' === $display_number ) {
			$display_number = 100;
		}

		if ( $options['filter_by_sector'] ) {
			$sectors = $options['filter_by_sector'];
		}
		$selected_posts_flag = $options['select_case_studies'] ?: false;
		$individual_posts    = $options['individual_case_studies'] ?: [];

		$posts = Queries::case_studies(
			$display_number,
			$sectors,
			$selected_posts_flag,
			$individual_posts
		);

		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();
				$excerpt = get_the_excerpt();
				if ( strlen( $excerpt ) > 150 ) {
					$excerpt = substr( $excerpt, 0, 150 );
					$excerpt = rtrim( $excerpt );
					$excerpt .= '...';
				}

				$image_URL = wp_get_attachment_image_url(
					get_post_thumbnail_id(),
					'small'
				);
				if ( empty( $image_URL ) ) {
					$image_URL = get_field( 'fallback_image', 'options' )['sizes']['small'];
				}

				$post_info = [
					'title'       => get_the_title(),
					'image_URL'   => $image_URL,
					'post_date'   => get_the_date( 'dS F Y' ),
					'permalink'   => get_the_permalink(),
					'excerpt'     => $excerpt,
					'categories'  => Template::get_post_items(
						'news-and-media-card',
						2
					),
					'button_text' => 'View Case Study',
				];

				$results[] = $post_info;
			}
			wp_reset_postdata();

			$final = [
				'posts' => $results,
			];

			// Return the result as JSON
			header( 'Content-Type: application/json' );
			echo json_encode( $final );
		}
		die();
	}

	/**
	 * Retrieves the product filters data for the specified page.
	 *
	 * @return void
	 */
	public static function get_product_filters_handler(): void {
		try {
			$final = [];

			$allowed_attributes = [
				'pa_series',
				//				'pa_4km-carry-capacity',
				'pa_fixing-type',
				'pa_bore-type',
				'pa_bore-diameter',
				//				'pa_hub-length',
				'pa_hole-spacing',
				'pa_brake',
				'pa_tyre-material',
				'pa_lower-temperature-range',
				'pa_upper-temperature-range',
				'pa_bolt-hole-diameter',
				'pa_wheel-diameter',
				'pa_plate-dimension',
				'pa_hub-length-lower',
				'pa_hub-length-upper',
			];

			// Get all product attributes
			$product_attributes = wc_get_attribute_taxonomies();

			if ( $product_attributes ) {
				foreach ( $product_attributes as $product_attribute ) {
					$attribute_name =
						'pa_' . $product_attribute->attribute_name;

					// Check if the attribute is in the allowed list
					if ( ! in_array( $attribute_name, $allowed_attributes ) ) {
						continue;
					}

					// Get terms for the attribute
					$terms = get_terms( [
						'taxonomy'   => $attribute_name,
						'hide_empty' => true,
					] );

					// Check if the attribute has terms assigned to any published product
					if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
						// Modify attribute label
						$attribute_label = preg_replace_callback(
							'/\b(KG)\b/i',
							function ( $matches ) {
								return strtoupper( $matches[1] );
							},
							ucfirst(
								str_replace(
									[ '_', '-' ],
									' ',
									$product_attribute->attribute_name
								)
							)
						);
						// Remove 'Pir' from the start of the attribute label
						$attribute_label = preg_replace(
							'/^Pir\s+/i',
							'',
							$attribute_label
						);

						$term_data = [];
						foreach ( $terms as $term ) {
							// Get products associated with the term
							$args = [
								'post_type'      => 'product',
								'post_status'    => 'publish',
								'posts_per_page' => - 1,
								'tax_query'      => [
									[
										'taxonomy' => $attribute_name,
										'field'    => 'term_id',
										'terms'    => $term->term_id,
									],
								],
							];

							$term_products = new WP_Query( $args );

							// Check if any product associated with the term is published
							if ( $term_products->have_posts() ) {
								$term_data[] = [
									'id'    => $term->term_id,
									'title' => $term->name,
								];
							}
							wp_reset_postdata();
						}

						// Add attribute data to final array if there are terms with published products
						if ( ! empty( $term_data ) ) {
							$final[ $attribute_name ] = [
								'title' => $attribute_label,
								'id'    => $product_attribute->attribute_name,
								'terms' => $term_data,
							];
						}
					}
				}

				// Sort the final array based on the order in $allowed_attributes
				$final_sorted = [];
				foreach ( $allowed_attributes as $attribute_name ) {
					if ( isset( $final[ $attribute_name ] ) ) {
						$final_sorted[] = $final[ $attribute_name ];
					}
				}

				wp_send_json( $final_sorted );
			} else {
				wp_send_json( [] );
			}
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	public static function get_series_categories_handler(): void {
		try {
			$page_ID = 0;
			$options = [];
			$data    = [];
			if ( ! empty( $_POST['page_ID'] ) ) {
				$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
			}

			if ( have_rows( 'flexible', $page_ID ) ) {
				while ( have_rows( 'flexible', $page_ID ) ) {
					the_row();
					if ( get_row_layout() === 'series_categories' ) {
						$options = get_sub_field( 'options' );
					}
				}
				wp_reset_postdata();
			}

			$categories = $options['series_categories'];
			$industries = $options['series_industry'];

			// Function to process terms


			// Process categories
			$category_data = Template::process_terms( $categories, 'categories' );
			$data          = array_merge( $data, $category_data );

			// Process industries
			$industry_data = Template::process_terms( $industries, 'industry' );
			$data          = array_merge( $data, $industry_data );
			wp_send_json_success( $data );
			die();
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}

	/**
	 * Retrieves the sectors data for the specified page.
	 *
	 * @return void
	 */
	public static function get_sectors_handler(): void {
		try {
			$page_ID = 0;
			$options = [];
			$results = [];
			if ( ! empty( $_POST['page_ID'] ) ) {
				$page_ID = (int) sanitize_text_field( $_POST['page_ID'] );
			}
			if ( have_rows( 'flexible', $page_ID ) ) {
				while ( have_rows( 'flexible', $page_ID ) ) {
					the_row();
					if ( get_row_layout() === 'sectors' ) {
						$options = get_sub_field( 'options' );
					}
					wp_reset_postdata();
				}
			}

			$display_number = $options['number_of_sectors'] ?: 9;
			if ( 'All' === $display_number ) {
				$display_number = 100;
			}

			$select_posts     = $options['select_sectors'] ?: false;
			$individual_posts = $options['individual_sectors'] ?: [];

			$posts = Queries::sectors(
				$display_number,
				$select_posts,
				$individual_posts
			);

			if ( $posts->have_posts() ) {
				while ( $posts->have_posts() ) {
					$posts->the_post();
					$excerpt = get_the_excerpt();
					if ( strlen( $excerpt ) > 150 ) {
						$excerpt = substr( $excerpt, 0, 150 );
						$excerpt = rtrim( $excerpt );
						$excerpt .= '...';
					}
					$post_info = [
						'title'       => get_the_title(),
						'image_URL'   =>
							wp_get_attachment_image_url(
								get_post_thumbnail_id(),
								'small'
							) ?:
								get_field( 'fallback_image', 'options' )['sizes']['small'],
						'post_date'   => get_the_date( 'dS F Y' ),
						'permalink'   => get_the_permalink(),
						'excerpt'     => $excerpt,
						'button_text' => 'View Sector',
					];

					$results[] = $post_info;
				}

				$final = [
					'posts' => $results,
				];

				// Return the result as JSON
				header( 'Content-Type: application/json' );
				echo json_encode( $final );
			}
			die();
		} catch ( Exception $e ) {
			wp_send_json_error( [ 'error' => $e->getMessage() ] );
		}
	}
}
