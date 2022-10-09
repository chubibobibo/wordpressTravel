<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_price_block_callback( $attributes ) {
	// extract( $attributes );
	// Options / Attributes
	$show_from_label    = $attributes['showFromLabel'];
	$hide_regular_price = $attributes['hideRegularPrice'];

	$trip_id = get_the_ID();

	$args                             = array( 'trip_id' => $trip_id );
	$args_regular                     = $args;
	$args_regular['is_regular_price'] = true;
	$trip_price                       = WP_Travel_Helpers_Pricings::get_price( $args );
	$regular_price                    = WP_Travel_Helpers_Pricings::get_price( $args_regular );
	$enable_sale                      = WP_Travel_Helpers_Trips::is_sale_enabled(
		array(
			'trip_id'                => $trip_id,
			'from_price_sale_enable' => true,
		)
	);

	$strings = WpTravel_Helpers_Strings::get();

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class = sprintf( ' has-text-align-%s', $align );

	// Styles
	$text_style = '';
	if ( ! empty( $attributes['color'] ) ) {
		$text_style = sprintf( '.wptravel-block-trip-price .trip-price{ color: %s}', $attributes['color'] );
	}

	ob_start();

	if ( $text_style  ) {
		?>
		<style>
			<?php
			echo $text_style;
			?>
		</style>
		<?php
	}
	?>
	<div class="wptravel-block-wrapper wptravel-block-trip-price <?php echo esc_attr( $class ); ?>">
		<div class="wp-travel-trip-detail">
			<?php if ( $trip_price ) : ?>
				<div class="trip-price" >
				<?php if ( $show_from_label ) : ?>
					<span class="price-from">
						<?php echo esc_html( $strings['from'] ); ?>
					</span>
				<?php endif; ?>
				<?php if ( ! $hide_regular_price && $enable_sale && $regular_price !== $trip_price ) : ?>
					<del><span><?php echo wptravel_get_formated_price_currency( $regular_price, true ); // @phpcs:ignore ?></span></del>
				<?php endif; ?>
					<span class="person-count">
						<ins>
							<span><?php echo wptravel_get_formated_price_currency( $trip_price ); // @phpcs:ignore ?></span>
						</ins>
					</span>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_price_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-price/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-price',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_price_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_price_block' );
