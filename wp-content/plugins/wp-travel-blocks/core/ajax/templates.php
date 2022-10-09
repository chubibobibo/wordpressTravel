<?php
/**
 * Ajax request for templates.
 *
 * @package WP_Travel_Blocks
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class templates.
 */
class WpTravelBlocks_Ajax_Templates {
	/**
	 * Initialize Ajax request for reset templates.
	 *
	 * @since 2.1.1
	 */
	public static function init() {

		/**
		 * Ajax endpoint to reset All trip templates.
		 *
		 * @since 2.1.1
		 */
		add_action( 'wp_ajax_wptravel_reset_templates', array( __CLASS__, 'reset_all' ) );
		add_action( 'wp_ajax_nopriv_wptravel_reset_templates', array( __CLASS__, 'reset_all' ) );

		/**
		 * Ajax endpoint to reset individual trip template.
		 *
		 * @since 2.1.1
		 */
		add_action( 'wp_ajax_wptravel_reset_template', array( __CLASS__, 'reset' ) );
		add_action( 'wp_ajax_nopriv_wptravel_reset_template', array( __CLASS__, 'reset' ) );
	}

	/**
	 * Reset.
	 *
	 * @since 2.1.0
	 */
	public static function reset_all() {
		$permission = WP_Travel::verify_nonce();

		if ( ! $permission || is_wp_error( $permission ) ) {
			WP_Travel_Helpers_REST_API::response( $permission );
		}

		$payload = json_decode( file_get_contents( 'php://input' ), true ); // Added 2nd Parameter to resolve issue with objects.
		$payload = wptravel_sanitize_array( $payload, true );  // wp kses for some editor content in email settings.

		$response = WpTravelBlocks_Helpers_Templates::reset_all( $payload );
		WP_Travel_Helpers_REST_API::response( $response );
	}

	/**
	 * Reset.
	 *
	 * @since 2.1.0
	 */
	public static function reset() {
		$permission = WP_Travel::verify_nonce();

		if ( ! $permission || is_wp_error( $permission ) ) {
			WP_Travel_Helpers_REST_API::response( $permission );
		}

		$payload = json_decode( file_get_contents( 'php://input' ), true ); // Added 2nd Parameter to resolve issue with objects.
		$payload = wptravel_sanitize_array( $payload, true );  // wp kses for some editor content in email settings.

		$response = WpTravelBlocks_Helpers_Templates::reset( $payload );
		WP_Travel_Helpers_REST_API::response( $response );
	}
}

WpTravelBlocks_Ajax_Templates::init();
