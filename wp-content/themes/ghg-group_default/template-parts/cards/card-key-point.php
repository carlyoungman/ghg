<?php
/**
 * Key Point Card
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'card-key-point';
$card = $args['data']['card'] ?: [];
?>
<div class="<?php echo esc_attr( $base ); ?>">
	<?php
	if ( ! empty( $card['icon'] ) ) :
		echo '<div class="' . esc_attr( $base ) . '__icon-wrap">';
		Template::get_image_with_fallback( $base, $card['icon']['ID'], 'thumbnail', true );
		echo '</div>';
	endif;
	?>
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<?php
		if ( ! empty( $card['content']['headline'] ) ) :
			echo '<h5>' . $card['content']['headline'] . '</h5>';
		endif;
		?>
		<?php
		if ( ! empty( $card['content']['supporting_content'] ) ) :
			echo '<p>' . $card['content']['supporting_content'] . '</p>';
		endif;
		?>
	</article>
</div>
