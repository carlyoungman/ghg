<?php
/**
 * Template file for displaying the key points component
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

$base = 'cards-grid';

$content = get_sub_field( 'content' );
$cards   = get_sub_field( 'Cards' ); ?>

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
		if ( ! empty( $cards ) ) : ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php
				foreach ( $cards as $card ) :
					get_template_part(
						'template-parts/cards/card-grid',
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
