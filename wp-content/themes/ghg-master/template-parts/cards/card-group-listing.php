<?php
/**
 * Product Card
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'card-group-listing';
$card = $args['data']['card'] ?: [];
$link = $card['Details']['link'];
?>


<div class="<?php echo esc_attr( $base ) ?>">
	<div class="<?php echo esc_attr( $base ) ?>__grid">
		<?php
		if ( ! empty( $card['image'] ) ) :
			echo '<div class="' . esc_attr( $base ) . '__image-wrap">';
			Template::get_image_with_fallback( $base, $card['image']['ID'], 'thumbnail', true );
			echo '</div>';
		endif;
		?>
		<article class="<?php echo esc_attr( $base ); ?>__article">
			<?php
			if ( ! empty( $card['Details']['headline'] ) ) :
				echo '<h5 class="' . esc_attr( $base ) . '__headline">' . $card['Details']['headline'] . '</h5>';
			endif;
			?>
			<?php
			if ( ! empty( $card['Details']['Supporting_content'] ) ) :
				echo '<p>' . $card['Details']['Supporting_content'] . '</p>';
			endif;
			if ( ! empty( $card['Details']['Telephone'] ) ) :
				echo '<a class="' . esc_attr( $base ) . '__tel" href="tel:' . $card['Details']['Telephone'] . '"><span>Telephone:</span> ' . $card['Details']['Telephone'] . '</a>';
			endif;
			if ( ! empty( $card['Details']['Email'] ) ) :
				echo '<a class="' . esc_attr( $base ) . '__email"  href="mailto:' . $card['Details']['Email'] . '"><span>Email:</span> ' . $card['Details']['Email'] . '</a>';
			endif;
			Template::build_button( $base, $link, false, true );
			?>
		</article>
	</div>
</div>




