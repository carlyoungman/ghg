<?php
/**
 * The template for displaying Product Category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
$taxonomy            = get_queried_object() ?: [];
$base                = 'tax-product';
$content['headline'] = $taxonomy->name ?: null;
$content['content']  = '<p>' . $taxonomy->description . '</p>' ?: null;
$filter              = $_GET['content'] ?? null;

$args = [
	'post_type'      => 'product',
	'posts_per_page' => 1000,
	'post_status'    => 'publish',
	'paged'          => 1,
];

if ( ! empty( $taxonomy->term_id ) ) {
	$args['tax_query'][] = [
		'taxonomy' => 'product_cat',
		'field'    => 'term_id',
		'terms'    => $taxonomy->term_id,
	];
}

$posts = new WP_Query( $args );

?>
	<section class="<?php echo esc_attr( $base ); ?>">
		<div class="<?php echo esc_attr( $base ); ?>__inner">
			<?php get_template_part( 'template-parts/content-block', null, [
				'data' => [
					'base'                 => $base,
					'content'              => $content,
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
							'id'                => $product->get_id(),
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
		</div>
	</section>
<?php Template::get_flexible_components(); ?>
<?php get_footer();
