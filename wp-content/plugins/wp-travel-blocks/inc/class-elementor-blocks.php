<?php
/**
 * Widgets Core Files.
 *
 * @package wp-travel-blocks
 */

namespace WPC;

if ( ! class_exists( 'WP_Travel_Elementor_Blocks_Init' ) ) {
	/**
	 * Class Declaration.
	 */
	class WP_Travel_Elementor_Blocks_Init {
		/**
		 * Single Instance of the class.
		 *
		 * @var string $_instance.
		 */
		private static $_instance = null; //phpcs:ignore

		/**
		 * To make sure the plugin load only once.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}
		/**
		 * Includes widgets files.
		 */
		public function include_widgets_files() {
			require_once __DIR__ . '/elementor-widgets/functions.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-trip-search-form.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-trip-type.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-featured-trips.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-trip-tabs.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-trip-facts.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-google-maps.php';
			require_once __DIR__ . '/elementor-widgets/class-wp-travel-elementor-related-trips.php';
		}
		/**
		 * Registering widgets on elementor.
		 */
		public function register_widgets() {
			$this->include_widgets_files();
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Trip_Search_Form() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Trip_Type() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Featured_Trips() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Trip_Tabs() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Trip_Facts() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Google_Maps() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\WP_Travel_Elementor_Related_Trips() );
		}
		/**
		 * Constructor.
		 */
		public function __construct() {
			self::init();
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 99 );
			add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );
			add_filter( 'elementor/editor/localize_settings', array( __CLASS__, 'wp_travel_localize_data' ) );
			add_action( 'elementor/preview/enqueue_scripts', array( __CLASS__, 'preview_scripts' ) );
			add_action( 'elementor/editor/before_enqueue_styles', array( __CLASS__, 'editor_styles' ) );
			// add_filter( 'wp_travel_enqueue_single_assets', array( $this, 'enqueue_wp_travel_scripts' ), 12, 2 );
		}
		/**
		 * Init core.
		 *
		 * @param array $params Core class init parameters.
		 */
		public static function init() {
			// add_action( 'wp_enqueue_scripts', array( __CLASS__, 'view_assets' ) );
		}
		/**
		 * Function for returning WP Travel Trip Type HTML.
		 */
		public static function wp_travel_elementor_trip_type() {
			$trip_type    = array();
			$custom_terms = get_terms( 'itinerary_types' );
			if ( is_array( $custom_terms ) && count( $custom_terms ) > 0 ) {
				foreach ( $custom_terms as $custom_term ) {
					$args        = array(
						'posts_per_page'   => -1,
						'offset'           => 0,
						'orderby'          => 'date',
						'order'            => 'ASC',
						'post_type'        => WP_TRAVEL_POST_TYPE,
						'post_status'      => 'publish',
						'suppress_filters' => true,
						'tax_query'        => array(
							array(
								'taxonomy' => 'itinerary_types',
								'field'    => 'slug',
								'terms'    => $custom_term->slug,
							),
						),
					);
					$itineraries = new \WP_Query( $args );

					if ( $itineraries->have_posts() ) {
						while ( $itineraries->have_posts() ) {
							$itineraries->the_post();
							$trip_id = get_the_ID();
							ob_start();
							if ( function_exists( 'wptravel_get_settings' ) ) {
								wptravel_get_template_part( 'shortcode/itinerary', 'item' );
							} else {
								wp_travel_get_template_part( 'shortcode/itinerary', 'item' );
							}
							$grid = ob_get_contents();
							ob_end_clean();

							ob_start();
							if ( function_exists( 'wptravel_get_settings' ) ) {
								wptravel_get_template_part( 'shortcode/itinerary-item', 'list' );
							} else {
								wp_travel_get_template_part( 'shortcode/itinerary-item', 'list' );
							}
							$list = ob_get_contents();
							ob_end_clean();
							$slug                                        = ! empty( $custom_term->slug ) ? ( $custom_term->slug ) : '';
							$trip_type['all']['grid-view'][ $trip_id ]   = $grid;
							$trip_type['all']['list-view'][ $trip_id ]   = $list;
							$trip_type[ $slug ]['grid-view'][ $trip_id ] = $grid;
							$trip_type[ $slug ]['list-view'][ $trip_id ] = $list;
						}
					}
				}
			}
			wp_reset_postdata();

			return $trip_type;
		}
		/**
		 * Funtion for returning WP Travel Featured trip HTML.
		 */
		public static function wp_travel_elementor_featured_trip() {
			$featured_trips = array();
			$featured_args  = array(
				'posts_per_page'   => -1,
				'offset'           => 0,
				'orderby'          => 'date',
				'order'            => 'ASC',
				'meta_key'         => 'wp_travel_featured',
				'meta_value'       => 'yes',
				'post_type'        => WP_TRAVEL_POST_TYPE,
				'post_status'      => 'publish',
				'suppress_filters' => true,
			);

			$itineraries = new \WP_Query( $featured_args );

			if ( $itineraries->have_posts() ) {
				while ( $itineraries->have_posts() ) {
					$itineraries->the_post();
					$trip_id = get_the_ID();
					ob_start();
					if ( function_exists( 'wptravel_get_settings' ) ) {
						wptravel_get_template_part( 'shortcode/itinerary', 'item' );
					} else {
						wp_travel_get_template_part( 'shortcode/itinerary', 'item' );
					}
					$grid = ob_get_contents();
					ob_end_clean();

					ob_start();
					if ( function_exists( 'wptravel_get_settings' ) ) {
						wptravel_get_template_part( 'shortcode/itinerary-item', 'list' );
					} else {
						wp_travel_get_template_part( 'shortcode/itinerary-item', 'list' );
					}
					$list = ob_get_contents();
					ob_end_clean();

					$featured_trips['grid-view'][ $trip_id ] = $grid;
					$featured_trips['list-view'][ $trip_id ] = $list;
				}
			}
			wp_reset_postdata();

			return $featured_trips;
		}
		/**
		 * Trip Tabs Datas.
		 */
		public static function wp_travel_elementor_trip_tabs_contents( $trip_id = null ) {
			if ( ! $trip_id ) {
				global $post;
				$trip_id = $post->ID;
			}
			$wp_travel_itinerary            = new \WP_Travel_Itinerary( get_post( $trip_id ) );
			$GLOBALS['wp_travel_itinerary'] = $wp_travel_itinerary;
			$trip_tabs                      = array();
			ob_start();
			if ( ! class_exists( 'Wp_Travel_Extras_Frontend' ) ) {
				include_once WP_TRAVEL_ABSPATH . 'inc/class-wp-travel-extras-frontend.php';
			}
			if ( function_exists( 'wptravel_frontend_contents' ) ) {
				wptravel_frontend_contents( $trip_id );
			} else {
				wp_travel_frontend_contents( $trip_id );
			}
			$content = ob_get_contents();
			ob_end_clean();

			$trip_tabs[ $trip_id ] = $content;
			if ( '' === $trip_tabs[ $trip_id ] ) {
				$trip_tabs[ $trip_id ] = __( '*Trip Tabs Not Available.', 'wp-travel-blocks' );
			}
			return $trip_tabs;
		}
		/**
		 * Trips Facts datas.
		 *
		 * @return HTML.
		 * @param int $trip_id ID.
		 */
		public static function wp_travel_elementor_trips_facts_content( $trip_id = null ) {
			if ( ! $trip_id ) {
				global $post;
				$trip_id = $post->ID;
			}
			$trip_facts = array();
			ob_start();
			if ( function_exists( 'wptravel_frontend_trip_facts' ) ) {
				wptravel_frontend_trip_facts( $trip_id );
			} else {
				wp_travel_frontend_trip_facts( $trip_id );
			}
				$content = ob_get_contents();
			ob_end_clean();

			$trip_facts[ $trip_id ] = $content;
			if ( '' === $trip_facts[ $trip_id ] ) {
				$trip_facts[ $trip_id ] = __( '*Trip Facts Not Available.', 'wp-travel-blocks' );
			}
			return $trip_facts;
		}
		/**
		 * Trip Map datas.
		 *
		 * @return HTML.
		 * @param int $trip_id ID.
		 */
		public static function wp_travel_elementor_map( $trip_id = null ) {
			if ( ! $trip_id ) {
				global $post;
				$trip_id = $post->ID;
			}
			$trip_map = array();
			ob_start();
			if ( function_exists( 'wptravel_trip_map' ) ) {
				wptravel_trip_map( $trip_id );
			} else {
				wp_travel_trip_map( $trip_id );
			}
				$content = ob_get_contents();
			ob_end_clean();

			$trip_map[ $trip_id ] = $content;
			return $trip_map;
		}
		/**
		 * Related Trips Data.
		 *
		 * @return HTML.
		 * @param int $trip_id ID.
		 */
		public static function wp_travel_elementor_related_trips( $trip_id = null ) {
			if ( ! $trip_id ) {
				global $post;
				$trip_id = $post->ID;
			}
			$related_trips = array();
			ob_start();
			if ( function_exists( 'wptravel_get_related_post' ) ) {
				wptravel_get_related_post( $trip_id );
			} else {
				wp_travel_get_related_post( $trip_id );
			}
				$content = ob_get_contents();
			ob_end_clean();

			$related_trips[ $trip_id ] = $content;
			return $related_trips;
		}
		/**
		 * Localized Data.
		 *
		 * @param array $localized_settings Localize datas.
		 */
		public static function wp_travel_localize_data( $localized_settings ) {
			global $post;
			$trip_id = 0;
			if ( ! $trip_id ) { // Quick fix. only set one time.
				$trip_id = $post->ID;
			}

			$localized_settings['tripId']        = $trip_id;
			$localized_settings['tripTypes']     = self::wp_travel_elementor_trip_type();
			$localized_settings['featuredTrips'] = self::wp_travel_elementor_featured_trip();
			$localized_settings['tripTabs']      = self::wp_travel_elementor_trip_tabs_contents( $trip_id );
			$localized_settings['tripFacts']     = self::wp_travel_elementor_trips_facts_content();
			$localized_settings['tripMap']       = self::wp_travel_elementor_map();
			$localized_settings['relatedTrips']  = self::wp_travel_elementor_related_trips();
			$localized_settings['i18n']          = array(
				'noTripType'     => __( '*Trips not found.', 'wp-travel-blocks' ),
				'noFeaturedTrip' => __( '*Featured Trip Not Available.', 'wp-travel-blocks' ),
				'noRelatedTrip'  => __( '*Trips Not Found.', 'wp-travel-blocks' ),
			);
			$localized_settings                  = apply_filters( 'wp_travel_elementor_localize_data', $localized_settings );
			return $localized_settings;
		}
		/**
		 * Register/Enqueue Styles For Elementor Editor.
		 *
		 * @return void
		 */
		public static function editor_styles() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			// wp_enqueue_style( 'wp-travel-blocks-admin-style', WP_TRAVEL_ELEMENTOR_BLOCKS_PLUGIN_URI . 'assets/css/style' . $suffix . '.css', array(), WPTRAVEL_BLOCKS_VERSION, 'all' );
		}
		/**
		 * Register/Enqueue Scripts For Elementor Editor.
		 *
		 * @return void
		 */
		public static function preview_scripts() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_dequeue_script( 'wp-travel-maps' );
			if ( is_singular( WP_TRAVEL_POST_TYPE ) ) {
				wp_enqueue_script( 'wp-travel-blocks-admin-style', WPTRAVEL_BLOCKS_PLUGIN_URL . 'assets/js/elementor-editor' . $suffix . '.js', array(), WPTRAVEL_BLOCKS_VERSION, 'all' );
			}
		}
		/**
		 * Enqueue WP Travel Script on Elementor Page.
		 *
		 * @param string $data True or false.
		 * @param int    $trip_id ID.
		 * @return bool
		 */
		public function enqueue_wp_travel_scripts( $data, $trip_id ) {
			$data = \Elementor\Plugin::$instance->db->is_built_with_elementor( $trip_id );

			return $data;
		}
		/**
		 * Adding WP Travel widget category on elementor.
		 *
		 * @param array $elements_manager Elements Manager.
		 */
		public function add_elementor_widget_categories( $elements_manager ) {
			$elements_manager->add_category(
				'wp-travel',
				array(
					'title' => __( 'WP Travel', 'wp-travel-blocks' ),
					'icon'  => 'fa fa-plug',
				)
			);
		}
	}
	// Instantiate Plugin Class.
	WP_Travel_Elementor_Blocks_Init::instance();
}


