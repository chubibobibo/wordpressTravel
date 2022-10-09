<?php

function wptravel_blocks_body_class( $classes ) {

	$settings         = wptravel_get_settings();
	$enable_gutenberg = $settings['enable_gutenberg'];
	$classes[]        = 'has-wptravel-block';

	if ( 'yes' === $enable_gutenberg ) {
		$classes[] = 'has-wptravel-block-enabled';
	}
	return $classes;
}

add_filter( 'body_class', 'wptravel_blocks_body_class' );
