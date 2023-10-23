<?php
/**
 * Template file for displaying inline forms
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;
$base    = 'inline-forms';
$content = get_sub_field( 'content' );
$form    = get_sub_field( 'form' );

?>


<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<div class="<?php echo esc_attr( $base ); ?>__grid">
			<div>
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
			</div>
			<div>
				<?php echo do_shortcode( '[formidable id="' . $form['value'] . '"]' ) ?>
			</div>
		</div>
	</div>
</section>
