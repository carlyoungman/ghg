<?php

namespace BOILERPLATE_THEME\Core\Module;

/**
 * Class Woocommerce
 *
 * @package BOILERPLATE_THEME\Core\Module
 */
class Woocommerce {
	/**
	 * Renders custom content before the product tabs.
	 *
	 * @return void
	 */
	public static function custom_content_before_product_tabs(): void {
		$base                = 'product-details';
		$product_information = get_field( 'product_information' );
		$dimensions          = get_field( 'dimensions' );
		$key_features        = get_field( 'key_features' );
		?>

		<div class="<?php echo esc_attr( $base ); ?> has-background">
			<div class="<?php echo esc_attr( $base ); ?>__inner">
				<div class="<?php echo esc_attr( $base ); ?>__grid">
					<h6 class="<?php echo esc_attr( $base ); ?>__headline">Product Details</h6>
					<div class="<?php echo esc_attr( $base ); ?>__content">
						<?php if ( ! empty( $product_information ) ): ?>
							<article class="<?php echo esc_attr( $base ); ?>__article">
								<p class="<?php echo esc_attr(
									$base
								); ?>__content-headline">Product information</p>
								<?php echo $product_information; ?>
							</article>
						<?php endif; ?>
						<?php if ( ! empty( $dimensions ) ): ?>
							<article class="<?php echo esc_attr( $base ); ?>__article">
								<p class="<?php echo esc_attr( $base ); ?>__content-headline">Dimensions</p>
								<?php echo $dimensions; ?>
							</article>
						<?php endif; ?>
						<?php if ( ! empty( $key_features ) ): ?>
							<article class="<?php echo esc_attr( $base ); ?>__article">
								<p class="<?php echo esc_attr( $base ); ?>__content-headline">Key Features</p>
								<?php echo $key_features; ?>
							</article>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Renders the price of a product with and without tax.
	 *
	 * @return void
	 */
	public static function display_price_with_and_without_tax(): void {
		global $product;

		// Get prices
		$regular_price = wc_format_decimal(
			wc_get_price_including_tax( $product ),
			2
		);
		$sale_price    = wc_format_decimal(
			wc_get_price_excluding_tax( $product ),
			2
		);
		// Display prices
		echo '<div id="single-product-toggle--react"></div>';
		echo '<h5 class="card-product__price">' .
			 '<span>£' . wc_format_decimal( wc_get_price_excluding_tax( $product ), 2 ) .
			 '<span class="card-product__vat">Ex VAT</span></span>' .
			 '<span>£' . wc_format_decimal( wc_get_price_including_tax( $product ), 2 ) .
			 '<span class="card-product__vat">Inc VAT</span></span>' .
			 '</h5>';
	}

	/**
	 * Renders a random product testimonial.
	 *
	 * This method retrieves an array of testimonials from the 'testimonials' field using get_field().
	 * If no testimonials are available or the testimonials variable is not an array, the method returns void.
	 * Otherwise, a random testimonial is selected and the testimonial and quote values are extracted from it.
	 * The get_template_part() function is then called with 'template-parts/flexible/testimonials' as the template name and passing the testimonial and quote values as the data array.
	 *
	 * @return void
	 */
	public static function show_product_testimonials(): void {
		$testimonials = get_field( 'testimonials' );

		// Check if testimonials are available
		if ( ! $testimonials || ! is_array( $testimonials ) ) {
			return;
		}

		// Choose a random testimonial
		$random_index       = array_rand( $testimonials );
		$random_testimonial = $testimonials[ $random_index ];

		$testimonial = $random_testimonial['testimonial'];
		$quote       = $random_testimonial['quote'];

		get_template_part( 'template-parts/flexible/testimonials', null, [
			'data' => [
				'testimonial' => $testimonial,
				'quote'       => $quote,
			],
		] );
	}

	/**
	 * Displays related products on the product page.
	 *
	 * @return void
	 */
	public static function show_related_products(): void {
		global $product;
		$products = Queries::related_products(
			$product->get_id()
		)->get_products();
		$base     = 'related-products';
		if ( ! empty( $products ) ): ?>
			<div class="<?php echo esc_attr( $base ); ?>">
				<article class="<?php echo esc_attr( $base ); ?>__article">
					<h6 class="<?php echo esc_attr( $base ); ?>__headline">Customers also bought</h6>
				</article>
				<div class="<?php echo esc_attr( $base ); ?>__grid">
					<?php foreach ( $products as $product ):
						get_template_part( 'template-parts/cards/card-product', null, [
							'data' => [
								'product' => $product,
							],
						] );
					endforeach; ?>
				</div>
			</div>
		<?php endif;
		wp_reset_postdata();
	}

	/**
	 * Disables the WooCommerce taxonomies.
	 *
	 * This method unregisters the 'product_cat' and 'product_tag' taxonomies
	 * used by WooCommerce, effectively disabling them.
	 *
	 * @return void
	 */
	public static function disable_woocommerce_taxonomies(): void {
		if ( 'AUT' === get_bloginfo( 'name' ) ) {
			unregister_taxonomy( 'product_cat' );
			unregister_taxonomy( 'product_tag' );
		}
	}


}
