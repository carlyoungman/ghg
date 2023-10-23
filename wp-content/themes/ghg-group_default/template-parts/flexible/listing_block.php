<?php
/**
 * Template file for displaying the listing block component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base          = 'listing-block';
$options       = get_sub_field( 'options' );
$content       = get_sub_field( 'content' );
$list          = get_sub_field( 'list' );
$options_array = [ [ 'background', $base . '--background-steal' ] ]
?>
<section class="<?php echo esc_attr( $base );
Template::apply_classes( $options_array, $options ) ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<div class="<?php echo esc_attr( $base ); ?>__background">
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
			if ( ! empty( $list ) ) : ?>
				<ul class="<?php echo esc_attr( $base ); ?>__list">
					<?php
					foreach ( $list as $item ):
						echo '<li class="' . esc_attr( $base ) . '__item">' . $item['list_item'] . '</li>';
					endforeach; ?>
				</ul>
			<?php endif;
			?>
		</div>
	</div>
</section>
