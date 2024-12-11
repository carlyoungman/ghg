<?php
/**
 * Template single promo
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if (!defined('ABSPATH')):
	exit();
endif;
$base = 'image-with-content';
$image = $args['data']['image'] ?? '';
$content = $args['data']['content'] ?? '';
$headline = $args['data']['headline'] ?? '';
$items = $args['data']['items'] ?? '';
$class = $args['data']['class'] ?? '';
?>

<section class="<?php echo esc_attr($base) .
	' ' .
	esc_attr($base) .
	$class; ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div>
				<div class="<?php echo esc_attr($base); ?>__image-wrap">
					<?php Template::get_image_with_fallback($base, $image, 'small', true); ?>
				</div>
			</div>
			<div>
				<article class="<?php echo esc_attr($base); ?>__article">
					<h3><?php echo wp_kses_post($headline); ?></h3>
					<p><?php echo wp_kses_post($content); ?></p>
					<?php echo $items; ?>
				</article>
			</div>
		</div>

	</div>
</section>
