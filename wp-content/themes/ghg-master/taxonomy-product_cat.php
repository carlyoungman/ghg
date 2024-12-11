<?php
/**
 * The template for displaying Product Category pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Queries;

get_header();
$taxonomy = get_queried_object() ?: [];
$base = 'tax-product';
$content['headline'] = $taxonomy->name ?: null;
$content['content'] = '<p>' . $taxonomy->description . '</p>' ?: null;
$filter = $_GET['content'] ?? null;
?>
    <section class="<?php echo esc_attr($base); ?>">
        <div class="<?php echo esc_attr($base); ?>__inner">
			<?php get_template_part('template-parts/content-block', null, [
   	'data' => [
   		'base' => $base,
   		'content' => $content,
   	],
   ]); ?>
			<?php if (!empty($content['content'])): ?>
                <span class="<?php echo esc_attr($base); ?>__line"></span>
			<?php endif; ?>
            <div id="<?php echo esc_attr($base); ?>--react"></div>
        </div>
    </section>

<?php get_footer();
