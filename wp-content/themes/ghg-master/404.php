<?php
/*==================================
|	  404 Page Template
==================================*/
?>

<?php
get_header();
$base = 'page-not-found';
?>

<section class="<?php echo esc_attr($base); ?>">
	<div class="<?php echo esc_attr($base); ?>__inner">
		<article class="<?php echo esc_attr($base); ?>__article">
			<h1>404</h1>
			<p>Page isn't found</p>
		</article>
	</div>
</section>


<!-- content here -->

<?php get_footer(); ?>
