<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_tabs_block_callback( $attributes ) {
	if ( is_admin() ) {
		return '<div></div>';
	}
	ob_start();
	$trip_id     = get_the_ID();
	$align       = isset( $attributes['align'] ) ? $attributes['align'] : 'center';
	$align_class = 'align' . $align;
	echo '<div class="wptravel-block-wrapper wptravel-block-tabs ' . esc_attr( $align_class ) . '">'; //@phpcs:ignore
	wptravel_frontend_contents( $trip_id );
	echo '</div>'; //@phpcs:ignore

	return ob_get_clean();
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_tabs_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-tabs/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'wptravel/tabs',
		array(
			// 'api_version' => 2,
			'attributes' => $metadata['attributes'],
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_tabs_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_tabs_block' );
