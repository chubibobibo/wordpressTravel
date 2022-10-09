<?php

/**
 * Register default settings fields for blocks
 */
function wptravel_blocks_settings_fields( $fields ) {
	$fields['enable_gutenberg']       = 'no';
	$fields['enable_custom_template'] = 'yes';
	$fields['selected_template']      = '';
	return $fields;
}
add_filter( 'wp_travel_settings_fields', 'wptravel_blocks_settings_fields' );

function wptravel_blocks_settings_options_values( $settings_options, $settings ) {
	$args = array(
		'post_type'   => 'wptravel_template',
		'numberposts' => -1,
	);

	$templates = get_posts( $args );

	$templates_array = array();
    $templates_array[] = array(
        'label' => __( 'Select Template' ),
        'value' => '',
    );
	foreach ( $templates as $itinerary ) {
		$templates_array[] = array(
			'label' => $itinerary->post_title,
			'value' => $itinerary->ID,
		);
	}
	$settings_options['templates'] = $templates_array;
	return $settings_options;

}
add_filter( 'wp_travel_settings_options', 'wptravel_blocks_settings_options_values', 20, 2 );
