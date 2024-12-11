<?php
/**
 * Product Card
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base    = 'card-product';
$product = $args['data']['product'] ?? [];
?>
<a class="<?php echo esc_attr( $base ); ?>" href="<?php the_permalink(
	$product->get_id()
); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__image-wrap">
		<?php Template::get_image_with_fallback(
			$base,
			get_post_thumbnail_id( $product->get_id() ),
			'small',
			true
		); ?>
	</div>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<p class="<?php echo esc_attr( $base ); ?>__headline"><?php echo esc_html(
				$product->get_name()
			); ?></p>
		<h5 class="<?php echo esc_attr( $base ); ?>__price">
			<span>
				<?php echo '£' .
						   wc_format_decimal( wc_get_price_excluding_tax( $product ), 2 ) .
						   '<span class="' . esc_attr( $base ) . '__vat">Ex VAT</span>'; ?>
			</span>
			<span>
				<?php echo '£' .
						   wc_format_decimal( wc_get_price_including_tax( $product ), 2 ) .
						   '<span class="' . esc_attr( $base ) . '__vat">Inc VAT</span>'; ?>
			</span>

		</h5>
		<p class="<?php echo esc_attr( $base ); ?>__description">
			<?php echo esc_html( $product->get_short_description() ); ?>
		</p>
	</article>
</a>
