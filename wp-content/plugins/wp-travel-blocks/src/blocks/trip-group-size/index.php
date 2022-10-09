<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_group_size_block_callback( $attributes = array() ) {
	$trip_id    = get_the_ID();
	$group_size = wptravel_get_group_size( $trip_id );

	$strings               = WpTravel_Helpers_Strings::get();
	$group_size_text       = isset( $strings['group_size'] ) ? $strings['group_size'] : __( 'Group size', 'wp-travel' );
	$pax_text              = isset( $strings['bookings']['pax'] ) ? $strings['bookings']['pax'] : __( 'Pax', 'wp-travel' );
	$empty_group_size_text = isset( $strings['empty_results']['group_size'] ) ? $strings['empty_results']['group_size'] : __( 'No Size Limit', 'wp-travel' );

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class = sprintf( ' has-text-align-%s', $align );
	ob_start();
	echo '<div data-align="' . esc_attr( $align ) . '" class="wptravel-block-wrapper wptravel-block-group-size wptravel-block-preview' . $class . '">'; // @phpcs:ignore
	if ( (int) $group_size && $group_size < 999 ) {
		printf( apply_filters( 'wp_travel_template_group_size_text', __( '%1$d %2$s', 'wp-travel' ) ), esc_html( $group_size ), esc_html( ( $pax_text ) ) );
	} else {
		echo esc_html( apply_filters( 'wp_travel_default_group_size_text', $empty_group_size_text ) ); // already filterable label using wp_travel_strings filter so this filter 'wp_travel_default_group_size_text' need to remove in future.
	}
	echo '</div>'; // @phpcs:ignore
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_group_size_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-group-size/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/group-size',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_group_size_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_group_size_block' );
