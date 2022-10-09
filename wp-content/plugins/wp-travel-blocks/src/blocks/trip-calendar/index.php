<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_calendar_block_callback( $attributes ) {
	// Options / Attributes
	$trip_id  = get_the_ID();
	$taxonomy = isset( $attributes['tripTaxonomy'] ) ? $attributes['tripTaxonomy'] : 'itinerary_types';
	$terms    = get_the_term_list( $trip_id, $taxonomy, '', ', ', '' ); // post_id, taxonomy, before, seperator, after

	$align        = ! empty( $attributes['textAlign'] ) ? $attributes['textAlign'] : 'left';
	$class        = sprintf( ' has-text-align-%s', $align );
	$inline       = isset( $attributes['displayInline'] ) ? $attributes['displayInline'] : true;
	$tooltip      = isset( $attributes['showTooltip'] ) ? $attributes['showTooltip'] : true;
	$tooltip_text = isset( $attributes['tooltipText'] ) ? $attributes['tooltipText'] : __( 'Select a Date to view available pricings and other options.' );
	ob_start();
	?>
	<div id="wptravel-block-trip-calendar" data-inline="<?php echo esc_attr( $inline ); ?>" data-tooltip="<?php echo esc_attr( $tooltip ); ?>" data-tooltip_text="<?php echo esc_attr( $tooltip_text ); ?>" class="wptravel-block-wrapper wptravel-block-trip-calendar wp-travel-calendar-view <?php echo esc_attr( $class ); ?>">
		
	</div>
	<?php
	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_calendar_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-calendar/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];

	// Check if this is the intended custom post type
	// if ( is_admin() ) {
	// global $pagenow;
	// $typenow = '';
	// if ( 'post-new.php' === $pagenow ) {
	// if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) ) {
	// $typenow = $_REQUEST['post_type'];
	// };
	// } elseif ( 'post.php' === $pagenow ) {
	// if ( isset( $_GET['post'] ) && isset( $_POST['post_ID'] ) && (int) $_GET['post'] !== (int) $_POST['post_ID'] ) {
	// Do nothing
	// } elseif ( isset( $_GET['post'] ) ) {
	// $post_id = (int) $_GET['post'];
	// } elseif ( isset( $_POST['post_ID'] ) ) {
	// $post_id = (int) $_POST['post_ID'];
	// }
	// if ( $post_id ) {
	// $post    = get_post( $post_id );
	// $typenow = $post->post_type;
	// }
	// }
	// if ( ! $typenow ) {
	// return;
	// }
	// if ( 'itineraries' !== $typenow && ! $metadata['isGlobal'] ) {
	// return;
	// }
	// }
	register_block_type(
		'wptravel/trip-calendar',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_calendar_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_calendar_block' );
