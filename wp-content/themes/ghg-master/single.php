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
$base = 'single-content';
$related_content_query = Queries::related_content(
	'post',
	get_the_category($post->ID)[0]->term_id ?? '',
	$post->ID ?? '',
	3
);
?>
	<section class="<?php echo esc_attr($base); ?>">
		<div class="<?php echo esc_attr($base); ?>__inner">
			<div class="<?php echo esc_attr($base); ?>__grid">
				<div>
					<article class="<?php echo esc_attr($base); ?>__article">
						<?php Template::breadcrumbs(); ?>
						<h1 class="<?php echo esc_attr($base); ?>__headline"><?php the_title(); ?></h1>
						<div class="<?php echo esc_attr($base); ?>__meta">
							<p class="<?php echo esc_attr($base); ?>__post-date">
								<svg xmlns="http://www.w3.org/2000/svg" height="25" viewBox="0 -960 960 960" width="25">
									<path
										d="M596.817-220Q556-220 528-248.183q-28-28.183-28-69T528.183-386q28.183-28 69-28T666-385.817q28 28.183 28 69T665.817-248q-28.183 28-69 28ZM180-80q-24 0-42-18t-18-42v-620q0-24 18-42t42-18h65v-60h65v60h340v-60h65v60h65q24 0 42 18t18 42v620q0 24-18 42t-42 18H180Zm0-60h600v-430H180v430Zm0-490h600v-130H180v130Zm0 0v-130 130Z"/>
								</svg>
								<?php echo get_the_date('dS F Y'); ?>
							</p>
						</div>

					</article>
					<?php Template::get_image_with_fallback(
     	$base,
     	get_post_thumbnail_id(),
     	'medium',
     	true
     ); ?>
					<article class="<?php echo esc_attr($base); ?>__article">
						<?php
      while (have_posts()):
      	the_post();
      	the_content();
      endwhile;
      Template::get_post_items($base, 2, false, true);
      ?>
					</article>
				</div>
				<div>
					<?php get_template_part('template-parts/related-content', null, [
     	'data' => [
     		'query' => $related_content_query,
     		'card' => 'card-news-post',
     	],
     ]); ?>
				</div>
			</div>
		</div>
	</section>
<?php get_footer();
