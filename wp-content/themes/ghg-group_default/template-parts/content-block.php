<?php
/**
 * Template part for displaying a content
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base    = $args['data']['base'] ?? '';
$content = $args['data']['content'] ?? '';

if ( ! empty( $content ) ) : ?>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<?php
		if ( ! empty( $content['content'] ) ) :
			echo wp_kses_post( $content['content'] );
		endif;
		if ( ! empty( $content['buttons'] ) ) :
			Template::build_buttons( $base, $content['buttons'] ?: [], true );
		endif;
		?>
	</article>
<?php endif; ?>
