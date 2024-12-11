<?php
/**
 * Template file for displaying the AUT Series
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;
$base    = 'series';
$content = get_sub_field( 'content' );
$options = get_sub_field( 'options' ) ?: [];
$tax     = get_queried_object()->taxonomy ?: [];

$display_number = $options['series_number'] ?? 12;
$show_load_more = false;

if ( $display_number === 'all' ) {
	$display_number = 15;
	$show_load_more = true;
}

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
	$industry[] = get_queried_object()->term_id;
}
if ( $tax === 'categories' ) {
	$categories[] = get_queried_object()->term_id;
}
if ( ! empty( $tax ) ) {
	$display_number = 100;
}


$data = Template::get_series( $display_number, $select_series, $individual_series, $categories, $industry, 1, $show_load_more, get_the_id() );

?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php get_template_part( 'template-parts/content-block', null, [
			'data' => [
				'base'                => $base,
				'content'             => $content,
				'display_breadcrumbs' => true,
			],
		] ); ?>
		<div id="AUTSeriesDetails"></div>
		<?php if ( ! empty( $data ) ): ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php foreach ( $data['data'] as $data ):
					get_template_part( 'template-parts/cards/card-aut-product', null, [ 'data' => $data ] );
				endforeach;
				?>
			</div>
		<?php endif; ?>
		<div id="<?php echo esc_attr( $base ); ?>--react"></div>
		<div id="AUTSeriesLoadMoreButton"></div>
</section>
