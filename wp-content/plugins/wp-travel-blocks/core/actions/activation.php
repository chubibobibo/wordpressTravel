<?php
/**
 * WP Travel Activation hooks.
 *
 * @package WP_Travel
 */

/**
 * Activation class.
 */
class WpTravel_Blocks_Actions_Activation { // @phpcs:ignore

	/**
	 * Minimum required PHP version.
	 *
	 * @var string
	 */
	public static $min_php_version = '5.6.20';

	/**
	 * Minimum required WP version.
	 *
	 * @var string
	 */
	public static $min_wp_version = '5.4.1';

	/**
	 * Init.
	 *
	 * @param bool $network_enabled Whether network enabled or not.
	 */
	public static function init( $network_enabled ) {
		self::compatibility();
		self::update_db_version();
	}

	/**
	 * Check compatibility before activate.
	 *
	 * @since 4.5.8
	 */
	public static function compatibility() {
		// Check for PHP Compatibility.
		global $wp_version;
		if ( version_compare( PHP_VERSION, self::$min_php_version, '<' ) ) {

			$flag = __( 'PHP', 'wp-travel-blocks' );

			// translators: placeholder for PHP minimum version.
			$version = sprintf( __( '%s or higher', 'wp-travel-blocks' ), self::$min_php_version );
			deactivate_plugins( basename( WPTRAVEL_BLOCKS_PLUGIN_FILE ) );
			// translators: placeholder for PHP word & PHP minimum version.
			$message = sprintf( __( 'WP Travel Gutenberg & Elementor blocks plugin requires %1$s version %2$s to work.', 'wp-travel-blocks' ), $flag, $version );
			wp_die(
				esc_attr( $message ),
				esc_attr( __( 'Plugin Activation Error', 'wp-travel-blocks' ) ),
				array(
					'response'  => 200,
					'back_link' => true,
				)
			);
		}
	}

	/**
	 * Update DB Version.
	 *
	 * @since 4.5.8
	 */
	public static function update_db_version() {
		$current_db_version = get_option( 'wptravel_blocks_version' );
		if ( WPTRAVEL_BLOCKS_VERSION !== $current_db_version ) {
			if ( empty( $current_db_version ) ) {
				/**
				 * Update wp travel blocks version.
				 *
				 * @since 2.1.0
				 */
				update_option( 'wptravel_blocks_user_since', WPTRAVEL_BLOCKS_VERSION );
			}
			update_option( 'wptravel_blocks_version', WPTRAVEL_BLOCKS_VERSION );
		}
	}
}
