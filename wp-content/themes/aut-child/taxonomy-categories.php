<?php
/**
 * The template for displaying series Category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
$taxonomy = get_queried_object() ?: [];
$base = 'series-taxonomy';
$content['headline'] = $taxonomy->name ?: null;
$content['content'] = '<p>' . $taxonomy->description . '</p>' ?: null;
?>
	<section class="<?php echo esc_attr($base); ?>">
		<div class="<?php echo esc_attr($base); ?>__inner">
			<?php get_template_part('template-parts/content-block', null, [
   	'data' => [
   		'base' => $base,
   		'content' => $content,
   		'display_breadcrumbs' => true,
   	],
   ]); ?>
		</div>
	</section>
<?php get_template_part('template-parts/flexible/series'); ?>
<?php Template::get_flexible_components(); ?>
<?php get_footer();
