<?php

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'card-page';

?>
<a class="<?php echo esc_attr( $base ) ?>" href="<?php the_permalink(); ?>">
	<div class="<?php echo esc_attr( $base ) ?>__image-wrap">
		<?php Template::get_image_with_fallback( $base, get_post_thumbnail_id(), 'small', true ); ?>
	</div>
	<article class="<?php echo esc_attr( $base ) ?>__article">
		<p class="<?php echo esc_attr( $base ) ?>__headline"><?php the_title() ?> </p>
	</article>
</a>

