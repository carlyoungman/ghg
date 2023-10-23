<?php
/**
 * Template file for displaying the key points component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base          = 'key-points';
$options       = get_sub_field( 'options' );
$content       = get_sub_field( 'content' );
$key_points    = get_sub_field( 'key_points' );
$options_array = [ [ 'secondary_layout', $base . '--secondary-layout' ] ]
?>
<section class="<?php echo esc_attr( $base );
Template::apply_classes( $options_array, $options ) ?> has-background">
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
		if ( ! empty( $key_points ) ) : ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php
				foreach ( $key_points as $card ) :
					get_template_part(
						'template-parts/cards/card-key-point',
						null,
						[
							'data' => [
								'card' => $card,
							],
						]
					);
				endforeach; ?>
			</div>
		<?php endif;
		Template::build_buttons( $base, $content['buttons'] ?: [], true );
		?>
	</div>
</section>
