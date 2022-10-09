<?php
/**
 * Helpers for templates.
 *
 * @package WP_Travel_Blocks
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class templates.
 */
class WpTravelBlocks_Helpers_Templates {

	/**
	 * Reset All.
	 *
	 * @since 2.1.0
	 */
	public static function reset_all() {
		global $wpdb;
		$post_type = WP_TRAVEL_POST_TYPE;
		$post_ids  = $wpdb->get_results( $wpdb->prepare( "SELECT ID from {$wpdb->posts} where post_type=%s and post_status in( 'publish', 'draft' )", $post_type ) );

		if ( is_array( $post_ids ) ) {
			foreach ( $post_ids as $trip ) {
				$data = array(
					'trip_id' => $trip->ID,
				);
				self::reset( $data );
			}
		}

		return WP_Travel_Helpers_Response_Codes::get_success_response(
			'WP_TRAVEL_UPDATED_TRIP', // @todo need to change success response code.
			array(
				'trip' => '',
			)
		);
	}

	/**
	 * Reset individual.
	 *
	 * @since 2.1.0
	 */
	public static function reset( $data ) {
		$trip_id            = $data['trip_id'];
		$trip               = get_post( $trip_id );
		$trip->post_content = wptravel_blocks_itineraries_default_content( $trip->post_content, $trip );

		wp_update_post( $trip );

		return WP_Travel_Helpers_Response_Codes::get_success_response(
			'WP_TRAVEL_UPDATED_TRIP',
			array(
				'trip' => '',
			)
		);
	}
}

