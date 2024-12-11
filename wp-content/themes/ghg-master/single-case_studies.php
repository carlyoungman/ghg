<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

use BOILERPLATE_THEME\Core\Module\Queries;
use BOILERPLATE_THEME\Core\Module\Template;

get_header();

global $post;
$base = 'single-case-study';
$related_content_query = Queries::related_content(
	'case_studies',
	get_the_category($post->ID)[0]->term_id ?? '',
	$post->ID ?? '',
	3
);
?>
	<section class="<?php echo esc_attr($base); ?>">
		<div class="<?php echo esc_attr($base); ?>__inner">
			<a alt="Back to c
			ase-studies" href="/case-studies/" class="<?php echo esc_attr($base); ?>__back">
				<svg width="11" height="17" viewBox="0 0 11 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M10 1L2 8.5L10 16" stroke="#FAF5FA" stroke-width="1.5" stroke-linecap="round"/>
				</svg>
				Back to case studies
			</a>
			<div class="<?php echo esc_attr($base); ?>__grid">
				<svg class="<?php echo esc_attr(
    	$base
    ); ?>__image-cutoff" width="150" height="149"
					 viewBox="0 0 150 149" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M159 0L159 149L0 1.39002e-05L159 0Z"/>
				</svg>
				<div>
					<article class="<?php echo esc_attr($base); ?>__article">
						<h5 class="<?php echo esc_attr($base); ?>__headline"><?php the_title(); ?></h5>
						<p class="<?php echo esc_attr(
      	$base
      ); ?>__author">Written by: <?php the_author(); ?></p>
						<p class="<?php echo esc_attr($base); ?>__post-date"><?php echo get_the_date(
	'dS F Y'
); ?></p>
					</article>
				</div>
				<div>
					<article class="<?php echo esc_attr($base); ?>__article">
						<?php while (have_posts()):
      	the_post();
      	the_content();
      endwhile; ?>
					</article>
				</div>
			</div>
		</div>
	</section>
<?php get_template_part('template-parts/related-content', null, [
	'data' => [
		'query' => $related_content_query,
		'card' => 'card-news-post',
	],
]); ?>
<?php get_footer();
