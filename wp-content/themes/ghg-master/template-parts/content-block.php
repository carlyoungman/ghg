<?php
/**
 * Template part for displaying a content
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base                 = $args['data']['base'] ?? '';
$content              = $args['data']['content'] ?? '';
$display_breadcrumbs  = $args['data']['display_breadcrumbs'] ?? '';
$display_price_toggle = $args['data']['display_price_toggle'] ?? false;
$buttons              =
	isset( $content['buttons'] ) && is_array( $content['buttons'] )
		? $content['buttons']
		: [];

if ( ! empty( $content ) ): ?>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<?php
		if ( ! empty( $display_breadcrumbs ) ):
			Template::breadcrumbs();
		endif;
		//  echo '<span>';
		if ( ! empty( $content['headline'] ) ):
			printf( '<h1 class="h3">%s</h1>', esc_html( $content['headline'] ) );
		endif;
		if ( ! empty( $content['tag_line'] ) ):
			printf( '<h5>%s</h5>', esc_html( $content['tag_line'] ) );
		endif;
		//  echo '</span>';
		if ( ! empty( $content['content'] ) ):
			echo wp_kses_post( $content['content'] );
		endif;
		Template::build_buttons( $base, $buttons, true );

		if ( true === $display_price_toggle ):
			echo '<div id="single-product-toggle--react"></div>';
		endif;
		?>
	</article>
<?php endif; ?>
