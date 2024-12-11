<?php

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'page-header';
?>
<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<article class="<?php echo esc_attr($base); ?>__article">
			<?php Template::breadcrumbs(); ?>
			<h1 class="<?php echo esc_attr(
   	$base
   ); ?>__headline h3"><?php the_title(); ?></h1>
		</article>
	</div>
</section>
