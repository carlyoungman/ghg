<?php
/**
 * Template file for case studies component
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Queries;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;
$base           = 'case-studies';
$content        = get_sub_field( 'content' );
$options        = get_sub_field( 'options' );
$sectors        = [];
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

?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php
		get_template_part(
			'template-parts/content-block',
			null,
			[
				'data' => [
					'base'    => $base,
					'content' => $content,
				],
			]
		);
		?>
		<?php
		if ( $posts->have_posts() ):
			echo '<div class="' . esc_attr( $base ) . '__grid">';
			while ( $posts->have_posts() ):
				$posts->the_post();
				get_template_part( 'template-parts/cards/card-news-post', null, [ 'button_text' => 'View Case Study' ] );
			endwhile;
			wp_reset_postdata();
			echo '</div>';
		endif;
		?>
	</div>
</section>
