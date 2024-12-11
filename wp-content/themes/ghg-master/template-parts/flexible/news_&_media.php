<?php
/**
 * Template file for News and Media component
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Queries;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;
$base     = 'news-and-media';
$content  = get_sub_field( 'content' );
$settings = get_sub_field( 'options' );

$display_number = $settings['number_of_posts'] ?: 12;
if ( $display_number === 'All' ) {
	$display_number = 12;
}

$categories          = $settings['filter_by_category'] ?: [];
$selected_posts_flag = $settings['select_posts'] ?: false;
$individual_posts    = $settings['individual_posts'] ?: [];
$posts               = Queries::news_and_media( $display_number, $categories, $selected_posts_flag, $individual_posts, 1 );
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
			?>
			<div class="<?php echo esc_attr( $base ); ?>__grid <?php echo esc_attr( $base ); ?>__grid--initial">
				<?php
				while ( $posts->have_posts() ):
					$posts->the_post();
					get_template_part( 'template-parts/cards/card-news-post', null, [ 'button_text' => 'Read more' ] );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php
		endif;
		?>
		<div id="news-and-events--react"></div>
	</div>
</section>
