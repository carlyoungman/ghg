<?php use BOILERPLATE_THEME\Core\Module\Template;

get_template_part( '/template-parts/get-in-touch' );
?>
</main>
<?php
$base      = 'footer';
$copyright = get_field( 'copyright', 'options' );
?>
<footer class="<?php echo esc_attr( $base ); ?> has-background">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<div class="<?php echo esc_attr( $base ); ?>__logo-and-social">
			<?php Template::display_logo( $base, true, 'jas-logo' ); ?>
			<?php get_template_part( '/template-parts/social-icons' ); ?>
			<?php if ( ! empty( $copyright ) ): ?>
				<p class="<?php echo esc_attr(
					$base
				); ?>__copyright"><?php echo $copyright; ?></p>
			<?php endif; ?>
		</div>
		<div class="<?php echo esc_attr( $base ); ?>__payment-icons">
		</div>
		<div class="<?php echo esc_attr( $base ); ?>__menu-grid">
			<div>
				<p class="<?php echo esc_attr( $base ); ?>__menu-title">Products</p>
				<?= wp_nav_menu( [ 'theme_location' => 'products', 'container' => false ] ) ?>
			</div>
			<div>
				<p class="<?php echo esc_attr( $base ); ?>__menu-title">Company</p>
				<?= wp_nav_menu( [ 'theme_location' => 'our-company', 'container' => false ] ) ?>
			</div>
			<div>
				<p class="<?php echo esc_attr( $base ); ?>__menu-title">Legal</p>
				<?= wp_nav_menu( [ 'theme_location' => 'legal', 'container' => false ] ) ?>
			</div>
		</div>
	</div>
</footer>
<div id="get_in_touch_link" data-link="<?php echo get_home_url() ?>/get-in-touch"></div>
<?php wp_footer(); ?>
</body>
</html>
