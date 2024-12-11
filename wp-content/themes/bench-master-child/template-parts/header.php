<?php use BOILERPLATE_THEME\Core\Module\Template;

if (!defined('ABSPATH')):
	exit();
endif;
$base = 'header';

$my_account_page_id = get_option('woocommerce_myaccount_page_id');
$my_account_page_url = get_permalink($my_account_page_id);
$basket_page_url = wc_get_cart_url();
$phone_number = get_field('phone_number', 'option');
?>
<header class="<?php echo $base; ?>">
	<div class="<?php echo $base; ?>__top">
		<div class="<?php echo $base; ?>__inner">
			<?php Template::display_logo($base, true, 'bench-logo'); ?>
			<div class="<?php echo $base; ?>__additional">
				<?php get_template_part('/template-parts/search-bar'); ?>
				<a class="<?php echo $base; ?>__my-account" href="<?php echo esc_url(
	$my_account_page_url
); ?>"
				   aria-label="My Account">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
						 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<circle cx="12" cy="8" r="5"/>
						<path d="M20 21a8 8 0 1 0-16 0"/>
					</svg>
				</a>
				<a class="<?php echo $base; ?>__my-basket" title="<?php _e(
	'View your shopping cart',
	'BOILERPLATE_THEME'
); ?>" href="<?php echo esc_url($basket_page_url); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
						 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						 class="lucide lucide-shopping-cart">
						<circle cx="8" cy="21" r="1"/>
						<circle cx="19" cy="21" r="1"/>
						<path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
					</svg>
					<?php Template::cart_icon_with_notification(); ?>
				</a>
				<a class="<?php echo $base; ?>__search" href="#">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
						 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						 class="lucide lucide-search">
						<circle cx="11" cy="11" r="8"/>
						<path d="m21 21-4.3-4.3"/>
					</svg>
				</a>

				<?php if (!empty($phone_number)):
    	echo '<a href="tel:' .
    		esc_attr($phone_number) .
    		'" class="' .
    		esc_attr($base) .
    		'__phone">' .
    		esc_html($phone_number) .
    		'</a>';
    endif; ?>
				<button class="<?php echo $base; ?>__hamburger hamburger hamburger--slider" type="button"
						aria-label="Toggle Menu">
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
   	'depth' => 2,
   ]); ?>
		</div>
	</div>
	<?php wp_nav_menu([
 	'theme_location' => 'mobile',
 	'container' => false,
 	'menu_class' => esc_attr($base) . '__mobile',
 	'depth' => 2,
 ]); ?>
</header>
