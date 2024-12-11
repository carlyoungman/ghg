<?php use BOILERPLATE_THEME\Core\Module\Custom_Walker_Menu;
use BOILERPLATE_THEME\Core\Module\Template;

if (!defined('ABSPATH')):
	exit();
endif;
$base = 'header';
$phone_number = get_field('phone_number', 'option');
$email = get_field('email_address', 'option');
?>
<header class="<?php echo $base; ?>">
	<div class="<?php echo $base; ?>__top">
		<div class="<?php echo $base; ?>__inner">
			<?php Template::display_logo($base, true, 'AUT-logo'); ?>
			<div class="<?php echo $base; ?>__additional">
				<?php get_template_part('/template-parts/search-bar'); ?>
				<?php
    Template::generateContactLink($phone_number, 'tel', $base);
    Template::generateContactLink($email, 'email', $base);
    ?>
				<button class="<?php echo $base; ?>__hamburger hamburger hamburger--slider" type="button">
						  <span class="hamburger-box">
							<span class="hamburger-inner"></span>
						  </span>
				</button>

			</div>
		</div>
	</div>
	<div class="<?php echo $base; ?>__bottom">
		<div class="<?php echo $base; ?>__inner">
			<?php wp_nav_menu([
   	'theme_location' => 'primary',
   	'container' => false,
   	'menu_class' => esc_attr($base) . '__primary-additional',
   	'walker' => new Custom_Walker_Menu(),
   ]); ?>
		</div>
	</div>
	<?php wp_nav_menu([
 	'theme_location' => 'mobile',
 	'container' => false,
 	'menu_class' => esc_attr($base) . '__mobile',
 	'depth' => 3,
 ]); ?>
</header>
