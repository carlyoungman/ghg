<?php
/**
 * Template file for displaying a key figure component
 *
 * @package ED_BOILERPLATE_THEME
 */
if (!defined('ABSPATH')):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'key-figure-block';

$content = get_sub_field('content') ?? [];
$key_figure = $content['key_figure'] ?? [];
$headline = $content['Headline'] ?? [];
$content_content = $content['content'] ?? [];
$buttons = $content['buttons'] ?? [];
$image = get_sub_field('Image')['id'] ?? 0;
?>

<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<div class="<?php echo esc_attr($base); ?>__grid">
			<div class="<?php echo esc_attr($base); ?>__content_grid">

				<div>
					<?php if (!empty($key_figure)):
     	printf(
     		'<h3 class="key-figure-block__key_figure">%s</h3>',
     		esc_html($key_figure)
     	);
     endif; ?>
				</div>
				<div>
					<?php if (!empty($headline)):
     	printf(
     		'<h3 class="key-figure-block__headline">%s</h3>',
     		esc_html($headline)
     	);
     endif; ?>
				</div>
				<div></div>
				<div>
					<?php if (!empty($content_content)):
     	echo '<article>';
     	echo wp_kses_post($content_content);
     	Template::build_buttons($base, $buttons, true);
     	echo '</article>';
     endif; ?>
				</div>
			</div>
			<div class="<?php echo esc_attr($base); ?>__image-wrap">
				<?php Template::get_image_with_fallback($base, $image, 'medium', true); ?>
			</div>
		</div>

	</div>

</section>
