<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_map_block_callback( $attributes ) {
	if ( is_admin() ) {
		return false;
	}
	$trip_id     = get_the_ID();
	$get_maps    = wptravel_get_maps(); // Get map data.
	$current_map = $get_maps['selected'];
	$align       = isset( $attributes['align'] ) ? $attributes['align'] : 'center';
	$align_class = ' align' . $align;

	ob_start();
	/**
	 * Load Map as per selected current map in the settings.
	 *
	 * @since 5.0.2
	 */
	do_action( 'wptravel_trip_map_' . $current_map, $trip_id, $get_maps ); // @phpcs:ignore
	$content   = ob_get_clean();
	$client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$class     = ! empty( $attributes['className'] ) ? $attributes['className'] : '';
	$class     = 'wptravel-block-map ' . $class;
	$class    .= $align_class;

	return '<div id="wptravel-section-' . $client_id . '" class="wptravel-block-wrapper ' . esc_attr( $class ) . '">' . $content . '</div>';
}


/**
 * Registers the block on server.
 */
function wptravel_blocks_register_map_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-map/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'wptravel/map',
		array(
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_map_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_map_block' );
