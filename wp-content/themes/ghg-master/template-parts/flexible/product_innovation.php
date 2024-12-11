<?php
/**
 * Template file for displaying the product innovation grid
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Queries;

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

$base    = 'product-innovation';
$content = get_sub_field( 'content' );
$options = get_sub_field( 'options' );

$display_number = $options['number_of_posts'] ?: 9;
$categories     = '';
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

?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php get_template_part( 'template-parts/content-block', null, [
			'data' => [
				'base'    => $base,
				'content' => $content,
			],
		] ); ?>
		<?php
		if ( $posts->have_posts() ):
			echo '<div class="' . esc_attr( $base ) . '__grid">';
			while ( $posts->have_posts() ):
				$posts->the_post();
				get_template_part( 'template-parts/cards/card-news-post', null, [ 'button_text' => 'Read more' ] );
			endwhile;
			wp_reset_postdata();
			echo '</div>';
		endif;
		?>
	</div>

</section>
