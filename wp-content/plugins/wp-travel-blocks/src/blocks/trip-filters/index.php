<?php
/**
 * Server-side rendering of the `WPTravel_Blocks/container` block.
 *
 * @package WPTravel_Blocks
 */

function wptravel_blocks_trip_filter_block_callback( $attributes ) {
	// Filters
	$keyword_search       = $attributes['keyWordSearch'];
	$fact                 = $attributes['tripFact'];
	$trip_type_filter     = $attributes['tripTypeFilter'];
	$trip_location_filter = $attributes['tripLocationFilter'];
	$price_orderby        = $attributes['priceOrderFilter'];
	$price_range          = $attributes['priceRangeFilter'];
	$trip_dates           = $attributes['tripDateFilter'];

	// $index = uniqid();

	$defaults = array(
		'keyword_search'       => $keyword_search,
		'fact'                 => $fact,
		'trip_type_filter'     => $trip_type_filter,
		'trip_location_filter' => $trip_location_filter,
		'price_orderby'        => $price_orderby,
		'price_range'          => $price_range,
		'trip_dates'           => $trip_dates,
	);

	ob_start();
	?>
	<div class="wptravel-block-wrapper wptravel-block-trip-filters">
		<?php
		wptravel_get_search_filter_form( array( 'widget' => $defaults ) ); // @phpcs:ignore
		?>
	</div>
	<?php

	return ob_get_clean();
}

/**
 * Registers the block on server.
 */
function wptravel_blocks_register_trip_filters_block() {
	// Return early if this function does not exist.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	ob_start();
	include WPTRAVEL_BLOCKS_PLUGIN_DIR . 'src/blocks/trip-filters/block.json';
	$metadata = json_decode( ob_get_clean(), true );

	register_block_type(
		'wptravel/trip-filters',
		array(
			'attributes'      => array(
				'title'              => array(
					'type'    => 'string',
					'default' => __( 'Trips Filter', 'wp-travel-blocks' ),
				),
				'heading'            => array(
					'type'    => 'string',
					'default' => 'h2',
				),
				'keyWordSearch'      => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'tripFact'           => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'tripTypeFilter'     => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'tripLocationFilter' => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'priceOrderFilter'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'priceRangeFilter'   => array(
					'type'    => 'boolean',
					'default' => true,
				),
				'tripDateFilter'     => array(
					'type'    => 'boolean',
					'default' => true,
				),
			),
			'editor_script'   => 'wptravel-blocks-editor',
			'editor_style'    => 'wptravel-blocks-editor',
			'style'           => 'wptravel-blocks-frontend',
			'render_callback' => 'wptravel_blocks_trip_filter_block_callback',
		)
	);
}
add_action( 'init', 'wptravel_blocks_register_trip_filters_block' );
