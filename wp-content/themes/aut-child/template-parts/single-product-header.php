<?php
/**
 * Template Single series properties
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if (!defined('ABSPATH')):
	exit();
endif;
$base = 'single-product-header';
$product_id = get_the_ID();
$product = wc_get_product($product_id);
$featured_image_id = get_post_thumbnail_id($product_id);
$data_sheet = get_field('data_sheet') ?: [];

if (!empty($data_sheet)):
	$data_sheet['title'] = 'Download Series Data Sheet';
endif;
$cad_model = get_field('3d_cad_model') ?: [];
$call_to_actions = get_field('product_call_to_actions') ?: [];
?>

<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div class="<?php echo esc_attr($base); ?>__image-wrap">
				<?php Template::get_image_with_fallback(
    	$base,
    	$featured_image_id,
    	'medium',
    	true
    ); ?>
			</div>
			<div class="<?php echo esc_attr($base); ?>__content-wrap">
				<article class="<?php echo esc_attr($base); ?>__article">
					<h1 class="h3"><?php the_title(); ?></h1>
					<?php if ($product->get_short_description()): ?>
						<p><?php echo $product->get_short_description(); ?></p>
					<?php endif; ?>
					<?php Template::build_button($base, $data_sheet, false, true); ?>
					<?php Template::build_button($base, $cad_model, false, true); ?>
					<?php Template::build_buttons($base, $call_to_actions, true); ?>
				</article>
			</div>
		</div>
	</div>
</section>
