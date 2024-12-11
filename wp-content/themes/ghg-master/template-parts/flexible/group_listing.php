<?php
/**
 * Template file for displaying the group listing component
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

$base = 'group-listing';

$content = get_sub_field( 'content' );
$group   = get_sub_field( 'group' ); ?>

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
		if ( ! empty( $group ) ) : ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php
				foreach ( $group as $card ) :
					get_template_part(
						'template-parts/cards/card-group-listing',
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
		?>
	</div>
</section>
