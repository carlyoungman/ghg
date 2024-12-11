<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
$base           = 'selling-points';
$selling_points = get_field( 'selling_points', 'options' );
if ( $selling_points ): ?>
	<section class="<?php echo esc_attr( $base ); ?>">
		<div class="<?php echo esc_attr( $base ); ?>__inner">
			<div class="<?php echo esc_attr( $base ); ?>__slider">
				<div class="<?php echo esc_attr( "{$base}__track" ); ?>" data-glide-el="track">
					<div class="<?php echo esc_attr( $base ); ?>__grid">
						<?php foreach ( $selling_points as $point ):
							$icon = $point['icon']['id'] ?? '';
							$text = $point['Text'] ?? ''; ?>
							<div class="<?php echo esc_attr( $base ); ?>__point">
								<?php if ( $icon ):
									$image_url = wp_get_attachment_image_url( $icon, 'small' );
									if ( $image_url ): ?>
										<img src="<?php echo esc_url( $image_url ); ?>" alt="" width="30" height="30"
											 class="<?php echo esc_attr( $base ); ?>__image">
									<?php endif; ?>
								<?php endif; ?>
								<p><?php echo esc_html( $text ); ?></p>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
