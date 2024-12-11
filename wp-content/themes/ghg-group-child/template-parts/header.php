<?php use BOILERPLATE_THEME\Core\Module\Template;

$overlay = get_field('overlay');
$background = get_field('background');

$base = 'header';
?>
<header class="<?php
echo $base;
if (true === $overlay):
	echo ' ' . $base . '--overlay';
endif;
if (true === $background):
	echo ' ' . $base . '--steal';
endif;
?>">
	<div class="<?php echo $base; ?>__inner">
		<?php Template::display_logo($base, true); ?>
		<div class="<?php echo $base; ?>__nav-wrap">
			<?= wp_nav_menu(['theme_location' => 'primary', 'container' => false]) ?>
		</div>
		<button class="hamburger hamburger--slider" type="button" aria-label="Menu Toggle">
  <span class="hamburger-box">
    <span class="hamburger-inner"></span>
  </span>
		</button>
	</div>
	<?php wp_nav_menu([
 	'theme_location' => 'mobile',
 	'container' => false,
 	'menu_class' => esc_attr($base) . '__mobile',
 	'depth' => 1,
 ]); ?>
</header>
