<?php
/**
 * The template for displaying case studies
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

use BOILERPLATE_THEME\Core\Module\Template;

get_header();
$base     = 'single-series';
$summery  = get_field( 'content' )['summery'] ?? '';
$tag_line = get_field( 'content' )['tag_line'] ?? '';
$button1  = [
	'button' => [],
];
$button2  = [
	'button' => [],
];

$data_sheet = get_field( 'data_sheet' ) ?: [];

if ( ! empty( $data_sheet ) ):
	$data_sheet['title'] = 'Download Series Data Sheet';
	$button1             = [
		'button' => [
			'title'  => $data_sheet['title'],
			'url'    => $data_sheet['url'] ?? '',
			'target' => '_blank',
		],
	];
endif;

$cad_model = get_field( '3d_cad_model' ) ?: [];

if ( ! empty( $cad_model ) ):
	$button2 = [
		'button' => $cad_model,
	];
endif;

$content = [
	'headline' => get_the_title(),
	'content'  => '<p>' . ( $summery ?? '' ) . '</p>',
	'buttons'  => [ $button1, $button2 ],
	'tag_line' => $tag_line,
];
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
<?php get_template_part( 'template-parts/single-series-properties' ); ?>
<?php get_template_part( 'template-parts/flexible/AUT_products' ); ?>
<?php get_template_part( 'template-parts/single-promo', null, [
	'data' => [
		'image'    => get_field( 'categories', 'options' )['categories_image']['ID'],
		'content'  => get_field( 'categories', 'options' )['categories_content'],
		'headline' => 'Categories featuring ' . get_the_title(),
		'items'    => Template::get_connected_terms_ui_list(
			get_the_id(),
			'categories'
		),
		'class'    => '--layout-image-offset',
	],
] ); ?>
<?php get_template_part( 'template-parts/single-promo', null, [
	'data' => [
		'image'    => get_field( 'industry', 'options' )['industry_image']['ID'],
		'content'  => get_field( 'industry', 'options' )['industry_content'],
		'headline' => 'Industries featuring ' . get_the_title(),
		'items'    => Template::get_connected_terms_ui_list(
			get_the_id(),
			'industry'
		),
		'class'    => '--layout-image-offset-right',
	],
] ); ?>
<?php Template::get_flexible_components(); ?>
<?php get_footer(); ?>
