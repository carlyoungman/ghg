<?php
/**
 * Template file for displaying the AUT products
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;
$base                = 'AUT-products';
$content             = get_sub_field( 'content' );
$options             = get_sub_field( 'options' );
$display_filters     = $options['display_filters'] ?? false;
$display_number      = $options['product_number'] ?? 9;
$select_products     = $options['select_products'] ?? false;
$individual_products = [];
$categories          = $options['categories'] ?? [];
$industry            = $options['industry'] ?? [];
$tax                 = [];
$single              = $args['data']['single'] ?? [];
if ( true === $display_filters ) {
	$display_number = 8;
}

if ( true === $select_products ) {
	$individual_products = $options['individual_products'] ?? [];
}


if ( isset( $_GET['results'] ) ) {
	$results_value  = sanitize_text_field( $_GET['results'] );
	$display_number = $display_number * $results_value;
}

if ( false === $display_filters ) {

	if ( ! empty( $categories ) ) {
		$tax = [ 'categories', $categories ];
	}
	if ( ! empty( $industry ) ) {
		$tax = [ 'industry', $industry ];
	}
}

if ( is_singular( 'series' ) && empty( $single ) ) {
	$single         = [ 'series', get_the_ID() ];
	$display_number = 1000;
}


$data = Template::get_AUT_products( $display_number,
	$select_products,
	$individual_products,
	[],
	'',
	1,
	$tax,
	$single,
	true,
	get_the_id() );
?>
<section class="<?php
echo esc_attr( $base );
if ( true === $display_filters ):
	echo ' ' . esc_attr( $base ) . '--filters';
endif;
?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php get_template_part( 'template-parts/content-block', null, [
			'data' => [
				'base'                => $base,
				'content'             => $content,
				'display_breadcrumbs' => true,
			],
		] );
		?>
		<div class="<?php echo esc_attr( $base ); ?>__grid-master">
			<?php if ( true === $display_filters ):
				echo '<div id="AUTProductFilters"></div>';
			endif; ?>
			<div>
				<div id="AUTProductsDetails"></div>
				<?php if ( ! empty( $data ) ): ?>
					<div class="<?php echo esc_attr( $base ); ?>__grid">
						<?php foreach ( $data['data'] as $data ):
							get_template_part( 'template-parts/cards/card-aut-product', null, [ 'data' => $data ] );
						endforeach;
						?>
					</div>
				<?php endif; ?>
				<div id="<?php echo esc_attr( $base ); ?>--react"></div>
				<div id="AUTProductsLoadMoreButton"></div>
			</div>

		</div>
	</div>
</section>
