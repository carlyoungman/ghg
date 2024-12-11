<?php
/**
 * Product Categories Card
 *
 * @package YOUR_THEME_NAME
 */

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base              = 'card-product-categories';
$data              = $args['data'] ?? [];
$title             = $data['title'] ?? '';
$image_id          = $data['image_id'] ?? '';
$permalink         = $data['permalink'] ?? '';
$short_description = $data['short_description'] ?? '';
$button_text       = $data['button_text'] ?? '';
?>

<div class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__image-wrap">
		<a href="<?php echo esc_url( $permalink ); ?>">
			<?php Template::get_image_with_fallback(
				$base,
				$image_id,
				'small',
				true
			); ?>
		</a>
	</div>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<h5 class="<?php echo esc_attr( $base ); ?>__headline">
			<?php echo wp_kses_post( $title ); ?>
		</h5>
		<p class="<?php echo esc_attr( $base ); ?>__description">
			<?php echo wp_kses_post( $short_description ); ?>
		</p>
		<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo esc_attr( $base ); ?>__button">
			<?php echo esc_html( $button_text ); ?>
		</a>
	</article>
</div>
