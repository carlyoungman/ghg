<?php use BOILERPLATE_THEME\Core\Module\Template;

$overlay    = get_field( 'overlay' );
$background = get_field( 'background' );

$base = 'header'; ?>
<header class="<?php echo $base;
if ( true === $overlay ): echo ' ' . $base . '--overlay'; endif;
if ( true === $background ): echo ' ' . $base . '--steal'; endif; ?>">
	<div class="<?php echo $base ?>__inner">
		<?php Template::display_logo( $base, true ) ?>
		<div class="<?php echo $base ?>__nav-wrap">
			<?= wp_nav_menu( [ 'theme_location' => 'primary', 'container' => false ] ) ?>
		</div>
		<div class="<?php echo $base ?>__mobile-wrap">
			<button class="hamburger hamburger--slider" type="button">
						  <span class="hamburger-box">
							<span class="hamburger-inner"></span>
						  </span>
			</button>
			<?php wp_nav_menu( [ 'theme_location' => 'mobile', 'container' => false ] ) ?>
		</div>
	</div>
</header>
