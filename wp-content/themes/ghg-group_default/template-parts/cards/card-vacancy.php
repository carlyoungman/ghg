<?php
/**
 * Vacancy Card
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;

use BOILERPLATE_THEME\Core\Module\Template;

$base = 'card-vacancy';
$card = $args['data']['card'] ?: []; ?>

<div class="<?php echo esc_attr( $base ); ?>">
	<article class="<?php echo esc_attr( $base ); ?>__article">
		<?php
		if ( ! empty( $card['Details']['job_title'] ) ) :
			echo '<h5 class="' . esc_attr( $base ) . '__job-title">' . $card['Details']['job_title'] . '</h5>';
		endif;
		?>
		<?php
		if ( ! empty( $card['Details']['job_description'] ) ) :
			echo '<p class="' . esc_attr( $base ) . '__description">' . $card['Details']['job_description'] . '</p>';
		endif;
		if ( ! empty( $card['Details']['posted_date'] ) ) :
			echo '<p class="' . esc_attr( $base ) . '__posted-date">Posted: ' . $card['Details']['posted_date'] . '</p>';
		endif;
		Template::build_button( $base, $card['Details']['link'], false, true )
		?>
	</article>
</div>




