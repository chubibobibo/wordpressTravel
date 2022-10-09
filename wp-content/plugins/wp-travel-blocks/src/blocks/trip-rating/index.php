<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_rating_block_callback( $attributes ) {
	$trip_id = get_the_ID();

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class = sprintf( ' has-text-align-%s', $align );

	ob_start();
		$review_color = isset( $attributes['reviewColor'] ) ? $attributes['reviewColor'] : '';
	if ( $review_color ) {
		// Review Gutenberg Block.
		$inline_style  = sprintf( '.wptravel-block-wrapper.wptravel-block-trip-rating .wp-travel-average-review:before{ color: %s}', esc_attr( $review_color ) );
		$inline_style .= sprintf( '.wptravel-block-wrapper.wptravel-block-trip-rating .wp-travel-average-review span{ color: %s}', esc_attr( $review_color ) );

		// $inline_style .= sprintf( '.wp-travel-average-review:before{ color: %s}', esc_attr( $review_color ) );
		// $inline_style .= sprintf( '.wp-travel-average-review span{ color: %s}', esc_attr( $review_color ) );
		// $inline_style .= sprintf( '#wp-travel_rate a.rate_label.fa-star.fas, #wp-travel_rate a:focus{ color: %s}', esc_attr( $review_color ) );

		?>
			<style>
			<?php
			echo $inline_style; // @phpcs:ignore
			?>
			</style>
			<?php
	}
	echo '<div class="wptravel-block-wrapper wptravel-block-trip-rating ' . esc_attr( $class ) . '">'; // @phpcs:ignore
	wptravel_single_trip_rating( $trip_id );
	echo '</div>'; // @phpcs:ignore
	$html = ob_get_clean();
	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_rating_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-rating/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];

	register_block_type(
		'wptravel/trip-rating',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_rating_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_rating_block' );
