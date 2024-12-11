<?php

use BOILERPLATE_THEME\Core\Module\Template;

$base    = 'news-and-media-card';
$excerpt = get_the_excerpt();
?>
<div class="<?php echo esc_attr( $base ) ?>" href="<?php the_permalink(); ?>">
	<div class="<?php echo esc_attr( $base ) ?>__image-wrap">
		<?php Template::get_image_with_fallback( $base, get_post_thumbnail_id(), 'small', true ); ?>
	</div>
	<article class="<?php echo esc_attr( $base ) ?>__article">

		<h5 class="<?php echo esc_attr( $base ) ?>__headline"><?php the_title() ?> </h5>
		<p class="<?php echo esc_attr( $base ) ?>__excerpt"><?php echo wp_strip_all_tags( $excerpt ) ?> </p>
		<a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( $base ) ?>__link">
			<span>View Case Study</span>
		</a>
	</article>
</div>

