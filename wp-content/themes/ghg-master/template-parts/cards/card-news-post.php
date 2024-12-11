<?php
/**
 * Product Card
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base        = 'news-and-media-card';
$button_text = $args['button_text'] ?: 'View Case Study';
?>
<div class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__image-wrap">
		<a href="<?php the_permalink(); ?>">
			<?php Template::get_image_with_fallback(
				$base,
				get_post_thumbnail_id(),
				'small',
				true
			); ?>
		</a>
		<svg class="<?php echo esc_attr(
			$base
		); ?>__image-cut" viewBox="0 0 78 84" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path d="M78 84L0 84L78 0L78 84Z" fill="#E8AF5F"/>
		</svg>
	</div>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<h5 class="<?php echo esc_attr(
			$base
		); ?>__headline"><?php echo the_title(); ?></h5>
		<span class="<?php echo esc_attr(
			$base
		); ?>__excerpt"><?php the_excerpt(); ?></span>
		<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr(
			$base
		); ?>__link">
			<?php echo esc_html( $button_text ); ?>
		</a>
	</article>
</div>
