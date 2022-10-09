<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_duration_block_callback( $attributes ) {
	$trip_id = get_the_ID();

	$strings = WpTravel_Helpers_Strings::get();

	$fixed_departure = WP_Travel_Helpers_Trip_Dates::is_fixed_departure( $trip_id );
	$type            = $fixed_departure ? 'type-fixed-departure' : 'type-trip-duartion';

	$trip_duration       = get_post_meta( $trip_id, 'wp_travel_trip_duration', true );
	$trip_duration       = ( $trip_duration ) ? $trip_duration : 0;
	$trip_duration_night = get_post_meta( $trip_id, 'wp_travel_trip_duration_night', true );
	$trip_duration_night = ( $trip_duration_night ) ? $trip_duration_night : 0;

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class = sprintf( ' has-text-align-%s', $align );

	ob_start();
	echo '<div class="wptravel-block-wrapper wptravel-block-trip-duration-date ' . $class . '">'; // @phpcs:ignore
	if ( $fixed_departure ) {
		$dates = wptravel_get_fixed_departure_date( $trip_id );
		if ( $dates ) {
			?>
			<div class="travel-info trip-fixed-departure <?php echo esc_attr( $type ); ?>">
				<span class="value">
					<?php echo $dates; // @phpcs:ignore ?>
				</span>
			</div>
			<?php
		}
	} else {
		if ( ( $trip_duration || $trip_duration_night ) ) :
			?>
		   <div class="travel-info trip-duration <?php echo esc_attr( $type ); ?>">
			   <span class="value">
				   <?php printf( __( '%1$s Day(s) %2$s Night(s)', 'wp-travel' ), $trip_duration, $trip_duration_night ); ?>
			   </span>
		   </div>
			<?php
	   endif;
	}
	echo '</div>'; // @phpcs:ignore
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_duration_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	// Load attributes from block.json.
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-duration/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-duration-date',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_duration_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_duration_block' );
