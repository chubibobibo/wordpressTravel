<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_enquiry_block_callback( $attributes ) {
	extract( $attributes );
	global $post;
	$show_trip_dropdown = WP_TRAVEL_POST_TYPE === $post->post_type ? false : true;
	ob_start();
	echo '<div class="wptravel-block-wrapper wptravel-block-trip-enquiry">';
	if ( function_exists( 'wptravel_get_enquiries_form' ) ) {
		wptravel_get_enquiries_form( $show_trip_dropdown );
	} else {
		wp_travel_get_enquiries_form( $show_trip_dropdown );
	}
	echo '</div>';
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_enquiry_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-enquiry/block.json';
	$metadata = json_decode( ob_get_clean(), true );
	register_block_type(
		'wptravel/trip-enquiry',
		array(
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_enquiry_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_enquiry_block' );
