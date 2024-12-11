<?php
/**
 * Template file for displaying the content block
 *
 * @package ED_BOILERPLATE_THEME
 */

use BOILERPLATE_THEME\Core\Module\Template;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

$base       = 'product-categories';
$content    = get_sub_field( 'content' );
$categories = get_sub_field( 'options' )["product_categories"] ?: [];
$cats       = Template::get_product_categories( $categories, 'View The Range' )
?>
<section class="<?php echo esc_attr( $base ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<?php
		get_template_part(
			'template-parts/content-block',
			null,
			[
				'data' => [
					'base'    => $base,
					'content' => $content,
				],
			]
		);
		?>
		<?php if ( ! empty( $content['content'] ) ): ?>
			<span class="<?php echo esc_attr( $base ); ?>__line"></span>
		<?php endif; ?>
		<?php if ( ! empty( $cats ) ): ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php foreach ( $cats as $cat ):
					get_template_part( 'template-parts/cards/card-product-cat', null, [ 'data' => $cat ] );
				endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

</section>
