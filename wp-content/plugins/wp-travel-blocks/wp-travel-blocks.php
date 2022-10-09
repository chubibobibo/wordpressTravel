<?php
/**
 * Plugin Name: WP Travel Gutenberg & Elementor blocks
 * Plugin URI: http://wptravel.io/pro
 * Description: WP Travel Gutenberg & Elementor blocks is the easiest, most flexible way to display your Trips using the gutenber or elementor blocks- by location, trip type, featured and Trips on sale on posts and pages!.
 * Version: 2.1.1
 * Author: WP Travel
 * Author URI: http://wptravel.io
 * Requires at least: 5.0.0
 * Requires PHP: 5.6
 * Tested up to: 5.9
 *
 * WP Travel Gutenberg & Elementor blocks is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with WP Travel Gutenberg & Elementor blocks. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package wp-travel-blocks
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Define constants.
define( 'WPTRAVEL_BLOCKS_VERSION', '2.1.1' );
define( 'WPTRAVEL_BLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPTRAVEL_BLOCKS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WPTRAVEL_BLOCKS_PLUGIN_FILE', __FILE__ );
define( 'WPTRAVEL_BLOCKS_PLUGIN_BASE', plugin_basename( __FILE__ ) );

if ( ! class_exists( 'WPTravel_Blocks' ) ) :
	/**
	 * Main WPTravel_Blocks Class.
	 *
	 * @since 1.0.0
	 */
	final class WPTravel_Blocks {
		/**
		 * This plugin's instance.
		 *
		 * @var WPTravel_Blocks
		 * @since 1.0.0
		 */
		private static $instance;

		/**
		 * Main WPTravel_Blocks Instance.
		 *
		 * Insures that only one instance of WPTravel_Blocks exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0.0
		 * @static
		 * @return object|WPTravel_Blocks The one true WPTravel_Blocks
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof WPTravel_Blocks ) ) {
				self::$instance = new WPTravel_Blocks();
				self::$instance->includes();
				self::$instance->init();
			}
			return self::$instance;
		}

		/**
		 * Include required files.
		 *
		 * @return void
		 */
		private function includes() {
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . 'core/actions/activation.php';
			if ( ! class_exists( 'WP_Travel' ) ) {
				return;
			}
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/core/ajax/init.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/core/helpers/init.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . 'inc/template-functions.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . 'inc/settings.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . 'inc/class-register-dynamic-blocks.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . 'inc/class-block-assets.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/inc/class-elementor-blocks.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/inc/breadcrumb-class.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/inc/default-trip-content.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/inc/class-rest.php';
			require_once WPTRAVEL_BLOCKS_PLUGIN_DIR . '/inc/class-templates.php';
		}

		/**
		 * Init the Blocks.
		 */
		private function init() {
			register_activation_hook( __FILE__, array( 'WpTravel_Blocks_Actions_Activation', 'init' ) );
			add_action( 'plugins_loaded', array( $this, 'wptravel_blocks_loader' ), 90 );
		}

		/**
		 * Load Blocks after init.
		 *
		 * @since 2.1.0
		 */
		public function wptravel_blocks_loader() {
			if ( ! class_exists( 'WP_Travel' ) ) {
				return;
			}
			add_filter( 'register_post_type_args', array( $this, 'modify_itineraries_post_type_args' ), 10, 2 );
			$settings         = wptravel_get_settings();
			$enable_gutenberg = $settings['enable_gutenberg'];

			if ( 'yes' === $enable_gutenberg ) {
				remove_action( 'wptravel_single_itinerary_main_content', 'wptravel_single_itinerary_trip_content' );
				add_action( 'wptravel_single_itinerary_main_content', array( $this, 'single_itinerary_trip_content' ) );
			}

			add_filter( 'block_categories_all', array( $this, 'block_categories' ), 10, 2 );
		}

		/**
		 * Modify trip post type support.
		 *
		 * @param array  $args Post type args.
		 * @param string $post_type Current post type.
		 *
		 * @since 2.1.0
		 */
		public function modify_itineraries_post_type_args( $args, $post_type ) {
			$settings         = wptravel_get_settings();
			$enable_gutenberg = isset( $settings['enable_gutenberg'] ) ? $settings['enable_gutenberg'] : 'no';

			if ( 'itineraries' === $post_type && 'yes' === $enable_gutenberg ) {
				$args['supports'][] = 'editor';
			}

			return $args;
		}
		/**
		 * Register Block category.
		 *
		 * @param array  $block_categories List of block categories.
		 * @param object $editor_context Context.
		 *
		 * @since 2.1.0
		 */
		public function block_categories( $block_categories, $editor_context ) {
			if ( ! empty( $editor_context->post ) ) {
				array_push(
					$block_categories,
					array(
						'slug'  => 'wptravel',
						'title' => __( 'WP Travel', 'wp-travel-blocks' ),
						'icon'  => null,
					)
				);
			}
			return $block_categories;
		}

		/**
		 * Single trip content.
		 */
		public function single_itinerary_trip_content() {
			the_content();
		}
	}
endif;

/**
 * The main function for that returns WPTravel_Blocks
 *
 * The main function responsible for returning the one true WPTravel_Blocks
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $wptravel_blocks = WPTravel_Blocks(); ?>
 *
 * @since 1.0.0
 * @return object|WPTravel_Blocks The one true WPTravel_Blocks Instance.
 */
function wptravel_blocks() {
	return WPTravel_Blocks::instance();
}

// Get the plugin running. Load on plugins_loaded action to avoid issue on multisite.
// add_action( 'plugins_loaded', 'wptravel_blocks', 90 );
// if ( function_exists( 'is_multisite' ) && is_multisite() ) {
// } else {
// wptravel_blocks();
// }
wptravel_blocks(); // Need to run activation hook so called it instead of using plugins_loaded hook.
