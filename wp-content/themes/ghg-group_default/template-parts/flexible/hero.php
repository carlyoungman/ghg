<?php
/**
 * Template file for displaying the hero component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base           = 'hero';
$desktop        = get_sub_field( 'desktop_image' )['id'];
$mobile         = get_sub_field( 'mobile_image' )['id'];
$content        = get_sub_field( 'content' );
$options        = get_sub_field( 'options' );
$display_ticker = $options['display_ticker'];
$ticket_text    = $options['ticker-text'];
$options_array  = [ [ 'layout', $base . '--layout', true ], [ 'super_size', $base . '--super-size-text' ] ]


?>
<section class="<?php echo esc_attr( $base );
Template::apply_classes( $options_array, $options ) ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inline__inner">
		<div class="<?php echo esc_attr( $base ); ?>__image-wrap">
			<?php Template::get_image_with_fallback( $base, $mobile, 'medium', true ); ?>
			<?php Template::get_image_with_fallback( $base, $desktop, 'hero', true ); ?>
		</div>
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
		</div>
		<?php if ( true === $display_ticker ): ?>
			<div class="<?php echo esc_attr( $base ); ?>__ticker">
				<div class="<?php echo esc_attr( $base ); ?>__ticker__inner">
					<?php for ( $i = 0; $i < 5; $i ++ ): ?>
						<div class="<?php echo esc_attr( $base ); ?>__ticker__item">
							<p><?php echo esc_html( $ticket_text ) ?> </p>
						</div>
						<div class="<?php echo esc_attr( $base ); ?>__ticker__item--line"></div>
					<?php endfor; ?>
				</div>

			</div>
		<?php endif; ?>
	</div>
</section>
