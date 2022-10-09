<?php
/**
 * To remove over view tab;
 *
 * @package wp-travel-blocks
 */

add_filter(
	'wp_travel_itinerary_tabs',
	function( $return_tabs ) {
		$return_tabs['overview']['show_in_menu'] = 'no';
		return $return_tabs;
	}
);
/**
 * To add content
 */
add_action(
	'wp_travel_single_trip_after_header',
	function() {
		the_content();
	}
);
/**
 * Hide content coming from elementor to tabs content.
 *
 * @param int   $raw Boolean.
 * @param array $tab_key Trip Tabs.
 *
 * @return boolean
 */
function hide_cont( $raw, $tab_key ) {
	if ( 'trip_includes' === $tab_key || 'trip_excludes' === $tab_key ) {
		$raw = true;
	}
	return $raw;
}
add_filter( 'wp_travel_trip_tabs_output_raw', 'hide_cont', 10, 2 );
