<?php
/**
 * Template file for displaying the image with content slider block
 *
 * @package ED_BOILERPLATE_THEME
 */
if (!defined('ABSPATH')):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'image-with-content-slider';
$sliders = get_sub_field('sliders');
?>
<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div>
				<?php if ($sliders): ?>
					<div class="<?php echo esc_attr($base); ?>__slider">
						<div class="<?php echo esc_attr($base); ?>__track" data-glide-el="track">
							<div class="<?php echo esc_attr($base); ?>__slides">
								<?php foreach ($sliders as $slider):
        	Template::get_image_with_fallback(
        		$base,
        		$slider['Image']['id'] ?: 0,
        		'large',
        		true
        	);
        endforeach; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<div>
				<?php if ($sliders): ?>
					<div class="<?php echo esc_attr($base); ?>__slider">
						<div class="<?php echo esc_attr($base); ?>__track" data-glide-el="track">
							<div class="<?php echo esc_attr($base); ?>__slides">
								<?php foreach ($sliders as $slider): ?>
									<div class="<?php echo esc_attr($base); ?>__content">
										<?php get_template_part('template-parts/content-block', null, [
          	'data' => [
          		'base' => $base,
          		'content' => $slider['content'],
          	],
          ]); ?>

									</div>

								<?php endforeach; ?>
							</div>
							<div class="<?php echo esc_attr($base); ?>__controls" data-glide-el="controls">
								<svg data-glide-dir="<" viewBox="0 0 24 24" fill="none"
									 xmlns="http://www.w3.org/2000/svg">
									<path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5"
										  stroke-linecap="round"
										  stroke-linejoin="round"/>
								</svg>
								<svg data-glide-dir=">" viewBox="0 0 24 24" fill="none"
									 xmlns="http://www.w3.org/2000/svg">
									<path d="M15 7L10 12L15 17" stroke="#000000" stroke-width="1.5"
										  stroke-linecap="round"
										  stroke-linejoin="round"/>
								</svg>

							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
