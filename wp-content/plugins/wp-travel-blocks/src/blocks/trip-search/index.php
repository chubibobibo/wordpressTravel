<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_search_block_callback( $attributes ) {
	$submission_get = array();

	if ( isset( $_GET['__wp_travel_search_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['__wp_travel_search_nonce'] ) ), '__wp_travel_search_nonce_action' ) ) {
		$submission_get = wptravel_sanitize_array( wp_unslash( $_GET ) );
	}

	$strings = WpTravel_Helpers_Strings::get();

	$label_search             = $strings['search'];
	$label_trip_type          = $strings['trip_type'];
	$label_location           = $strings['location'];
	$label_search_placeholder = $strings['search_placeholder'];

	// Attributes.
	$show_input     = isset( $attributes['showInput'] ) ? $attributes['showInput'] : true; // Legacy Block Compatibility.
	$show_trip_type = isset( $attributes['showTripType'] ) ? $attributes['showTripType'] : true; // Legacy Block Compatibility.
	$show_location  = isset( $attributes['showLocation'] ) ? $attributes['showLocation'] : true; // Legacy Block Compatibility.
	// $show_submit    = $attributes['showSubmit'];
	$args = array(
		'show_input'     => $show_input,
		'show_trip_type' => $show_trip_type,
		'show_location'  => $show_location,
	);

	ob_start(); ?>
	<div class="wptravel-block-wrapper  wptravel-block-trip-search wptravel-block-preview">
		<?php wptravel_search_form( $args ); ?>
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_search_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-search/block.json';
	$metadata = json_decode( ob_get_clean(), true );
	register_block_type(
		'wptravel/trip-search',
		array(
			'attributes'      => array(
				'showInput'    => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showTripType' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showLocation' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'showSubmit'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
			),
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_search_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_search_block' );
