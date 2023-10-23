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

$base = 'card-grid';
$card = $args['data']['card'] ?: [];
$link = $card['Details']['link'];

$start = '<div class="' . esc_attr( $base ) . '">';
$end   = '</div>';
if ( ! empty( $link ) ):
	$link_target = $link['target'] ? $link['target'] : '_self';
	$start       = '<a target="' . esc_attr( $link_target ) . '" href="' . esc_url( $link['url'] ) . '" class="' . esc_attr( $base ) . '">';
	$end         = '</a>';
endif;

?>

<?php echo $start ?>
<?php
if ( ! empty( $card['image'] ) ) :
	echo '<div class="' . esc_attr( $base ) . '__image-wrap">';
	Template::get_image_with_fallback( $base, $card['image']['ID'], 'thumbnail', true );
	echo '<svg class="image-cut" width="106" height="100" viewBox="0 0 106 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.770996 99.2102L0.770996 0.380798L105.947 99.2102L0.770996 99.2102Z" /></svg>';
	echo '</div>';
endif;
?>
<article class="<?php echo esc_attr( $base ); ?>__article">
	<?php
	if ( ! empty( $card['Details']['headline'] ) ) :
		echo '<h6>' . $card['Details']['headline'] . '</h6>';
	endif;
	?>
	<?php
	if ( ! empty( $card['Details']['Supporting_content'] ) ) :
		echo '<p>' . $card['Details']['Supporting_content'] . '</p>';
	endif;
	?>
</article>
<?php echo $end; ?>
