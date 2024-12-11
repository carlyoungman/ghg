<?php
/**
 * Template file for displaying the slider section component
 *
 * @package ED_BOILERPLATE_THEME
 */
if (!defined('ABSPATH')):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'slider-section';
$options = get_sub_field('options');
$content = get_sub_field('content');
$entries = get_sub_field('Entries');
?>
<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<?php get_template_part('template-parts/content-block', null, [
  	'data' => [
  		'base' => $base,
  		'content' => $content,
  	],
  ]); ?>
		<?php if ($entries): ?>
			<div class="<?php echo esc_attr($base); ?>__slider">
				<div class="<?php echo esc_attr("{$base}__track"); ?>" data-glide-el="track">
					<div class="<?php echo esc_attr($base); ?>__grid">
						<?php foreach ($entries as $entry): ?>
							<div class="<?php echo esc_attr($base); ?>__card">
								<div class="<?php echo esc_attr($base); ?>__image-wrap">
									<?php Template::get_image_with_fallback(
         	$base,
         	$entry['image']['id'] ?: 0,
         	'thumbnail',
         	true
         ); ?>
								</div>
								<article class="<?php echo esc_attr($base); ?>__article">
									<?php if (!empty($entry['Text'])):
         	echo '<p class="' .
         		esc_attr($base) .
         		'__text">' .
         		esc_html($entry['Text']) .
         		'</p>';
         endif; ?>

									<?php Template::build_button('', $entry['link'], false, true); ?>
								</article>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="<?php echo esc_attr($base); ?>__controls" data-glide-el="controls">
						<svg data-glide-dir="<" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
								  stroke-linejoin="round"/>
						</svg>
						<svg data-glide-dir=">" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5" stroke-linecap="round"
								  stroke-linejoin="round"/>
						</svg>

					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
