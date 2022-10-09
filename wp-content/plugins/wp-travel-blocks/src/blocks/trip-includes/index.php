<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_includes_block_callback( $attributes ) {
	if ( is_admin() ) {
		return '<div></div>';
	}
	ob_start();
	$tab_data    = wptravel_get_frontend_tabs();
	$trip_id     = get_the_ID();
	$align       = isset( $attributes['align'] ) ? $attributes['align'] : 'center';
	$align_class = 'align' . $align;

	$content = is_array( $tab_data ) && isset( $tab_data['trip_includes'] ) && isset( $tab_data['trip_includes']['content'] ) ? $tab_data['trip_includes']['content'] : '';
	echo '<div class="wptravel-block-wrapper wptravel-block-trip-includes ' . esc_attr( $align_class ) . '">'; //@phpcs:ignore
	echo wpautop( do_shortcode( $content ) ); // @phpcs:ignore
	echo '</div>'; //@phpcs:ignore

	return ob_get_clean();
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_includes_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-includes/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-includes',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_includes_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_includes_block' );
