<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_code_block_callback( $attributes ) {
	if ( is_admin() || ! is_singular( 'itineraries' ) ) {
		return false;
	}
	global $wp_travel_itinerary;
	ob_start();
	$client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$align     = ! empty( $attributes['align'] ) ? $attributes['align'] : 'full';
	$class     = ! empty( $attributes['className'] ) ? $attributes['className'] : '';
	$align     = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class     = sprintf( 'wptravel-block-trip-code has-text-align-%s %s', $align, $class );

	?>
	<div class="wptravel-block-wrapper <?php echo esc_attr( $class ); ?>" id="wptravel-section-<?php echo $client_id; ?>">
		<code><?php echo esc_html( $wp_travel_itinerary->get_trip_code() ); ?></code>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_code_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-code/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	// error_log( print_r( $attributes, true ) );

	register_block_type(
		'wptravel/trip-code',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_code_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_code_block' );
