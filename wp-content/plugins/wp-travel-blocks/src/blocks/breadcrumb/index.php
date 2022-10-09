<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_breadcrumb_block_callback( $attributes ) {
	$client_id   = ! empty( $attributes['blockClientId'] ) ? $attributes['blockClientId'] : '';
	$align       = isset( $attributes['contentJustification'] ) ? $attributes['contentJustification'] : 'left';
	$align_class = 'is-content-justification-' . $align;

	// Styles
	$text_style = '';
	if ( ! empty( $attributes['textColor'] ) ) {
		$text_style = sprintf( '.wptravel-block-breadcrumb li{ color: %s}', $attributes['textColor'] );
	}
	$link_hover_style = '';
	if ( ! empty( $attributes['textHoverColor'] ) ) {
		$link_hover_style = sprintf( '.wptravel-block-breadcrumb li:hover a{ color: %s}', $attributes['textHoverColor'] );
	}

	ob_start();
	if ( $text_style || $link_hover_style ) {
		?>
		<style>
			<?php
				echo $text_style;
				echo $link_hover_style;
			?>
		</style>
		<?php
	}

	/**
	 * Support for for yoast breadcrumb.
	 */
	$use_yoast_breadcrumbs = function_exists( 'yoast_breadcrumb' ) && yoast_breadcrumb( '', '', false ) ? true : false;

	if ( ! is_front_page() ) :
		?>
		<div id="wptravel-section-<?php echo $client_id; ?>" class="wptravel-block-wrapper wptravel-block-breadcrumb <?php echo $align_class; ?>">
		<?php
		if ( $use_yoast_breadcrumbs ) {
			yoast_breadcrumb( '<div id="breadcrumb">', '</div>' );
		} else {
			echo wptravel_breadcrumb_trail(
				$args = array(
					'container'   => 'div',
					'show_browse' => false,
				)
			);
		}
		?>
		</div> <!-- Breadcrumbs-end -->
		<?php
	endif;

	$html = ob_get_clean();

	return $html;
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_breadcrumb_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/breadcrumb/block.json';
	$metadata   = json_decode( ob_get_clean(), true );
	$attributes = $metadata['attributes'];
	register_block_type(
		'wptravel/breadcrumb',
		array(
			'attributes'      => $attributes,
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_breadcrumb_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_breadcrumb_block' );
