<?php
/**
 * Template part get in touch
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base                = 'get-in-touch';
$content             = get_field( 'get_in_touch_content', 'options' ) ?? [];
$headline            = get_field( 'get_in_touch_content', 'options' )['headline'] ?? '';
$formID              = get_field( 'form', 'options' )['value'] ?? 0;
$content['headline'] = '';
?>
<section class="<?php echo $base; ?> has-background">
	<div class="<?php echo $base; ?>__inner">
		<div class="<?php echo $base; ?>__grid">
			<div>
				<?php if ( ! empty( $headline ) ): ?>
					<h4>
						<svg width="84" height="71" viewBox="0 0 84 71" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M78.6396 71V60.4238H84V22H29V50.986L37.9581 59.8286C38.3447 60.2103 38.8624 60.4238 39.4128 60.4238H57.3093L68.0236 71H78.6396ZM71.8571 67.0477L58.9672 54.3238C58.5806 53.9422 58.0629 53.7287 57.5125 53.7287H39.1114C37.2765 53.7287 35.7824 52.2539 35.7824 50.4426V28.695H77.2176V53.7287H71.8637V67.0477H71.8571Z"
								fill="#E8AF5F"/>
							<path
								d="M5.36042 49V38.4238H0V0H55V28.986L46.0419 37.8286C45.6553 38.2103 45.1376 38.4238 44.5872 38.4238H26.6907L15.9764 49H5.36042ZM12.1429 45.0477L25.0328 32.3238C25.4194 31.9422 25.9371 31.7287 26.4875 31.7287H44.8886C46.7235 31.7287 48.2176 30.2539 48.2176 28.4426V6.69505H6.78244V31.7287H12.1363V45.0477H12.1429Z"
								fill="#E8AF5F"/>
						</svg>
						<?php echo esc_html( $headline ); ?>
					</h4>
				<?php endif; ?>
			</div>
			<div>
				<?php get_template_part( 'template-parts/content-block', null, [
					'data' => [
						'base'    => $base,
						'content' => $content,
					],
				] ); ?>
				<div class="<?php echo $base; ?>__form-wrap">
					<?php echo do_shortcode( '[formidable id="' . $formID . '"]' ); ?>
				</div>
			</div>
		</div>
	</div>
	<svg class="<?php echo $base; ?>__image-cut" viewBox="0 0 144 159" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M149 159L0 159L149 0L149 159Z" fill="#DCDCE1"/>
	</svg>
</section>
