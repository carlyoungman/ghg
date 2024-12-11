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
$base = 'single-series-properties';
$properties = get_field('properties');
$properties_options = [
	'wheel_diameter',
	'wheel_hardness',
	'load_capacity',
	'rolling_resistance',
	'temperature_range',
];
?>
<section class="<?php echo $base; ?>">
	<div class="<?php echo $base; ?>__inner">
		<div class="<?php echo $base; ?>__grid">
			<?php foreach ($properties_options as $property):
   	$item['data'] = $properties[$property] ?? [];
   	$item['label'] = $property ?? '';
   	if (!empty($item)):

   		$label = str_replace('_', ' ', $item['label']);
   		$label = ucwords($label);
   		$icon = str_replace('_', '-', $item['label']);
   		?>
					<div class="<?php echo $base; ?>__item">
						<svg class="<?php echo $base; ?>__item__icon">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
								 xlink:href="#icon-<?php echo esc_attr($icon); ?>"></use>
						</svg>
						<h6 class="<?php echo esc_attr($base); ?>__item__label">
							<?php echo esc_html($label); ?>
						</h6>
						<p class="<?php echo esc_attr($base); ?>__item__data">
							<?php echo esc_html($item['data'] ?: '-'); ?>
						</p>
					</div>
				<?php
   	endif;
   endforeach; ?>
		</div>
	</div>
</section>
