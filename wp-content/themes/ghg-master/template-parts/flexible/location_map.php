<?php
/**
 * Template file for displaying a location map with content
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;
$base     = 'location-map';
$content  = get_sub_field( 'content' );
$location = get_sub_field( 'location_map' );
$key      = get_field( 'google_maps_API_key', 'option' );

?>


<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<div class="<?php echo esc_attr( $base ); ?>__background">
			<?php
			get_template_part(
				'template-parts/content-block',
				null,
				[
					'data' => [
						'base'    => $base,
						'content' => $content,
					],
				]
			);
			if ( $location ): ?>
				<div class="<?php echo esc_attr( $base ); ?>__map-wrap">
					<div class="<?php echo esc_attr( $base ); ?>__map map" data-zoom="16">
						<div class="marker" data-lat="<?php echo esc_attr( $location['lat'] ); ?>"
							 data-lng="<?php echo esc_attr( $location['lng'] ); ?>"></div>
					</div>
				</div>
			<?php endif;
			?>
		</div>
	</div>
	<?php if ( ! empty( $key ) ): ?>
		<script
			src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr( $key ) ?>&callback=Function.prototype"></script>
	<?php endif; ?>
</section>

