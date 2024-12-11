<?php
/**
 * Template file for a sector component
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Queries;

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;
$base           = 'sectors';
$content        = get_sub_field( 'content' );
$options        = get_sub_field( 'options' );
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
				get_template_part( 'template-parts/cards/card-news-post', null, [
					'button_text' => 'View More',
				] );
			endwhile;
			wp_reset_postdata();
			echo '</div>';
		endif;
		?>
	</div>
</section>
