<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_category_block_callback( $attributes ) {
	// Options / Attributes
	$trip_id  = get_the_ID();
	$taxonomy = isset( $attributes['tripTaxonomy'] ) ? $attributes['tripTaxonomy'] : 'itinerary_types';
	$terms    = get_the_term_list( $trip_id, $taxonomy, '', ', ', '' ); // post_id, taxonomy, before, seperator, after

	$align = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class = sprintf( ' has-text-align-%s', $align );

	ob_start();
	?>
	<div class="wptravel-block-wrapper wptravel-block-trip-categories <?php echo esc_attr( $class ); ?>">
		<div class="travel-info <?php echo esc_attr( $taxonomy ); ?>">
			<span class="value">

			<?php
			if ( $terms ) {
				echo wp_kses( $terms, wptravel_allowed_html( array( 'a' ) ) );
			} else {
				echo 'N/A';
			}
			?>
			</span>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_category_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-categories/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-categories',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_category_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_category_block' );
