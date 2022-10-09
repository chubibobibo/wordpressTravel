<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_facts_block_callback( $attributes ) {
	ob_start();
	$trip_id   = get_the_ID();
	$client_id = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';

	$align = isset( $attributes['contentJustification'] ) ? $attributes['contentJustification'] : 'left';
	$align_class = 'is-content-justification-' . $align;

	$background_color = 'transparent';
	if ( isset( $attributes['backgroundColor'] ) && ! empty( $attributes['backgroundColor'] ) ) {
		$background_color = $attributes['backgroundColor'];
	}
	?>
	<style>
		.wptravel-block-trip-fact .tour-info .tour-info-box{
			border:none;
			background: <?php echo esc_attr( $background_color ); ?>
		}
	</style>
	<div id="wptravel-section-<?php echo $client_id; ?>" class="wptravel-block-wrapper wptravel-block-trip-fact <?php echo esc_attr( $align_class ); ?>">
		<?php wptravel_frontend_trip_facts( $trip_id ); ?>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_facts_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// Load attributes from block.json.
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-facts/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/trip-facts',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_facts_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_facts_block' );
