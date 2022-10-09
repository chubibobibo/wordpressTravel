<?php
/**
 * Loads dynamic blocks for server-side rendering.
 *
 * @package WPTravel Blocks
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Register server-side code for individual blocks.
foreach ( glob( dirname( dirname( __FILE__ ) ) . '/src/blocks/_deprecated-blocks/*/index.php' ) as $wptravel_blocks_block_logic ) {
	require_once $wptravel_blocks_block_logic;
}
foreach ( glob( dirname( dirname( __FILE__ ) ) . '/src/blocks/*/index.php' ) as $wptravel_blocks_block_logic ) {
	require_once $wptravel_blocks_block_logic;
}

add_filter( 'gutenberg_can_edit_post_type', 'wptravel_blocks_disable_gutenberg' );
function wptravel_blocks_disable_gutenberg( $current_status, $post_type ) {
	if ( $post_type === 'itineraries' ) {
		return true;
	}
	return $current_status;
}
add_filter( 'register_post_type_args', 'wptravel_post_type_args', 10, 2 );

function wptravel_post_type_args( $args, $post_type ) {

	if ( 'itineraries' === $post_type ) {
		$args['show_in_rest'] = true;
		$args['supports'][]   = 'custom-fields';
	}

	return $args;
}
function wptravel_allowed_block_types( $allowed_block_types, $post ) {
	$block_types = WP_Block_Type_Registry::get_instance()->get_all_registered();
	var_dump( array_keys( $block_types ) );
	// var_dump( $post );
	exit;
	// Limit blocks in 'post' post type.
	if ( $post->post_type === 'itineraries' ) {
		return array( 'wptravel/container' );
		// Return an array containing the allowed block types.
		// if ( isset( $allowed_block_types['wptravel/container'] ) ) {
		// unset( $allowed_block_types['wptravel/container'] );
		// }
	}
	return $allowed_block_types;
}
// add_filter( 'allowed_block_types', 'wptravel_allowed_block_types', 10, 2 );

/**
 * Register meta field.
 *
 * @return void
 */
function wptravel_register_meta_fields() {
	$post_types = array( 'itineraries' );
	$fields     = array(
		'wp_travel_lat'                   => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_lng'                   => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_trip_map_use_lat_lng'  => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_location'              => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_tabs'                  => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_overview'              => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_outline'               => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_trip_include'          => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_trip_exclude'          => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
		'wp_travel_itinerary_gallery_ids' => array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		),
	);

	if ( ! empty( $post_types ) && ! empty( $fields ) ) {
		foreach ( $post_types as $pt ) {
			foreach ( $fields as $meta_key => $field ) {
				register_post_meta( $pt, $meta_key, $field );
			}
		}
	}
}
// add_action( 'init', 'wptravel_register_meta_fields' );
add_action(
	'init',
	function() {

		add_filter(
			'wptravel_use_itinerary_layout_v2',
			function() {
				return true;
			},
			100
		);
	}
);

