<?php
/**
 * Template Single series properties
 *
 * @package ED_BOILERPLATE_THEME
 */

if ( ! defined( 'ABSPATH' ) ):
	exit();
endif;

$allowed_attributes = [
	'wheel-diameter',
	'tread-width',
	'overall-height',
	'pa_plate-dimension',
	'pa_bore-diameter',
	'pa_hole-spacing',
	'hole-width',
	'hub-length',
	'carry-capacity-kg-4km/h',
	'unit-weight',
	'pa_shore-hardness',
	'offset',
	'bolt-hole-ball-race-diameter',
	'pa_bolt-hole-diameter',
	'Thread/Stem Height',
	'Thread/Stem Width',
];

function get_grouped_product_children( object $product ): array {
	$children = [];
	if ( $product && $product->is_type( 'grouped' ) ) {
		$child_ids = $product->get_children();

		foreach ( $child_ids as $child_id ) {
			if ( false !== $child_id ) {
				$_pf     = new WC_Product_Factory();
				$product = $_pf->get_product( $child_id );
			}

			$children[] = $product;
		}
	}


	return $children;
}

function check_attribute_existence( array $children, string $attribute ): bool {

	foreach ( $children as $child ) {
		if ( false !== $child && $child->get_attribute( $attribute ) ) {
			return true;
		}
	}

	return false;
}

$base    = 'single-product-specification';
$product = wc_get_product( get_the_ID() );


$product_children   = get_grouped_product_children( $product );
$display_attributes = [];

foreach ( $allowed_attributes as $attribute ) {
	if ( check_attribute_existence( $product_children, $attribute ) ) {
		$display_attributes[] = $attribute;
	}
}

// Check for temperature attributes separately
$temp_from_exists = check_attribute_existence( $product_children, 'temp-from' );
$temp_to_exists   = check_attribute_existence( $product_children, 'temp-to' );
if ( $temp_from_exists && $temp_to_exists ) {
	$display_attributes[] = 'temperature';
}

if ( ! empty( $product_children ) ):
	// Grouping products by 'pa_bore-type'
	$grouped_products = [];
	foreach ( $product_children as $child_product ) {
		if ( false !== $child_product ) {
			$bore_value                        = $child_product->get_attribute( 'pa_bore-type' );
			$grouped_products[ $bore_value ][] = $child_product;
		}
	}

	// Sort products within each group by wheel-diameter
	foreach ( $grouped_products as &$grouped_product_children ) {
		usort( $grouped_product_children, function ( $a, $b ) {
			$wheel_diameter_a = floatval( $a->get_attribute( 'wheel-diameter' ) );
			$wheel_diameter_b = floatval( $b->get_attribute( 'wheel-diameter' ) );
			if ( $wheel_diameter_a == $wheel_diameter_b ) {
				return 0;
			}

			return $wheel_diameter_a < $wheel_diameter_b ? - 1 : 1;
		} );
	}
	unset( $grouped_product_children );

	// Unset reference to avoid accidental modification
	?>

	<section class="<?php echo esc_attr( $base ); ?>">
		<div class="<?php echo esc_attr( $base ); ?>__inner">
			<article class="<?php echo esc_attr( $base ); ?>__article">
				<h4 class="<?php echo esc_attr( $base ); ?>__headline">Product Specification</h4>
			</article>

			<?php foreach (
				$grouped_products
				as $bore_value => $grouped_product_children
			): ?>
				<h5>Bore Type - <?php echo $bore_value; ?></h5>
				<div class="<?php echo esc_attr( $base ); ?>__grid">
					<div class="<?php echo esc_attr( $base ); ?>__grid__inner">
						<div class="<?php echo esc_attr( $base ); ?>__grid__item">
							<p class="<?php echo esc_attr( $base ); ?>__grid__value">Part Number</p>
						</div>
						<?php foreach ( $display_attributes as $attribute ):
							if ( $attribute == 'temperature' ) {
								$label = 'temperature';
							} else {
								$label = preg_replace( '/^pa_pir-/i', '', $attribute );
								$label = preg_replace( '/^pa\s+/i', '', $label );
								$label = preg_replace( '/^pa_/i', '', $label );
								$label = preg_replace( '/^Aut_/i', '', $label );
							} ?>
							<div class="<?php echo esc_attr( $base ); ?>__grid__item">
								<svg
									class="<?php echo strtolower(
										str_replace( ' ', '-', esc_attr( $base ) )
									); ?>__grid__icon">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
										 xlink:href="#icon-<?php echo strtolower(
											 str_replace( ' ', '-', esc_attr( $label ) )
										 ); ?>"></use>
								</svg>
								<span
									class="<?php echo esc_attr( $base ); ?>__grid__popup"><?php echo esc_html(
										ucwords( str_replace( [ '_', '-' ], ' ', $attribute ) )
									); ?></span>
							</div>
						<?php
						endforeach; ?>
						<div class="<?php echo esc_attr( $base ); ?>__grid__item">
							<span class="<?php echo esc_attr( $base ); ?>__grid__popup">CAD Drawing</span>
						</div>
					</div>

					<?php foreach ( $grouped_product_children as $child_product ): ?>
						<div class="<?php echo esc_attr( $base ); ?>__grid__inner">
							<div class="<?php echo esc_attr( $base ); ?>__grid__item">
								<p class="<?php echo esc_attr( $base ); ?>__grid__value"><?php echo esc_html(
										$child_product->get_sku() ?: 'N/A'
									); ?></p>
							</div>
							<?php foreach ( $display_attributes as $attribute ): ?>
								<div class="<?php echo esc_attr( $base ); ?>__grid__item">
									<p class="<?php echo esc_attr( $base ); ?>__grid__value"><?php
										$value = '';
										if ( $attribute == 'temperature' ) {
											$temp_from = $child_product->get_attribute( 'temp-from' );
											$temp_to   = $child_product->get_attribute( 'temp-to' );
											$value     = $temp_from . ' to ' . $temp_to;
										} else {
											$value = $child_product->get_attribute( $attribute );
											if ( is_array( $value ) ) {
												$value = implode( ', ', $value );
											} elseif ( is_object( $value ) ) {
												$value = $value->toString();
											}
										}
										echo esc_html( $value );
										?></p>
								</div>
							<?php endforeach; ?>
							<div class="<?php echo esc_attr( $base ); ?>__grid__item">
								<a href="<?php echo esc_url(
									site_url( '/aut/contact-us?part-number=' . $child_product->get_sku() )
								); ?>"
								   class="<?php echo esc_attr( $base ); ?>__grid__value <?php echo esc_attr(
									   $base
								   ); ?>__grid__value--link">Request<br>Drawing</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>

		</div>
	</section>
<?php
endif; ?>
