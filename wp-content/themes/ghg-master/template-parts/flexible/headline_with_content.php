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

$base     = 'headline-with-content';
$content  = get_sub_field( 'content' );
$headline = get_sub_field( 'headline' );
$options  = get_sub_field( 'options' );

?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<div class="<?php echo esc_attr( $base ); ?>__grid">
			<div>
				<?php if ( ! empty( $headline ) ): ?>
					<h2 class="<?php echo esc_attr( $base ); ?>__headline"><?php echo wp_kses_post( $headline ) ?></h2>
				<?php endif; ?>
			</div>
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
		</div>

	</div>
</section>
