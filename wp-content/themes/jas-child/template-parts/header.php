<?php use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;
$base         = 'header';
$phone_number = get_field( 'phone_number', 'option' );
?>
<header class="<?php echo $base; ?>">
	<div class="<?php echo $base; ?>__top">
		<div class="<?php echo $base; ?>__inner">
			<?php Template::display_logo( $base, true, 'jas-logo' ); ?>
			<div class="<?php echo $base; ?>__additional">
				<?php get_template_part( '/template-parts/search-bar' ); ?>
				<a class="<?php echo $base; ?>__search" href="#">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
						 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
						 class="lucide lucide-search">
						<circle cx="11" cy="11" r="8"/>
						<path d="m21 21-4.3-4.3"/>
					</svg>
				</a>

				<?php if ( ! empty( $phone_number ) ):
					echo '<a href="tel:' .
						 esc_attr( $phone_number ) .
						 '" class="' .
						 esc_attr( $base ) .
						 '__phone">' .
						 esc_html( $phone_number ) .
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
			<?php wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => esc_attr( $base ) . '__primary-additional',
				'depth'          => 2,
			] ); ?>
		</div>
	</div>
	<?php wp_nav_menu( [
		'theme_location' => 'mobile',
		'container'      => false,
		'menu_class'     => esc_attr( $base ) . '__mobile',
		'depth'          => 2,
	] ); ?>
</header>
