<?php
/**
 * Travel One Theme Customizer
 *
 * @package Travel_One
 */


/**
 * Checkbox sanitization function.
 *
 * @param mixed $input Input value.
 * @return void
 */
function travel_one_sanitize_checkbox( $input ) {
	// returns true if checkbox is checked
	return ! empty( $input );
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function travel_one_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'refresh';

	// Adding Primary Color Control.
	$wp_customize->add_setting(
		'site_primary_color',
		array(
			'default'           => '#ca9d13',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_primary_color_control',
			array(
				'label'    => __( 'Primary Color', 'travel-one' ),
				'section'  => 'colors',
				'settings' => 'site_primary_color',
				'priority' => 50,
			)
		)
	);

	// Adding setting and control for hide tagline checkbox.

	$wp_customize->add_setting(
		'hide_site_title',
		array(
			'default'           => false,
			'sanitize_callback' => 'travel_one_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hide_site_title_control',
		array(
			'label'    => __( 'Hide Title', 'travel-one' ),
			'section'  => 'title_tagline',
			'settings' => 'hide_site_title',
			'type'     => 'checkbox',
			'priority' => 50,
		)
	);

	$wp_customize->add_setting(
		'hide_site_description',
		array(
			'default'           => false,
			'sanitize_callback' => 'travel_one_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		'hide_description_control',
		array(
			'label'           => __( 'Hide Tagline', 'travel-one' ),
			'section'         => 'title_tagline',
			'settings'        => 'hide_site_description',
			'type'            => 'checkbox',
			'priority'        => 50,
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'travel_one_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'travel_one_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'travel_one_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function travel_one_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function travel_one_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function travel_one_customize_preview_js() {
	wp_enqueue_script( 'travel-one-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), TRAVEL_ONE_VERSION, true );
}
add_action( 'customize_preview_init', 'travel_one_customize_preview_js' );
