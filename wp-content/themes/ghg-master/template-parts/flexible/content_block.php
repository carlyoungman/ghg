<?php
/**
 * Template file for displaying the content block
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base          = 'section-content';
$options       = get_sub_field( 'options' );
$content       = get_sub_field( 'content' );
$options_array = [ [ 'max_width', $base . '--max-width' ], [ 'center_align', $base . '--center-align' ] ]
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
		?>
	</div>
</section>
