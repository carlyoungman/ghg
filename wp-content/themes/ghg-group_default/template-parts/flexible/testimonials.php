<?php
/**
 * Template file for displaying the testimonial component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base        = 'testimonials';
$options     = get_sub_field( 'options' );
$testimonial = get_sub_field( 'testimonial' );
$quote       = get_sub_field( 'quote' );

?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<div class="<?php echo esc_attr( $base ); ?>__wrapper">
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<div>
					<svg class="<?php echo esc_attr( $base ); ?>__arrow" viewBox="0 0 69 62"
						 fill="none" xmlns="http://www.w3.org/2000/svg">
						<g clip-path="url(#clip0_3_2107)">
							<path
								d="M35.6873 54.3222L60.4813 33.4687C61.4312 32.6699 61.9555 31.6131 61.9555 30.4813C61.9555 29.3496 61.4312 28.2928 60.4813 27.494L35.7268 6.67377L43.6617 0L69 21.3111V38.4283C69 39.1273 68.6735 39.7764 68.0898 40.2756L43.4045 61.0376L35.6873 54.3222Z"
								fill="#E8AF5F"/>
							<path
								d="M0 54.3222L24.7941 33.4687C26.7531 31.8211 26.7531 29.1416 24.7941 27.494L0.0395756 6.67377L7.97448 0L33.3127 21.3111V38.4283C33.3127 39.1273 32.9862 39.7764 32.4025 40.2756L7.71724 61.0376L0 54.3222Z"
								fill="#E8AF5F"/>
						</g>
						<defs>
							<clipPath id="clip0_3_2107">
								<rect width="69" height="61.0376" fill="white"/>
							</clipPath>
						</defs>
					</svg>
					<?php if ( $testimonial['title'] ): ?>
						<p class="<?php echo esc_attr( $base ); ?>__text"><?php echo esc_html( $testimonial['title'] ) ?></p>
					<?php endif; ?>
					<?php Template::get_image_with_fallback( $base, $testimonial['icon']['id'], 'thumbnail', true ); ?>
				</div>
				<div>
					<?php
					get_template_part(
						'template-parts/content-block',
						null,
						[
							'data' => [
								'base'    => $base,
								'content' => $quote,
							],
						]
					);
					?>
				</div>
			</div>
			<span class="<?php echo esc_attr( $base ); ?>__after"></span>
		</div>
	</div>
</section>
