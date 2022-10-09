<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Travel_One
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function travel_one_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}


	if ( is_post_type_archive( 'itineraries' ) && is_active_sidebar( 'wp-travel-archive-sidebar' ) ) {
		$classes[] = 'sidebar-right';
	}
	// Adds a class of no-sidebar when there is no sidebar present.
	else if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'travel_one_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function travel_one_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'travel_one_pingback_header' );

/**
 * Add a button to top-level menu items that has sub-menus.
 * An icon is added using CSS depending on the value of aria-expanded.
 *
 * @since 1.0.0
 *
 * @param string $output Nav menu item start element.
 * @param object $item   Nav menu item.
 * @param int    $depth  Depth.
 * @param object $args   Nav menu args.
 *
 * @return string Nav menu item start element.
 */
function travel_one_add_sub_menu_toggle( $output, $item, $depth, $args ) {
	if ( 0 === $depth && in_array( 'menu-item-has-children', $item->classes, true ) ) {

		// Add toggle button.
		$output .= '<button class="sub-menu-toggle" aria-expanded="false" onClick="travelOneExpandSubMenu(this)">';
		$output .= '<span class="icon-plus"><i class="ion-ios-arrow-down"></i></span>';
		$output .= '<span class="icon-minus"><i class="ion-ios-arrow-up"></i></span>';
		$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', 'travel-one' ) . '</span>';
		$output .= '</button>';
	}
	return $output;
}
add_filter( 'walker_nav_menu_start_el', 'travel_one_add_sub_menu_toggle', 10, 4 );
