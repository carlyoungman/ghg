<?php

use BOILERPLATE_THEME\Core\Module\Template;

$base    = 'card-product';
$excerpt = get_the_excerpt();
?>
<a class="<?php echo esc_attr( $base ) ?>" href="<?php the_permalink(); ?>">
	<div class="<?php echo esc_attr( $base ) ?>__image-wrap">
		<?php Template::get_image_with_fallback( $base, get_post_thumbnail_id(), 'small', true ); ?>
	</div>
	<article class="<?php echo esc_attr( $base ) ?>__article">
		<p class="<?php echo esc_attr( $base ) ?>__headline"><?php the_title() ?> </p>
		<h6 class="<?php echo esc_attr( $base ) ?>__price">
			<?php echo wc_price( get_post_meta( get_the_ID(), '_price', true ) ); ?>
		</h6>
		<p class="<?php echo esc_attr( $base ) ?>__description"><?php echo wp_strip_all_tags( $excerpt ) ?> </p>
	</article>
</a>

