<?php
/**
 * Template file for displaying the hero component
 *
 * @package ED_BOILERPLATE_THEME
 */
if (!defined('ABSPATH')):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'image-with-content';

$options = get_sub_field('options') ?? [];
$content = get_sub_field('content') ?? [];
$image = get_sub_field('image')['id'] ?? 0;
$options_array = [
	['layout', $base . '--layout', true],
	['image_effect', $base . '--effect', true],
];
?>
<section class="<?php
echo esc_attr($base);
Template::apply_classes($options_array, $options);
?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div>
				<div class="<?php echo esc_attr($base); ?>__image-wrap">
					<?php Template::get_image_with_fallback($base, $image, 'small', true); ?>
				</div>
			</div>
			<div>
				<?php get_template_part('template-parts/content-block', null, [
    	'data' => [
    		'base' => $base,
    		'content' => $content,
    	],
    ]); ?>
			</div>
		</div>

	</div>
</section>
