<?php
/**
 * Template file for displaying the hero component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base                = 'hero';
$desktop             = get_sub_field( 'desktop_image' )['id'] ?? 0;
$mobile              = get_sub_field( 'mobile_image' )['id'] ?? 0;
$video               = get_sub_field( 'video' );
$content             = get_sub_field( 'content' );
$options             = get_sub_field( 'options' );
$display_ticker      = $options['display_ticker'];
$ticket_text         = $options['ticker-text'];
$display_breadcrumbs = $options['display_breadcrumbs'];
$options_array       = [
	[ 'layout', $base . '--layout', true ],
	[ 'super_size', $base . '--super-size-text' ],
	[ 'half_height', $base . '--half-height' ],
	[ 'display_ticker', $base . '--has-ticker' ],
	[ 'display_breadcrumbs', $base . '--has-breadcrumbs' ],
];
$media_type          = get_sub_field( 'media_type' ) ?? 'image';
?>
<section class="<?php
echo esc_attr( $base );
Template::apply_classes( $options_array, $options );
?>">
	<div class="<?php echo esc_attr( $base ); ?>__inline__inner">
		<?php if ( 'image' === $media_type ): ?>
			<div class="<?php echo esc_attr( $base ); ?>__image-wrap">
				<?php if ( $mobile ) : ?>
					<span
						style="background-image: url('<?php echo wp_get_attachment_image_url( $mobile, 'mobile' ); ?>');"
						class="<?php echo esc_attr( $base ); ?>__image <?php echo esc_attr( $base ); ?>__image--mobile-background"></span>
				<?php endif; ?>
				<?php if ( $desktop ) : ?>
					<span
						style="background-image: url('<?php echo wp_get_attachment_image_url( $desktop, 'hero' ); ?>');"
						class="<?php echo esc_attr( $base ); ?>__image <?php echo esc_attr( $base ); ?>__image--desktop-background"></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if ( 'video' === $media_type ): ?>
			<?php if ( ! empty( $video[0] ) ): ?>
				<video class="<?php echo esc_attr( $base ); ?>__video"
					   src="<?php echo esc_url( $video[0]['url'] ?? '' ); ?>" preload="metadata"
					   muted loop autoplay playsinline
					   poster="
					   <?php if ( ! empty( $video[0]['sizes'] ) ):
						   echo esc_attr( $video[0]['sizes']['hero'] ) ?: '';
					   endif; ?>
						">
				</video>
			<?php endif; ?>
		<?php endif; ?>
		<div class="<?php echo esc_attr( $base ); ?>__inner">
			<?php get_template_part( 'template-parts/content-block', null, [
				'data' => [
					'base'                => $base,
					'content'             => $content,
					'display_breadcrumbs' => $display_breadcrumbs,
				],
			] ); ?>
		</div>
		<?php if ( true === $display_ticker ): ?>
			<div class="<?php echo esc_attr( $base ); ?>__ticker">
				<div class="<?php echo esc_attr( $base ); ?>__ticker__inner">
					<?php for ( $i = 0; $i < 5; $i ++ ): ?>
						<div class="<?php echo esc_attr( $base ); ?>__ticker__item">
							<p><?php echo esc_html( $ticket_text ); ?> </p>
						</div>
						<div class="<?php echo esc_attr( $base ); ?>__ticker__item--line"></div>
					<?php endfor; ?>
				</div>

			</div>
		<?php endif; ?>
	</div>
</section>
