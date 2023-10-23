<?php
/**
 * Template part displaying social icons
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit;
endif;

$base    = 'social-icons';
$socials = [ 'facebook', 'x', 'instagram', 'youtube' ];
?>
<ul class="<?php echo esc_attr( $base ); ?>">
	<?php
	foreach ( $socials as $key => $op ) {
		$icon = get_field( $op, 'option' );
		if ( ! empty( $icon ) ) {
			?>
			<li class="<?php echo esc_attr( $base ); ?>__icon">
				<a title="Click to visit the <?php echo esc_html( get_bloginfo( 'name' ) ) . ' ' . esc_attr( $op ); ?> page"
				   target="_blank" rel="noopener" href="<?php echo esc_url( $icon ); ?>">
					<svg class=" <?php echo esc_attr( $base ) . '__' . esc_attr( $op ); ?>-icon">
						<use xmlns:xlink="http://www.w3.org/1999/xlink"
							 xlink:href="#icon-<?php echo esc_attr( $op ); ?>"></use>
					</svg>
				</a>
			</li>
			<?php
		}
	}
	?>
</ul>

