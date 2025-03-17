<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * Class Template
 *
 * @package BOILERPLATE_THEME\Core
 */

namespace BOILERPLATE_THEME\Core\Module;

use WP_Error;

/**
 * Class Template
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Template {
	/**
	 * This function is used to retrieve and display flexible components in a template.
	 */
	public static function get_flexible_components(): void {
		if (
			function_exists( 'have_rows' ) &&
			function_exists( 'get_row_layout' ) &&
			function_exists( 'get_template_part' )
		) {
			$path       = './template-parts/flexible/';
			$components = [
				'AUT_products',
				'FAQs',
				'cards_grid',
				'case_studies',
				'content_block',
				'current_vacancies',
				'group_listing',
				'headline_with_content',
				'hero',
				'image_with_content',
				'image_with_content_slider',
				'inline_forms',
				'key_figure_block',
				'key_points',
				'listing_block',
				'location_map',
				'news_and_media',
				'product_categories',
				'product_innovation',
				'products',
				'section_anchor',
				'sectors',
				'series',
				'series_categories',
				'series_table',
				'slider_section',
				'testimonials',
			];

			$term = get_queried_object();
			if ( have_rows( 'flexible', $term ) ) {
				while ( have_rows( 'flexible', $term ) ) {
					the_row();
					foreach ( $components as $component ) {
						if ( get_row_layout() === $component ) {
							get_template_part( $path . $component );
						}
					}
				}
			}
		}
	}

	/**
	 * This function is used to generate an array of body classes.
	 *
	 * @param array $classes The current array of body classes.
	 *
	 * @return array The updated array of body classes.
	 */
	public static function body_classes( array $classes ): array {
		// Helps detect if JS is enabled or not.
		$classes[] = ' no-js';

		// Adds `singular` to singular pages, and `hfeed` to all other pages.
		$classes[] = is_singular() ? 'singular' : 'hfeed';

		// Add a body class if the main navigation is active.
		if ( has_nav_menu( 'primary' ) ) {
			$classes[] = 'has-main-navigation';
		}

		// Get the current site details
		$blog_details = get_blog_details();
		if ( $blog_details ) {
			// Sanitize the blog name to use as a class
			$site_name_class = sanitize_title( $blog_details->blogname );

			$classes[] = $site_name_class;
		}

		return $classes;
	}

	public static function admin_body_classes( $classes ): string {
		// Helps detect if JS is enabled or not.
		$js_class = 'no-js ';

		// Adds `singular` class to singular pages in admin, just as an example.
		$js_class .= is_singular() ? 'singular ' : 'hfeed ';

		// Add a body class if the main navigation is active in the theme.
		if ( has_nav_menu( 'primary' ) ) {
			$js_class .= 'has-main-navigation ';
		}

		// Get the current site details
		$blog_details = get_blog_details();
		if ( $blog_details ) {
			// Sanitize the blog name to use as a class
			$site_name_class = sanitize_title( $blog_details->blogname );
			$js_class        .= ' ' . $site_name_class . ' ';
		}

		return $classes . $js_class;
	}

	/**
	 * This method generates and displays breadcrumbs using the Yoast SEO breadcrumb function.
	 */
	public static function breadcrumbs(): void {
		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
		}
	}

	/**
	 * Retrieves an image with fallback option.
	 *
	 * @param string $base The base CSS class for the image.
	 * @param int $image_id The ID of the image to retrieve.
	 * @param string $size The image size to retrieve.
	 * @param bool $echo Optional. Whether to echo the image or return it as a string. Default false.
	 *
	 * @return string The image HTML string if $echo is false, otherwise an empty string.
	 */
	public static function get_image_with_fallback(
		string $base,
		int $image_id,
		string $size,
		bool $echo = false
	): string {
		// Check if the image exists over-wise use the fallback ID
		if ( ! $image_id ) {
			$image_id = get_field( 'fallback_image', 'options' )['id'] ?? 0;
		}
		// Build the image
		$image = wp_get_attachment_image( $image_id, $size, false, [
			'class' => esc_attr( $base ) . '__image',
		] );
		if ( false === $echo ) {
			return $image;
		}
		$allowed_html = [
			'img' => [
				'src'    => true,
				'srcset' => true,
				'sizes'  => true,
				'alt'    => true,
				'width'  => true,
				'height' => true,
				'class'  => true,
			],
		];
		echo wp_kses( $image, $allowed_html );

		return '';
	}

	/**
	 * This function is used to build a set of buttons and return or echo the HTML markup
	 *
	 * @param string $base The base class name for the button grid container
	 * @param array $buttons An array of button data
	 * @param bool $echo (Optional) Whether to echo the HTML markup or return it as a string. Defaults to false.
	 *
	 * @return string If $echo is set to false, the HTML markup of the button grid. Otherwise, an empty string.
	 */
	public static function build_buttons(
		string $base,
		array $buttons,
		bool $echo = false
	): string {
		$rtn = '';
		if ( ! empty( $buttons ) ) {
			$rtn .= '<div class="' . $base . '__button-grid">';
			foreach ( $buttons as $button ):
				$rtn .= self::build_button(
					$base,
					$button['button'],
					false,
					false
				);
			endforeach;
			$rtn .= '</div>';
		}
		if ( false === $echo ) {
			return $rtn;
		}

		echo $rtn;

		return '';
	}

	/**
	 * This function can be used to build a button or link from an ACF link
	 *
	 * @param string $base Class name to be applied
	 * @param array $props ACF link array
	 * @param bool $button A flag to return a button or a tag
	 * @param bool $echo A flag to return or echo
	 *
	 * @return string return a button or a tag
	 */
	public static function build_button(
		string $base,
		$props,
		bool $button = true,
		bool $echo = false
	): string {
		if ( ! empty( $props ) ) {
			$tag_open  = '<a ';
			$tag_close = '</a>';
			if ( true === $button ) {
				$tag_open  = '<button ';
				$tag_close = '</button>';
			}
			// Destructure passed properties
			$url     = $props['url'] ?? '';
			$target  =
				isset( $props['target'] ) && '' !== $props['target']
					? $props['target']
					: '_self';
			$title   = esc_html( $props['title'] ) ?? '';
			$classes = $base . '__button';
			// Final construction
			$rtn = $tag_open;
			$rtn .= 'class="' . esc_attr( $classes ) . '"';
			$rtn .= 'aria-label="' . $title . '"';
			$rtn .= 'rel="noreferrer noopener"';
			$rtn .= 'href="' . esc_url( $url ) . '"';
			if ( ! empty( $props['answers'] ) ) {
				$rtn .=
					'data-answers="' .
					htmlspecialchars( $props['answers'] ) .
					'"';
			}
			if ( ! empty( $props['product_ID'] ) ) {
				$rtn .=
					'data-product-ID="' . esc_attr( $props['product_ID'] ) . '"';
			}
			$rtn .= 'target="' . esc_attr( $target ) . '">';
			$rtn .= $title;
			$rtn .= $tag_close;

			if ( false === $echo ) {
				return $rtn;
			}
			echo $rtn;
		}

		return '';
	}

	/**
	 * This function is used to retrieve post items like categories or tags.
	 *
	 * @param string $base The base CSS class for styling.
	 * @param int $limit The maximum number of items to retrieve.
	 * @param bool $text Determines whether to return the items as HTML text or plain text.
	 * @param bool $echo Determines whether to echo the result or return it as a string.
	 * @param string $item The type of item to retrieve ('categories' or 'tags').
	 * @param bool $show_title Determines whether to include a title for the items.
	 *
	 * @return string The retrieved post items as HTML text or plain text.
	 */
	public static function get_post_items(
		string $base,
		int $limit,
		bool $text = false,
		bool $echo = false,
		string $item = 'categories',
		bool $show_title = false
	): string {
		$types = get_the_category();
		if ( $item === 'tags' ) {
			$types = get_the_tags();
		}
		$rtn = '';
		$i   = 0;
		if ( ! empty( $types ) ) {
			if ( false === $text ) {
				if ( true === $show_title ) {
					$rtn .=
						'<h6 class="' .
						esc_attr( $base ) .
						'__categories__header">' .
						$item .
						'</h6>';
				}
				$rtn .= '<ul class="' . esc_attr( $base ) . '__categories">';
				foreach ( $types as $type ) {
					if ( $i < $limit ) {
						/* Translators: %s: Alt tag of each category */
						$rtn .=
							'<li class="' . esc_attr( $base ) . '__category">';
						/* translators: %s: cat term */
						$rtn .= esc_html( $type->name );

						$rtn .= '</li>';
						++ $i;
					}
				}
				$rtn .= '</ul>';
				if ( false === $echo ) {
					return $rtn;
				}
				echo wp_kses_post( trim( $rtn ) );
			} else {
				$cats = [];
				foreach ( $types as $type ) {
					if ( $i < $limit ) {
						$cats = $type->slug;
						++ $i;
					}
				}

				if ( false === $echo ) {
					return $cats;
				}

				$allowed_html = [
					'ul' => [
						'class' => true,
					],
					'li' => [
						'class' => true,
					],
				];
				echo wp_kses( $cats, $allowed_html );
			}
		}

		return '';
	}

	/**
	 * This function is used to display a logo with an optional link.
	 *
	 * @param string $base The base CSS class name for the logo.
	 * @param bool $echo Whether to echo the logo or return it as a string.
	 * @param string $logo The id of the logo SVG icon.
	 *
	 * @return string The generated HTML for the logo if $echo is false, otherwise an empty string.
	 */
	public static function display_logo(
		string $base,
		bool $echo = false,
		string $logo = 'GHG-logo'
	): string {
		$rtn =
			'<a class="' .
			$base .
			'__logo-link" href="' .
			get_bloginfo( 'url' ) .
			'" aria-label="Company logo">';
		$rtn .=
			'<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#' .
			$logo .
			'"></use></svg>';
		$rtn .= '</a>';
		if ( false === $echo ) {
			return $rtn;
		}
		echo $rtn;

		return '';
	}

	/** Checks which options have been set for the block and applies a corresponding class which can be used for styling
	 *
	 * @param array $options_array Options set for the block
	 * @param array $options Options set for the block via ACF
	 */
	public static function apply_classes(
		array $options_array,
		array $options
	): void {
		$class = [ '' ];
		// Loops the array and echos out the class name
		foreach ( $options_array as $key => $op ) {
			if ( isset( $options[ $op[0] ] ) && $options[ $op[0] ] ) {
				// Applies selected ACF option class if $op[2] = true
				if ( isset( $op[2] ) ) {
					$class[] =
						$op[1] .
						'-' .
						str_replace( '_', '-', strtolower( $options[ $op[0] ] ) );
				} else {
					$class[] = str_replace( '_', '-', $op[1] );
				}
			}
		}
		echo esc_attr( implode( ' ', $class ) );
	}

	/**
	 * Sets the Google Maps API Key in a given array.
	 *
	 * This method sets the Google Maps API Key by retrieving it
	 * from the 'google_maps_API_key' field in the 'options' group.
	 * The API Key is then added to the provided array using the 'key' key.
	 *
	 * @param array $api The array to add the API Key to.
	 *
	 * @return array The modified array with the API Key added.
	 */
	public static function my_acf_google_map_api( $api ) {
		$API_KEY    = get_field( 'google_maps_API_key', 'options' );
		$api['key'] = $API_KEY;

		return $api;
	}

	/**
	 * Generates a contact link based on the provided contact value, link type, and base.
	 *
	 * This method generates a contact link by combining the contact value with the
	 * appropriate link type and then adding it to the provided base. The resulting
	 * contact link is wrapped in an anchor element with the corresponding CSS class,
	 * and displays the contact value as the anchor text.
	 *
	 * @param string $contactValue The value of the contact.
	 * @param string $linkType The type of link (e.g., 'tel', 'email').
	 * @param string $base The base CSS class for the anchor element.
	 *
	 * @return void This method does not return a value.
	 */
	public static function generateContactLink(
		string $contactValue,
		string $linkType,
		string $base
	): void {
		if ( ! empty( $contactValue ) ) {
			$link = '';

			switch ( $linkType ) {
				case 'tel':
					$link = 'tel:';
					$icon = '#icon-phone';
					break;
				case 'email':
					$link = 'mailto:';
					$icon = '#icon-email';
					break;
				// Add more cases if needed for other types of links

				default:
					// Default case, you can customize or add more cases as needed
					break;
			}

			$link .= esc_attr( $contactValue );

			echo '<a href="' .
				 $link .
				 '" class="' .
				 esc_attr( $base ) .
				 '__' .
				 $linkType .
				 '">
                <svg class=""><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' .
				 $icon .
				 '"></use></svg>' .
				 esc_html( $contactValue ) .
				 '</a>';
		}
	}

	/**
	 * Renders a custom cart icon with a notification badge showing the number of items in the cart.
	 *
	 * @return void
	 */
	public static function cart_icon_with_notification(): void {
		// Get cart contents
		$cart_count = WC()->cart->get_cart_contents_count() ?: 0; ?>
		<?php if ( $cart_count > 0 ): ?>
			<span class="cart-count"><?php echo esc_html( $cart_count ); ?></span>
		<?php endif; ?>
		<?php
	}

	public static function yoast_seo_breadcrumb_append_links( $links ) {
		$custom_post_types = [
			'series'             => [
				'archive_url' => site_url( '/series/' ),
				'label'       => 'Series',
			],
			'product_innovation' => [
				'archive_url' => site_url( '/product-innovation/' ),
				'label'       => 'Product innovation',
			],
		];

		foreach ( $custom_post_types as $post_type => $breadcrumb ) {
			if ( is_singular( $post_type ) ) {
				$new_breadcrumb[] = [
					'url'  => $breadcrumb['archive_url'],
					'text' => $breadcrumb['label'],
				];

				array_splice( $links, 1, 0, $new_breadcrumb );
			}
		}

		return $links;
	}

	/**
	 * Get connected terms for a given post and taxonomy and display them as a UI list with links.
	 *
	 * @param int $post_id The ID of the post.
	 * @param string $taxonomy The taxonomy name.
	 *
	 * @return string HTML list of terms with links or an error message.
	 */
	public static function get_connected_terms_ui_list(
		int $post_id,
		string $taxonomy
	): string {
		// Ensure the post ID is an integer.
		$post_id = (int) $post_id;

		// Check if the post exists.
		if ( get_post_status( $post_id ) === false ) {
			return '<p>Error: The specified post does not exist.</p>';
		}

		// Ensure the taxonomy exists.
		if ( ! taxonomy_exists( $taxonomy ) ) {
			return '<p>Error: The specified taxonomy does not exist.</p>';
		}

		// Get the terms associated with the post and taxonomy.
		$terms = get_the_terms( $post_id, $taxonomy );

		// Check for errors or if no terms were found.
		if ( is_wp_error( $terms ) ) {
			return '<p>Error: ' . $terms->get_error_message() . '</p>';
		} elseif ( empty( $terms ) ) {
			return '<p>No terms found for this post.</p>';
		}

		// Build the HTML list.
		$output = '<ul class="connected-terms">';
		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term );
			if ( ! is_wp_error( $term_link ) ) {
				$output .=
					'<li><a href="' .
					esc_url( $term_link ) .
					'">' .
					esc_html( $term->name ) .
					'</a></li>';
			}
		}
		$output .= '</ul>';

		return $output;
	}

	public static function get_product_categories( array $categories, string $btn_text = 'Shop now' ): array {
		$data = [];

		$taxonomy = 'product_cat';
		$term     = 'product_categories';

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $categoryID ) {
				$category = get_term( $categoryID, $taxonomy );

				$thumbnail_id = get_term_meta(
					$category->term_id,
					'thumbnail_id',
					true
				);

				$catInfo = [
					'title'             => $category->name,
					'image_id'          => $thumbnail_id,
					'permalink'         => get_term_link( $categoryID, $taxonomy ),
					'short_description' => get_field( 'short_description', $category ),
					'button_text'       => $btn_text,
				];
				$data[]  = $catInfo;
			}
		}

		return $data;
	}

	public static function process_terms( $termIDs, $taxonomy ): array {
		$termsData = [];

		if ( ! empty( $termIDs ) ) {
			foreach ( $termIDs as $termID ) {
				$term = get_term( $termID, $taxonomy );

				$thumbnail_id = get_field( 'image', $term )['ID'] ?? 0;

				$taxonomy_image = wp_get_attachment_image_url(
					$thumbnail_id,
					'small'
				);

				if ( empty( $taxonomy_image ) ) {
					$taxonomy_image = get_field(
						'fallback_image',
						'options'
					)['sizes']['small'];
				}

				$short_description = get_field( 'summary', $term );

				$termInfo    = [
					'title'             => $term->name,
					'image_url'         => $taxonomy_image,
					'image_id'          => $thumbnail_id,
					'permalink'         => get_term_link( $termID, $taxonomy ),
					'short_description' => $short_description,
					'button_text'       => 'View the range',
				];
				$termsData[] = $termInfo;
			}
		}

		return $termsData;
	}

	public static function get_series( int $display_number = 12, bool $select_series = false, array $individual_series = [], array $categories = [], array $industry = [], int $page = 1, bool $show_load_more = false, int $page_ID = 0 ): array {
		$data = [];

		$query = Queries::series(
			$display_number,
			$select_series,
			$individual_series,
			$categories,
			$industry,
			$page
		);

		if ( $query->have_posts() ) {
			$total_pages          = $query->max_num_pages;
			$total_product_number = $query->found_posts;
			while ( $query->have_posts() ) {
				$query->the_post();
				$content = get_field( 'content', get_the_ID() );
				$summery = $content['summery'] ?? '';
				if ( strlen( $summery ) > 200 ) {
					$summery = substr( $summery, 0, 150 ) . '...';
				}
				$tag_line           = $content['tag_line'] ?? '';
				$properties         = get_field( 'properties' ) ?? [];
				$wheel_diameter     = $properties['wheel_diameter'] ?? '';
				$wheel_hardness     = $properties['wheel_hardness'] ?? '';
				$load_capacity      = $properties['load_capacity'] ?? '';
				$rolling_resistance =
					$properties['rolling_resistance'] ?? '';
				$temperature_range  = $properties['temperature_range'] ?? '';

				$properties = [
					'wheel_diameter'     => $wheel_diameter,
					'wheel_hardness'     => $wheel_hardness,
					'load_capacity'      => $load_capacity,
					'rolling_resistance' => $rolling_resistance,
					'temperature_range'  => $temperature_range,
				];

				$details        = [
					'image_url'   => Template::get_post_image_url(
						'small',
						get_the_ID()
					),
					'image_id'    => get_post_thumbnail_id(),
					'permalink'   => get_permalink(),
					'button_text' => 'View series',
					'content'     => [
						'series'      => get_the_title(),
						'title'       => $tag_line,
						'description' => $summery,
					],
					'properties'  => $properties,
					'tags'        => Template::get_custom_tags_by_post_id(
						get_the_ID(),
						'tags'
					),
				];
				$data['data'][] = $details;

			}
			// Reset post data after the custom query
			wp_reset_postdata();
			// Calculate the number of products to display
			$show_product_number = $display_number * $page;

			// Ensure that we don't exceed the total number of products
			$show_product_number = min(
				$total_product_number,
				$show_product_number
			);
			if ( $total_pages <= $page ) {
				$show_load_more = false;
			}

			$data['additional_data'] = [
				'total_page'           => $total_pages,
				'page'                 => $page,
				'page_ID'              => $page_ID,
				'show_product_number'  => $show_product_number,
				'total_product_number' => $total_product_number,
				'show_button'          => $show_load_more,
			];

		}
		if ( $data['data'] === null ) {
			$data['additional_data']['no_results'] = true;
		}

		return $data;

	}

	/**
	 * Retrieves the URL of the post thumbnail in the specified size.
	 *
	 * @param string $size Optional. The size of the post thumbnail. Default is 'small'.
	 * @param int|null $post_id Optional. The ID of the post. Default is null, which uses the current post ID.
	 *
	 * @return string The URL of the post thumbnail in the specified size, or an empty string if no image is found.
	 */
	public static function get_post_image_url(
		$size = 'small',
		$post_id = null
	): string {
		// Use current post ID if none is provided
		if ( ! $post_id ) {
			return '';
		}
		// Retrieve the URL of the post thumbnail in the specified size
		$image_details = wp_get_attachment_image_src(
			get_post_thumbnail_id( $post_id ),
			$size
		);
		if ( $image_details ) {
			return $image_details[0];
		}
		// Try to get a fallback image from the theme options if the post thumbnail is not available
		$fallback_image = get_field( 'fallback_image', 'options' );
		if ( $fallback_image && isset( $fallback_image['sizes'][ $size ] ) ) {
			return $fallback_image['sizes'][ $size ];
		}

		// Return an empty string if no image is found
		return '';
	}

	/**
	 * Retrieves custom tags associated with a post by its ID.
	 *
	 * @param int $post_id The ID of the post to retrieve custom tags for.
	 * @param string $taxonomy The taxonomy to retrieve tags from.
	 *
	 * @return WP_Error|array Returns an array of custom tags on success and \WP_Error on failure.
	 */
	public static function get_custom_tags_by_post_id(
		int $post_id
	): WP_Error|array {
		$taxonomies    = [ 'categories', 'industry' ]; // Ensure 'category' is used if Yoast is involved
		$primary_terms = [];

		foreach ( $taxonomies as $taxonomy ) {
			$terms = wp_get_post_terms( $post_id, $taxonomy, [
				'fields' => 'all',
			] );

			if ( is_wp_error( $terms ) ) {
				return $terms; // Return the WP_Error object if there's an error
			}

			foreach ( $terms as $term ) {
				$term_link = get_term_link( $term );
				if ( ! is_wp_error( $term_link ) ) {
					$primary_terms[] =
						'<a href="' .
						esc_url( $term_link ) .
						'">' .
						esc_html( $term->name ) .
						'</a>';
					break;
				}
			}
		}

		return $primary_terms;
	}

	/**
	 * @param int $display_number
	 * @param bool $select_products
	 * @param array $individual_products
	 * @param array $filters
	 * @param string $sort_by
	 * @param int $page
	 * @param array $tax
	 * @param array $single
	 * @param bool $show_load_more
	 * @param bool $initial
	 *
	 * @return array
	 */
	public static function get_AUT_products( int $display_number = 8, bool $select_products = false, array $individual_products = [], array $filters = [], string $sort_by = '', int $page = 1, array $tax = [], array $single = [], bool $show_load_more = false, int $page_ID = 0 ): array {
		$data                 = [];
		$total_pages          = 0;
		$total_product_number = 0;


		$posts = Queries::products(
			$display_number,
			$select_products,
			$individual_products,
			$filters,
			$sort_by,
			$page,
			$tax,
			$single
		);


		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$series      = '';
				$fixing_type = '';
				$posts->the_post();
				$total_pages          = $posts->max_num_pages;
				$total_product_number = $posts->found_posts;
				$image_url            = wp_get_attachment_image_src(
					get_post_thumbnail_id( get_the_id() ),
					'small'
				);
				if ( $image_url ) {
					$image_url = $image_url[0];
				} else {
					$fallback_image = get_field(
						'fallback_image',
						'options'
					);
					if (
						$fallback_image &&
						isset( $fallback_image['sizes']['small'] )
					) {
						$image_url = $fallback_image['sizes']['small'];
					} else {
						$image_url = '';
					}
				}

				$product_id = get_the_ID();


				$product = wc_get_product( $product_id );
				if ( $product ) {

					// Retrieve product attributes
					$attributes = $product->get_attributes();
					// Retrieve and process 'series' custom field
					$assign_series = get_field( 'series', $product_id );

					if ( $assign_series && is_array( $assign_series ) ) {
						foreach ( $assign_series as $id ) {
							$series = get_the_title( $id ) ?: '';
							break; // Assuming you only need the title of the first series
						}
					}
					// Check if 'pa_fixing-type' attribute exists
					if ( isset( $attributes['pa_fixing-type'] ) ) {
						$attribute = $attributes['pa_fixing-type'];

						// Check if the attribute is a taxonomy and retrieve its values
						if ( $attribute->is_taxonomy() ) {
							$values      = wc_get_product_terms(
								$product_id,
								$attribute->get_name(),
								[ 'fields' => 'names' ]
							);
							$fixing_type = implode( ', ', $values );
						} else {
							$fixing_type = implode(
								', ',
								$attribute->get_options()
							);
						}

						// Special case for 'Wheel Only' fixing type
						if (
							'Wheel Only' === $fixing_type &&
							isset( $attributes['pa_bore-type'] )
						) {
							$bore_type = $attributes['pa_bore-type'];

							// Check if bore type is a taxonomy and retrieve its values
							if ( $bore_type->is_taxonomy() ) {
								$bore_values     = wc_get_product_terms(
									$product_id,
									$bore_type->get_name(),
									[ 'fields' => 'names' ]
								);
								$bore_type_value = implode(
									', ',
									$bore_values
								);
							} else {
								$bore_type_value = implode(
									', ',
									$bore_type->get_options()
								);
							}

							$fixing_type .= ' - ' . $bore_type_value;
						}
					}

					$details        = [
						'image_url'   => $image_url,
						'image_id'    => get_post_thumbnail_id(),
						'permalink'   => get_permalink(),
						'button_text' => 'View products',
						'content'     => [
							'title'       => get_the_title(),
							'series'      => $series,
							'summery'     => $content['summery'] ?? '',
							'description' => $product->get_short_description() ?? '',
							'fixing_type' => $fixing_type,
						],
						'tags'        => [],
					];
					$data['data'][] = $details;
				}
			}
			wp_reset_postdata();
			// Calculate the number of products to display
			$show_product_number = $display_number * $page;

			// Ensure that we don't exceed the total number of products
			$show_product_number = min(
				$total_product_number,
				$show_product_number
			);
			if ( ! empty( $results ) ) {
				$show_product_number = $show_product_number * $results;
			}

			if ( $total_pages <= $page ) {
				$show_load_more = false;
			}


			$data['additional_data'] = [
				'total_page'           => $total_pages,
				'show_product_number'  => $show_product_number,
				'total_product_number' => $total_product_number,
				'tax'                  => $tax,
				'show_button'          => $show_load_more,
				'filters'              => $filters,
				'sort_by'              => $sort_by,
				'page_ID'              => $page_ID,
				'page'                 => $page,
			];
		}

		if ( $data['data'] === null ) {
			$data['additional_data']['no_results'] = true;
		}

		return $data;
	}

}
