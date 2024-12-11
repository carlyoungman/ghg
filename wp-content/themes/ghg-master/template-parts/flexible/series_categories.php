<?php
/**
 * Template file for displaying the Series categories component
 *
 * @package ED_BOILERPLATE_THEME
 */
if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base    = 'series-categories';
$content = get_sub_field( 'content' );
$options = get_sub_field( 'options' );
$data    = [];

$categories = $options['series_categories'];
$industries = $options['series_industry'];

$category_data = Template::process_terms( $categories, 'categories' );
$data          = array_merge( $data, $category_data );

$industry_data = Template::process_terms( $industries, 'industry' );
$data          = array_merge( $data, $industry_data );

?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php get_template_part( 'template-parts/content-block', null, [
			'data' => [
				'base'    => $base,
				'content' => $content,
			],
		] ); ?>
		<?php if ( $data ):
			echo '<div class="' . esc_attr( $base ) . '__grid">';
			foreach ( $data as $cat ):
				$data = [
					'title'             => $cat['title'],
					'image_id'          => $cat['image_id'],
					'permalink'         => $cat['permalink'],
					'short_description' => $cat['short_description'],
					'button_text'       => $cat['button_text'],
				];
				get_template_part( 'template-parts/cards/card-product-cat', null, [ 'data' => $data ] );
			endforeach;
			echo '</div>';
		endif; ?>
	</div>

</section>
