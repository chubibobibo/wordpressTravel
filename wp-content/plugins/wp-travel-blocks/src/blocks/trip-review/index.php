<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_review_block_callback( $attributes ) {
	$trip_id = get_the_ID();

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class      = sprintf( 'has-text-align-%s', $align );

	ob_start();
	$count = (int) get_comments_number( $trip_id );
	?>
	<div class="wptravel-block-wrapper  wptravel-block-trip-review <?php echo esc_attr( $class ); ?>">
		<a href="javascript:void(0)" class="wp-travel-count-info">
			<?php printf( _n( '%s Review', '%s Reviews', $count, 'wp-travel' ), esc_html( $count ) ); // @phpcs:ignore ?>
		</a>
	</div>
	<?php
	$html = ob_get_clean();
	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_review_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-review/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-review',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_review_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_review_block' );
