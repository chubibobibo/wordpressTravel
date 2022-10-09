<?php
/**
 * Load assets for our blocks.
 *
 * @package WPTravel_Blocks
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load general assets for our blocks.
 *
 * @since 1.0.0
 */
class WPTravel_Blocks_Block_Assets {


	/**
	 * This plugin's instance.
	 *
	 * @var WPTravel_Blocks_Block_Assets
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 *
	 * @return WPTravel_Blocks_Block_Assets
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new WPTravel_Blocks_Block_Assets();
		}

		return self::$instance;
	}

	/**
	 * The Constructor.
	 */
	public function __construct() {
		add_action( 'enqueue_block_assets', array( $this, 'block_assets' ) );
		add_action( 'init', array( $this, 'editor_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'add_block_inline_css' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Loads the asset file for the given script or style.
	 * Returns a default if the asset file is not found.
	 *
	 * @param string $filepath The name of the file without the extension.
	 *
	 * @return array The asset file contents.
	 */
	public function get_asset_file( $filepath ) {
		$asset_path = WPTRAVEL_BLOCKS_PLUGIN_DIR . $filepath . '.asset.php';

		return file_exists( $asset_path )
			? include $asset_path
			: array(
				'dependencies' => array(),
				'version'      => WPTRAVEL_BLOCKS_VERSION,
			);
	}

	/**
	 * Enqueue block assets for use within Gutenberg.
	 *
	 * @access public
	 */
	public function block_assets() {
		global $post;

		// Only load the front end CSS if a WPTravel_Blocks is in use.
		$has_wptravel_blocks = ! is_singular();

		if ( ! is_admin() && is_singular() ) {
			$wp_post = get_post( $post );

			// This is similar to has_block() in core, but will match anything
			// in the wptravel_blocks/* namespace.
			if ( $wp_post instanceof WP_Post ) {
				$has_wptravel_blocks = ! empty(
					array_filter(
						array(
							false !== strpos( $wp_post->post_content, '<!-- wp:wptravel/' ),
							has_block( 'core/block', $wp_post ),
							has_block( 'core/button', $wp_post ),
							has_block( 'core/cover', $wp_post ),
							has_block( 'core/heading', $wp_post ),
							has_block( 'core/image', $wp_post ),
							has_block( 'core/gallery', $wp_post ),
							has_block( 'core/list', $wp_post ),
							has_block( 'core/paragraph', $wp_post ),
							has_block( 'core/pullquote', $wp_post ),
							has_block( 'core/quote', $wp_post ),
						)
					)
				);
			}
		}

		if ( ! $has_wptravel_blocks && ! $this->is_page_gutenberg() ) {
			return;
		}

		// Styles.
		$name       = 'wptravel-blocks-style';
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );
		$rtl        = ! is_rtl() ? '' : '-rtl';

		wp_enqueue_style(
			'wptravel-blocks-frontend',
			WPTRAVEL_BLOCKS_PLUGIN_URL . $filepath . $rtl . '.css',
			array(),
			$asset_file['version']
		);
	}

	/**
	 * Enqueue block assets for use within Gutenberg.
	 *
	 * @access public
	 */
	public function editor_assets() {

		$deps = array( 'wp-api', 'wp-travel-admin-script', 'wp-travel-admin-trip-options' );

		// if ( has_block( 'wptravel/tabs' ) ) {
			$deps[] = 'wp-travel-slick';
		// }
		// Styles.
		$name       = 'wptravel-blocks-editor';
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );
		$rtl        = ! is_rtl() ? '' : '-rtl';

		wp_register_style(
			'wptravel-blocks-editor',
			WPTRAVEL_BLOCKS_PLUGIN_URL . $filepath . $rtl . '.css',
			array(),
			$asset_file['version']
		);

		// Scripts.
		$name       = 'wptravel-blocks'; // wptravel_blocks.js.
		$filepath   = 'dist/' . $name;
		$asset_file = $this->get_asset_file( $filepath );

		wp_register_script(
			'wptravel-blocks-editor',
			WPTRAVEL_BLOCKS_PLUGIN_URL . $filepath . '.js',
			array_merge( $asset_file['dependencies'], $deps ),
			$asset_file['version'],
			true
		);

		$post_id = filter_input( INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT );

		wp_localize_script(
			'wptravel-blocks-editor',
			'wptravel_blocks_block_data',
			array(
				'wptravel_plugin_directory_url' => esc_url( plugin_dir_url( WP_TRAVEL_PLUGIN_FILE ) ),
				'plugin_directory_url'          => esc_url( WPTRAVEL_BLOCKS_PLUGIN_URL ),
			)
		);
	}

	/**
	 * Enqueue front-end assets for blocks.
	 *
	 * @access public
	 * @since 1.9.5
	 */
	public function frontend_scripts() {

		// Scripts.
		$name       = 'wptravel-blocks-frontend'; // wptravel_blocks.js.
		$filepath   = 'dist/js/' . $name;
		$asset_file = $this->get_asset_file( $filepath );

		$deps = array();
		if ( has_block( 'wptravel/tabs' ) ) {
			$deps[] = 'wp-travel-slick';
		}

		// Enqueue for wptravel_blocks animations.
		wp_enqueue_script(
			'wptravel-blocks-frontend',
			WPTRAVEL_BLOCKS_PLUGIN_URL . $filepath . '.js',
			$deps,
			WPTRAVEL_BLOCKS_VERSION,
			true
		);
	}

	/**
	 * Admin Scripts
	 */
	public function admin_scripts() {
		// Scripts.
		$settings_handle = 'wptravel-blocks-settings';
		$filepath        = 'dist/' . $settings_handle;
		$asset_file      = $this->get_asset_file( $filepath );
		wp_register_script( $settings_handle, WPTRAVEL_BLOCKS_PLUGIN_URL . $filepath . '.js', $asset_file['dependencies'], $asset_file['version'], true );

		if ( WP_Travel::is_page( 'settings', true ) ) {
			wp_enqueue_script( $settings_handle );
		}
	}

	/**
	 * Enqueue editor scripts for blocks.
	 *
	 * @access public
	 * @since 1.9.5
	 */
	public function editor_scripts() {
		// Define where the vendor asset is loaded from.
		$vendors_dir = WPTravel_Blocks()->asset_source( 'js', 'vendors' );

		// Required by the events block.
		wp_enqueue_script(
			'wptravel-blocks-slick',
			$vendors_dir . '/slick.js',
			array( 'jquery' ),
			WPTRAVEL_BLOCKS_VERSION,
			true
		);
	}

	/**
	 * Return whether a post type should display the Block Editor.
	 *
	 * @param string $post_type The post_type slug to check.
	 */
	protected function is_post_type_gutenberg( $post_type ) {
		return use_block_editor_for_post_type( $post_type );
	}

	/**
	 * Return whether the page we are on is loading the Block Editor.
	 */
	protected function is_page_gutenberg() {
		if ( ! is_admin() ) {
			return false;
		}

		$admin_page = wp_basename( esc_url( $_SERVER['REQUEST_URI'] ) );

		if ( false !== strpos( $admin_page, 'post-new.php' ) && empty( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		if ( false !== strpos( $admin_page, 'post-new.php' ) && isset( $_GET['post_type'] ) && $this->is_post_type_gutenberg( $_GET['post_type'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return true;
		}

		if ( false !== strpos( $admin_page, 'post.php' ) ) {
			$wp_post = get_post( $_GET['post'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			if ( isset( $wp_post ) && isset( $wp_post->post_type ) && $this->is_post_type_gutenberg( $wp_post->post_type ) ) {
				return true;
			}
		}

		if ( false !== strpos( $admin_page, 'revision.php' ) ) {
			$wp_post     = get_post( $_GET['revision'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$post_parent = get_post( $wp_post->post_parent );
			if ( isset( $post_parent ) && isset( $post_parent->post_type ) && $this->is_post_type_gutenberg( $post_parent->post_type ) ) {
				return true;
			}
		}
		return false;
	}

	/**
	 * Add inline css
	 *
	 * @return void
	 */
	public static function add_block_inline_css() {
		wp_dequeue_style( 'wp-travel-frontend' );
		wp_enqueue_style( 'wp-travel-frontend-v2' );
		if ( is_singular() ) {
			global $post;
			$post_meta                  = get_post_meta( $post->ID );
			$wptravel_blocks_custom_css = ! empty( $post_meta['wptravel_blocks_custom_css'][0] ) ? $post_meta['wptravel_blocks_custom_css'][0] : '';
			wp_add_inline_style( 'wptravel-blocks-frontend', $wptravel_blocks_custom_css );
		}

	}

}

WPTravel_Blocks_Block_Assets::register();
