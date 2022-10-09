<?php
/**
 * Script class file.
 *
 * @package Location_Weather
 */

namespace ShapedPlugin\Weather\Admin;

/**
 * Script class used to hold the style and script for admin.
 */
class Scripts {

	/**
	 * Script and style suffix
	 *
	 * @var string
	 */
	protected $suffix;

	/**
	 * The constructor of the class.
	 */
	public function __construct() {

		$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) || ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts_handler' ) );
	}

	/**
	 * Frontend script handler.
	 *
	 * @return void
	 */
	public function scripts_handler() {
		$this->lw_styles();
	}

	/**
	 * Register the scripts for the public-facing side of the site.
	 *
	 * @since    2.0.0
	 */
	public function lw_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 */
		wp_enqueue_style( 'splw-admin', LOCATION_WEATHER_ASSETS . '/css/admin' . $this->suffix . '.css', array(), LOCATION_WEATHER_VERSION, 'all' );

		$wpscreen              = get_current_screen();
		$the_current_post_type = $wpscreen->post_type;
		if ( ( 'location_weather' === $the_current_post_type ) ) {
			wp_enqueue_style( 'splw-styles', LOCATION_WEATHER_ASSETS . '/css/splw-style' . $this->suffix . '.css', array(), LOCATION_WEATHER_VERSION, 'all' );
			wp_enqueue_style( 'splw-old-styles', LOCATION_WEATHER_ASSETS . '/css/old-style' . $this->suffix . '.css', array(), LOCATION_WEATHER_VERSION, 'all' );
			wp_enqueue_script( 'splw-old-script', LOCATION_WEATHER_ASSETS . '/js/Old-locationWeather' . $this->suffix . '.js', array( 'jquery' ), LOCATION_WEATHER_VERSION, true );
			wp_localize_script(
				'splw-old-script',
				'splw_ajax_object',
				array(
					'ajax_url'   => admin_url( 'admin-ajax.php' ),
					'splw_nonce' => wp_create_nonce( 'splw_nonce' ),
				)
			);
		}
	}
}
