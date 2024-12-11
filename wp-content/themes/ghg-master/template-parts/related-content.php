<?php
if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif;
$base  = 'related-content';
$query = $args['data']['query'] ?: [];
$card  = $args['data']['card'] ?: '';
?>

<section class="<?php echo esc_attr( $base ); ?> <?php echo esc_attr( $base ); ?>--<?php echo esc_attr( $card ); ?>">
	<div class="<?php echo esc_attr( $base ); ?>__inner">
		<article class="<?php echo esc_attr( $base ); ?>__article">
			<h4 class="<?php echo esc_attr( $base ); ?>__headline">More like this</h4>
		</article>
		<?php if ( $query->have_posts() ) : ?>
			<div class="<?php echo esc_attr( $base ); ?>__grid">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					get_template_part( 'template-parts/cards/' . $card );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php endif; ?>
	</div>
</section>
