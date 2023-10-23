<?php
/**
 * Template file for displaying the Current vacancies component
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

$base          = 'current-vacancies';
$content       = get_sub_field( 'content' );
$cards         = get_sub_field( 'Cards' );
$options       = get_sub_field( 'options' );
$options_array = [ [ 'background', $base . '--background-steal' ] ]
?>
<section class="<?php echo esc_attr( $base );
Template::apply_classes( $options_array, $options ) ?>">
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
		if ( ! empty( $cards ) ) : ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php
				foreach ( $cards as $card ) :
					get_template_part(
						'template-parts/cards/card-vacancy',
						null,
						[
							'data' => [
								'card' => $card,
							],
						]
					);
				endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
