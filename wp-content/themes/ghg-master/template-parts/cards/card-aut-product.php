<?php
/**
 * Aut Product Card
 *
 * @package YOUR_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$base = 'aut-product-card';
$data = $args['data'] ?? [];
$tags = $data['tags'] ?? [];

?>

<div class="<?php echo esc_attr( $base ); ?>">
	<a href="<?php echo esc_url( $data['permalink'] ); ?>" class="<?php echo esc_attr( $base ); ?>__image-wrap">
		<?php Template::get_image_with_fallback(
			$base,
			$data['image_id'],
			'small',
			true
		); ?>
	</a>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<?php if ( ! empty( $data["content"]['series'] ) ) : ?>
			<h4 class="<?php echo esc_attr( $base ); ?>__series">
				<?php echo wp_kses_post( $data["content"]['series'] ); ?>
			</h4>
		<?php endif; ?>

		<?php if ( ! empty( $tags ) ) : ?>
			<ul class="<?php echo esc_attr( $base ); ?>__tags">
				<?php foreach ( $tags as $index => $tag ) : ?>
					<li class="<?php echo esc_attr( $base ); ?>__tag">
						<?php echo wp_kses_post( $tag ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<h6 class="<?php echo esc_attr( $base ); ?>__title">
			<?php echo wp_kses_post( $data['content']['title'] ); ?>
		</h6>

		<?php if ( ! empty( $data['content']['description'] ) ) : ?>
			<p class="<?php echo esc_attr( $base ); ?>__description">
				<?php echo wp_kses_post( $data['content']['description'] ); ?>
			</p>
		<?php endif; ?>

		<a class="<?php echo esc_attr( $base ); ?>__btn" href="<?php echo esc_url( $data['permalink'] ); ?>">
			<?php echo esc_html( $data['button_text'] ); ?>
		</a>
	</article>
	<a class="<?php echo esc_attr( $base ); ?>__fixing_type" href="<?php echo esc_url( $data['permalink'] ); ?>">
        <span>
            <p>Fixing type</p>
            <h5><?php echo wp_kses_post( $data['content']['fixing_type'] ); ?></h5>
        </span>
	</a>
</div>
