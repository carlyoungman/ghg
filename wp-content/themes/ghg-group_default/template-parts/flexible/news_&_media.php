<?php
/**
 * Template file for News and Media component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;
$base    = 'news-and-media';
$content = get_sub_field( 'content' );
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

		<div id="news-and-events--react"></div>
	</div>
</section>
