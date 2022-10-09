<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_wishlists_block_callback( $attributes ) {
	// Options / Attributes
	$trip_id         = get_the_ID();

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class      = sprintf( ' has-text-align-%s', $align );

	ob_start();
	?>
	<div data-align="<?php echo esc_attr( $align ); ?>" class="wptravel-block-wrapper <?php echo esc_attr( $class ); ?>">
		<?php if ( function_exists('wp_travel_wishlists_show_button') ) {wp_travel_wishlists_show_button( get_the_ID() );} ?>
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_wishlists_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-wishlists/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/wishlists',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_wishlists_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_wishlists_block' );
