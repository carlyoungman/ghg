<?php
/**
 * The template for displaying Product Category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
$taxonomy            = get_queried_object() ?: [];
$base                = 'tax-product-cat';
$content['headline'] = $taxonomy->name ?: null;
$content['content']  = '<p>' . $taxonomy->description . '</p>' ?: null;
$filter              = $_GET['content'] ?? null;
$single              = [ $taxonomy->taxonomy, $taxonomy->term_id ];
?>
	<section class="<?php echo esc_attr( $base ); ?>">
		<div class="<?php echo esc_attr( $base ); ?>__inner">
			<?php get_template_part( 'template-parts/content-block', null, [
				'data' => [
					'base'                => $base,
					'content'             => $content,
					'display_breadcrumbs' => true,
				],
			] ); ?>
		</div>
	</section>
<?php get_template_part( 'template-parts/flexible/AUT_products', null, [
	'data' => [
		'single' => $single,
	],
] ); ?>
<?php Template::get_flexible_components(); ?>
<?php get_footer();
