<?php

/**
 * Class Ajax
 *
 * A class to register Ajax functions relating to site content
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use DateTime;
use Exception;
use JsonException as JsonExceptionAlias;
use WC_Countries;
use WC_Product_Query;
use WC_Product_Simple;
use WP_Query;


/**
 * Class Ajax
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Ajax {

	public static function get_news_and_events_filters_handler() {
		return wp_send_json_success( get_categories() );
	}

	/**
	 * @return void
	 */
	public static function get_news_and_events_handler(): void {
		$ID         = 0;
		$options    = [];
		$posts      = [];
		$categories = '';
		if ( ! empty( $_POST['ID'] ) ) {
			$ID = (int) sanitize_text_field( $_POST['ID'] );
		}
		if ( have_rows( 'flexible', $ID ) ) {
			while ( have_rows( 'flexible', $ID ) ) {
				the_row();
				if ( get_row_layout() === 'news_&_media' ) {
					$options = get_sub_field( 'options' );
				}
				wp_reset_postdata();
			}
		}

		$display_number = (int) $options['number_of_posts'] ?: 9;

		if ( $options['filter_by_category'] ) {
			$categories = implode( ',', $options['filter_by_category'] ) ?: '';
		}
		$select_posts     = $options['select_posts'] ?: false;
		$individual_posts = $options['individual_posts'] ?: [];

		if ( ! empty( $_POST['filter_by_category'] ) ) {
			$categories = sanitize_text_field( $_POST['filter_by_category'] );
		}

		$posts = Queries::news_and_media( $display_number, $categories, $select_posts, $individual_posts );

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
				$post_info = [
					'title'      => get_the_title(),
					'image_URL'  => wp_get_attachment_image_url(
						get_post_thumbnail_id(),
						'small'
					) ?: get_field( 'media', 'options' )['fallback_image']['sizes']['small'],
					'post_date'  => get_the_date( 'dS F Y' ),
					'permalink'  => get_the_permalink(),
					'excerpt'    => $excerpt,
					'categories' => Template::get_post_items( 'news-and-media-card', 2 ),
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

}
