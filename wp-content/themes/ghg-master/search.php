<?php

use BOILERPLATE_THEME\Core\Module\Queries;

$base        = 'search-section';
$total_count = 0;
get_header();

$product_query = Queries::get_search_results( 'product' );
$post_query    = Queries::get_search_results( 'post' );
$page_query    = Queries::get_search_results( 'page' );
$query         = Queries::get_search_results();
$queries       = [ $product_query, $page_query, $post_query, ];

?>
	<section class="<?php echo esc_attr( $base ); ?>">
		<div class="<?php echo esc_attr( $base ); ?>__inner">
			<article class="<?php echo esc_attr( $base ); ?>__article">
				<h4 class="<?php echo esc_attr( $base ); ?>__headline">
					<?php /* translators: %s: search term */ ?>
					<?php echo esc_html( sprintf( __( 'Search Results for " %s "', 'BOILERPLATE_THEME' ), ucfirst( get_search_query() ) ) ); ?></h4>
				<p class="<?php echo esc_attr( $base ); ?>__search-count">
					<?php echo esc_html( $query->found_posts ) . ' results found.'; ?>
				</p>
			</article>
			<?php
			foreach ( $queries as $q ):
				if ( $q->have_posts() ) :
					$product_type = $q->query_vars['post_type'] ?? '';
					if ( 'post' == $product_type ):
						$product_type = 'News and Media';
					endif;
					echo '<h5 class="' . esc_attr( $base ) . '__headline-type">' . $product_type . ' results</h5>';
					?>
					<div class="<?php echo esc_attr( $base ); ?>__grid">
						<?php
						while ( $q->have_posts() ) :
							$q->the_post();
							$post_type = get_post_type( get_the_ID() );
							get_template_part( 'template-parts/search-cards/' . $post_type );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				<?php
				endif;
			endforeach;
			if ( ! $query->have_posts() ) :?>
				<article class="<?php echo esc_attr( $base ); ?>__content">
					<p class="<?php echo esc_attr( $base ); ?>__no-results">
						<?php /* translators: %s: search term */ ?>
						<?php echo esc_html( sprintf( __( 'No results have been found for %s . Try changing your search terms and try again.', 'ED_BOILERPLATE_THEME' ), ucfirst( get_search_query() ) ) ); ?>
					</p>
				</article>
			<?php endif; ?>
		</div>
	</section>
<?php
get_footer();
