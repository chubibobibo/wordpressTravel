<?php
/**
 * The plugin gutenberg block Initializer.
 *
 * @link       https://shapedplugin.com/
 * @since      3.0.0
 *
 * @package    location_weather
 * @subpackage location_weather/Admin
 * @author     ShapedPlugin <support@shapedplugin.com>
 */

namespace ShapedPlugin\Weather\Admin\Gutenberg_Block;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gutenberg_Block_Init class.
 */
class Gutenberg_Block_Init {
	/**
	 * Script and style suffix
	 *
	 * @since 3.0.0
	 * @access protected
	 * @var string
	 */
	protected $suffix;
	/**
	 * Custom Gutenberg Block Initializer.
	 */
	public function __construct() {
		$this->suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || defined( 'WP_DEBUG' ) && WP_DEBUG ? '' : '.min';
		add_action( 'init', array( $this, 'location_weather_gutenberg_shortcode_block' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'location_weather_block_editor_assets' ) );
	}

	/**
	 * Register block editor script for backend.
	 */
	public function location_weather_block_editor_assets() {
		wp_enqueue_script(
			'sp-location-weather-shortcode-block',
			plugins_url( '/Gutenberg_Block/build/index.js', dirname( __FILE__ ) ),
			array( 'jquery' ),
			LOCATION_WEATHER_VERSION,
			true
		);

		/**
		 * Register block editor css file enqueue for backend.
		 */
		wp_enqueue_style( 'splw-styles', LOCATION_WEATHER_ASSETS . '/css/splw-style' . $this->suffix . '.css', array(), LOCATION_WEATHER_VERSION, 'all' );
		wp_enqueue_style( 'splw-old-styles', LOCATION_WEATHER_ASSETS . '/css/old-style' . $this->suffix . '.css', array(), LOCATION_WEATHER_VERSION, 'all' );
	}
	/**
	 * Shortcode list.
	 *
	 * @return array
	 */
	public function location_weather_post_list() {
		$shortcodes = get_posts(
			array(
				'post_type'      => 'location_weather',
				'post_status'    => 'publish',
				'posts_per_page' => 9999,
			)
		);

		if ( count( $shortcodes ) < 1 ) {
			return array();
		}

		return array_map(
			function ( $shortcode ) {
				return (object) array(
					'id'    => absint( $shortcode->ID ),
					'title' => esc_html( $shortcode->post_title ),
				);
			},
			$shortcodes
		);
	}

	/**
	 * Register Gutenberg shortcode block.
	 */
	public function location_weather_gutenberg_shortcode_block() {
		/**
		 * Register block editor js file enqueue for backend.
		 */

		wp_register_script( 'splw-old-script', LOCATION_WEATHER_ASSETS . '/js/Old-locationWeather' . $this->suffix . '.js', array( 'jquery' ), LOCATION_WEATHER_VERSION, true );

		wp_localize_script(
			'splw-old-script',
			'sp_location_weather',
			array(
				'ajax_url'      => admin_url( 'admin-ajax.php' ),
				'url'           => LOCATION_WEATHER_URL,
				'loadScript'    => LOCATION_WEATHER_ASSETS . '/js/Old-locationWeather' . $this->suffix . '.js',
				'link'          => admin_url( 'post-new.php?post_type=location_weather' ),
				'shortCodeList' => $this->location_weather_post_list(),
			)
		);
		$setting_options            = get_option( 'location_weather_settings', true );
			$skip_cache_for_weather = isset( $setting_options['splw_skipping_cache'] ) ? $setting_options['splw_skipping_cache'] : false;
			wp_localize_script(
				'splw-old-script',
				'splw_ajax_object',
				array(
					'ajax_url'        => admin_url( 'admin-ajax.php' ),
					'splw_nonce'      => wp_create_nonce( 'splw_nonce' ),
					'splw_skip_cache' => $skip_cache_for_weather,
				)
			);
		/**
		 * Register Gutenberg block on server-side.
		 */
		register_block_type(
			'sp-location-weather-pro/shortcode',
			array(
				'attributes'      => array(
					'shortcodelist'      => array(
						'type'    => 'object',
						'default' => '',
					),
					'shortcode'          => array(
						'type'    => 'string',
						'default' => '',
					),
					'showInputShortcode' => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'preview'            => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'is_admin'           => array(
						'type'    => 'boolean',
						'default' => is_admin(),
					),
				),
				'example'         => array(
					'attributes' => array(
						'preview' => true,
					),
				),
				// Enqueue blocks.editor.build.js in the editor only.
				'editor_script'   => array(
					'splw-old-script',
				),
				// Enqueue blocks.editor.build.css in the editor only.
				'editor_style'    => array(),
				'render_callback' => array( $this, 'sp_location_weather_render_shortcode' ),
			)
		);
	}

	/**
	 * Render callback.
	 *
	 * @param string $attributes Shortcode.
	 * @return string
	 */
	public function sp_location_weather_render_shortcode( $attributes ) {
		$class_name = '';
		if ( ! empty( $attributes['className'] ) ) {
			$class_name = 'class="' . $attributes['className'] . '"';
		}

		if ( ! $attributes['is_admin'] ) {
			return '<div ' . $class_name . '>' . do_shortcode( '[location-weather id="' . sanitize_text_field( $attributes['shortcode'] ) . '"]' ) . '</div>';
		}

		$splw_id         = intval( $attributes['shortcode'] );
		$custom_css      = '';
		$setting_options = get_option( 'location_weather_settings', true );
		$splw_option     = get_option( $splw_id, 'location_weather_settings', true );
		$splw_meta       = get_post_meta( $splw_id, 'sp_location_weather_generator', true );
		$splw_custom_css = $setting_options['splw_custom_css'];

		include LOCATION_WEATHER_PATH . '/includes/Frontend/dynamic-style.php';

		if ( ! empty( $splw_custom_css ) ) {
			$custom_css .= $splw_custom_css;
		}

		$style = '<style>' . $custom_css . '</style>';

		return $style . '<div id="' . uniqid() . '" ' . $class_name . ' >' . do_shortcode( '[location-weather id="' . sanitize_text_field( $attributes['shortcode'] ) . '"]' ) . '</div>';
	}
}
