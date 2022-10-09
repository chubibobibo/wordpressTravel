<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_location_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/_deprecated-blocks/trip-location/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wp-travel/trip-location',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_list_block_callback', // Callback from new block.
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_location_block' );
