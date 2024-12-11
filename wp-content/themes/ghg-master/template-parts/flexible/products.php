<?php
/**
 * Template file for displaying the product grid
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Queries;

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

$base    = 'products';
$content = get_sub_field( 'content' );
$options = get_sub_field( 'options' ) ?: [];

$display_number      = $options['display_number'] ?: 12;
$select_products     = $options['select_products'] ?: false;
$individual_products = $options['individual_products'] ?: [];
$filters             = $options['filters'] ?: [];
$page                = $options['page'] ?: 1;
$tax                 = $options['tax'] ?: [];
$single              = [];
$posts               = Queries::products( $display_number, $select_products, $individual_products, $filters, '', $page, $tax, $single );


?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php get_template_part( 'template-parts/content-block', null, [
			'data' => [
				'base'                 => $base,
				'content'              => $content,
				'display_breadcrumbs'  => true,
				'display_price_toggle' => true
			],
		] ); ?>
		<?php if ( ! empty( $content['content'] ) ): ?>
			<span class="<?php echo esc_attr( $base ); ?>__line"></span>
		<?php endif; ?>

		<?php
		if ( $posts->have_posts() ):
			?>
			<div class="<?php echo esc_attr( $base ); ?>__grid products-grid">
				<?php
				while ( $posts->have_posts() ):
					$posts->the_post();
					$product      = wc_get_product( get_the_ID() );
					$product_data = [
						'id'                => get_the_ID(),
						'name'              => $product->get_name(),
						'price'             => $product->get_price(),
						'regular_price'     => $product->get_regular_price(),
						'sale_price'        => $product->get_sale_price(),
						'description'       => $product->get_description(),
						'short_description' => $product->get_short_description(),
						'image'             => wp_get_attachment_url( $product->get_image_id() ),
						'stock_status'      => $product->get_stock_status(),
						'categories'        => wp_get_post_terms( $product->get_id(), 'product_cat', [ 'fields' => 'names' ] ),
						'tags'              => wp_get_post_terms( $product->get_id(), 'product_tag', [ 'fields' => 'names' ] ),
					];
					get_template_part( 'template-parts/cards/card-product', null, [
						'data' => [
							'product' => $product,
						],
					] );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php
		endif;
		?>
		<div id="<?php echo esc_attr( $base ); ?>--react"></div>
	</div>
</section>


