<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_reviews_list_block_callback( $attributes ) {
	if ( is_admin() ) {
		return '<div></div>';
	}
	ob_start();
	// $tab_data    = wptravel_get_frontend_tabs();
	// $trip_id     = get_the_ID();
	$align       = isset( $attributes['align'] ) ? $attributes['align'] : 'center';
	$align_class = 'align' . $align;

	// $content = is_array( $tab_data ) && isset( $tab_data['faq'] ) && isset( $tab_data['faq']['content'] ) ? $tab_data['faq']['content'] : '';
	echo '<div id="faq-blocks" class="wptravel-block-wrapper wptravel-block-trip-reviews-list ' . esc_attr( $align_class ) . '">'; //@phpcs:ignore
	comments_template();
	echo '</div>'; //@phpcs:ignore

	return ob_get_clean();
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_reviews_list_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-reviews-list/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-reviews-list',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_reviews_list_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_reviews_list_block' );
