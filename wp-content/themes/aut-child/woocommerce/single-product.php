<?php
/**
 * The template for displaying a single product
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
$series = get_field('series');
get_template_part('template-parts/single-product-header');
get_template_part('template-parts/single-product-specification');

if (!empty($series)):
	get_template_part('template-parts/single-promo', null, [
		'data' => [
			'image' => get_field('categories', 'options')['categories_image'][
				'ID'
			],
			'content' => get_field('categories', 'options')[
				'categories_content'
			],
			'headline' => 'Categories featuring ' . get_the_title($series[0]),
			'items' => Template::get_connected_terms_ui_list(
				$series[0],
				'categories'
			),
			'class' => '--layout-image-offset',
		],
	]);
	get_template_part('template-parts/single-promo', null, [
		'data' => [
			'image' => get_field('industry', 'options')['industry_image']['ID'],
			'content' => get_field('industry', 'options')['industry_content'],
			'headline' => 'Industries featuring ' . get_the_title($series[0]),
			'items' => Template::get_connected_terms_ui_list(
				$series[0],
				'industry'
			),
			'class' => '--layout-image-offset-right',
		],
	]);
endif;
Template::get_flexible_components();
get_footer();
